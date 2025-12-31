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
        $article = Article::with('currentVersion')->find($id);

        if (!$article) {
            return;
        }

        $this->articleId = $article->id;
        $this->title = $article->title;

        $rawContent = $article->currentVersion?->content;

        if (is_string($rawContent)) {
            $this->content = json_decode($rawContent, true) ?? [];
        } else {
            $this->content = is_array($rawContent) ? $rawContent : [];
        }

        $this->dispatch('article-loaded', title: $this->title, content: $this->content);
    }

    public function save($editorData = null, $status = null)
    {
        $dataToSave = $editorData ?? $this->content;

        $this->validate(['title' => 'required|string|max:255']);

        try {
            DB::transaction(function () use ($dataToSave, $status) {
                $article = Article::findOrFail($this->articleId);

                $updateData = ['title' => $this->title];
                if ($status) {
                    $updateData['status'] = $status;
                }
                $article->update($updateData);

                $version = ArticleVersion::findOrFail($article->current_version_id);
                $version->update(['content' => $dataToSave]);
            });

            $this->content = $dataToSave;

            $this->dispatch('refresh-articles-list');

            if (!$status) {
                $this->toast()->success('Success', 'Article saved successfully')->send();
            }

        } catch (\Exception $e) {
            $this->toast()->error('Error', $e->getMessage())->send();
        }
    }

    public function showPreview($editorData = null)
    {
        if ($editorData) {
            $this->content = $editorData;
        }

        $this->save($this->content);

        $this->dispatch('preview-article', articleId: $this->articleId);
    }

    public function updatedEditorImage()
    {
        $this->validate([
            'editorImage' => 'image|max:10240',
        ]);
    }

    public function saveEditorImage(): ?string
    {
        if (!$this->editorImage) {
            return null;
        }

        $path = $this->editorImage->store('articles', 'public');
        return asset('storage/' . $path);
    }

    public function render()
    {
        return view('livewire.document.partial.article-open');
    }
}