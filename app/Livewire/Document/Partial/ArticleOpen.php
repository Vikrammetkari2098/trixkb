<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use TallStackUi\Traits\Interactions;
use App\Models\Article;
use App\Models\ArticleVersion;

class ArticleOpen extends Component
{
    use Interactions, WithFileUploads;

    public $articleId;
    public $title = '';
    public $content = [];
    public $editorImage;
    public $status = 'draft';

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    public function mount($articleId = null)
    {
        if ($articleId) {
            $this->loadArticleData($articleId);
        }
    }

    #[On('openArticle')]
    public function loadArticleData($id)
    {
        $article = Article::find($id);

        if (!$article) return;

        $latestVersion = ArticleVersion::where('article_id', $id)
                            ->orderByDesc('id')
                            ->first();

        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->status = $article->status;

        $rawContent = $latestVersion ? $latestVersion->content : [];

        if (is_string($rawContent)) {
            $this->content = json_decode($rawContent, true) ?? [];
        } elseif (is_array($rawContent)) {
            $this->content = $rawContent;
        } else {
            $this->content = [];
        }

        $this->dispatch('article-loaded', title: $this->title, content: $this->content);
    }

    public function save($editorData = null)
    {
        $dataToSave = $editorData ?? $this->content;
        $contentForDb = empty($dataToSave) ? null : $dataToSave;

        $this->validate();

        $article = Article::find($this->articleId);
        $currentVersion = ArticleVersion::where('article_id', $this->articleId)
                            ->orderByDesc('id')
                            ->first();

        $oldContentJson = $currentVersion ? json_encode($currentVersion->content) : json_encode([]);
        $newContentJson = json_encode($dataToSave);

        if ($article->title === $this->title && $oldContentJson === $newContentJson) {
            $this->toast()->info('No Changes', 'Your content is already saved.')->send();
            return;
        }

        try {
            DB::transaction(function () use ($contentForDb, $article, $currentVersion, $oldContentJson, $newContentJson) {

                if ($article->title !== $this->title) {
                    $article->update(['title' => $this->title]);
                }

                if ($oldContentJson !== $newContentJson) {

                    if ($article->status === 'published') {
                        $nextVer = $currentVersion ? round((float)$currentVersion->version + 0.1, 1) : 1.0;

                        $newVersion = ArticleVersion::create([
                            'article_id'   => $article->id,
                            'version'      => $nextVer,
                            'editor_id'    => auth()->id(),
                            'content'      => $contentForDb,
                            'status'       => 'published',
                            'published_at' => now(),
                            'kb_type'      => $currentVersion->kb_type ?? 'article',
                            'visibility'   => $currentVersion->visibility ?? 'public',
                            'is_featured'  => $currentVersion->is_featured ?? 0,
                        ]);

                        $article->update(['current_version_id' => $newVersion->id]);

                        $this->toast()->success('Live Updated', "Changes saved successfully.")->send();

                    } else {
                        if ($currentVersion) {
                            $currentVersion->update([
                                'content' => $contentForDb,
                                'updated_at' => now()
                            ]);
                        }
                        $this->toast()->success('Draft Saved', 'Draft saved successfully.')->send();
                    }

                } else {
                    $this->toast()->success('Saved', 'Title updated.')->send();
                }
            });

            $this->content = $dataToSave;

        } catch (\Throwable $e) {
            $this->toast()->error('Error', 'Save failed: ' . $e->getMessage())->send();
        }
    }

    public function changeStatus($newStatus, $editorData = null)
    {
        $dataToSave = $editorData ?? $this->content; 
        $contentForDb = empty($dataToSave) ? null : $dataToSave;

        try {
            DB::transaction(function () use ($newStatus, $contentForDb) {

                $article = Article::findOrFail($this->articleId);
                $currentVersion = ArticleVersion::find($article->current_version_id);

                if ($newStatus === 'published' && $article->status !== 'published') {
                    $currentVersion->update([
                        'content' => $contentForDb,
                        'status' => 'published',
                        'published_at' => now()
                    ]);
                    $article->update(['status' => 'published']);
                    $this->toast()->success('Published!', 'Article is now Live.')->send();

                } elseif ($newStatus === 'draft' && $article->status === 'published') {
                    $currentVersion->update(['status' => 'draft']);
                    $article->update(['status' => 'draft']);
                    $this->toast()->success('Unpublished', 'Reverted to Draft.')->send();

                } else {
                    $currentVersion->update(['content' => $contentForDb, 'status' => $newStatus]);
                    $article->update(['status' => $newStatus]);
                    $this->toast()->success('Status Changed', 'Status updated to ' . ucfirst($newStatus))->send();
                }
            });

            $this->status = $newStatus;
            $this->content = $dataToSave;
            $this->dispatch('refresh-articles-list');

        } catch (\Throwable $e) {
            $this->toast()->error('Error', $e->getMessage())->send();
        }
    }

    public function showPreview($editorData = null)
    {
        if ($editorData) {
            $this->content = $editorData;
        }

        $this->save($this->content);

        $article = Article::find($this->articleId);

        return redirect()->route('article.detail', [
            'slug' => $article->slug,
            'preview' => true
        ]);
    }

    public function updatedEditorImage()
    {
        $this->validate([
            'editorImage' => 'image|max:10240',
        ]);
    }

    public function saveEditorImage(): ?string
    {
        if (!$this->editorImage) return null;

        try {
            $path = $this->editorImage->store('articles', 'public');
            $this->reset('editorImage');
            return asset('storage/' . $path);
        } catch (\Exception $e) {
            \Log::error('Image Upload Error: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.document.partial.article-open');
    }
}
