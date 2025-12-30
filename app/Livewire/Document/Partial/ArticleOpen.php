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
    public $title;
    public $content = [];

    public $editorImage;

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    #[On('openArticle')]
    public function loadArticleData(int $id): void
    {
        $article = Article::with('currentVersion')->find($id);

        if (!$article) {
            return;
        }

        $this->articleId = $article->id;
        $this->title     = $article->title;
        $this->content   = $article->currentVersion?->content ?? [];

        // Send data to EditorJS
        $this->dispatch('article-loaded', [
            'title'   => $this->title,
            'content' => $this->content,
        ]);
    }
    #[On('request-preview-data')]
    public function sendPreviewData()
    {
        $this->dispatch('send-preview-data', [
            'title'   => $this->title,
            'content' => $this->content,
        ]);
    }

    public function save(array $editorData): void
    {
        $this->validate();

        try {
            DB::transaction(function () use ($editorData) {

                $article = Article::findOrFail($this->articleId);

                // Update article metadata
                $article->update([
                    'title' => $this->title,
                ]);

                // Update current version content
                ArticleVersion::where('id', $article->current_version_id)
                    ->update([
                        'content' => $editorData,
                    ]);
            });

            $this->dispatch('refresh-articles-list');
            $this->toast()
                ->success('Success', 'Article updated successfully')
                ->send();

        } catch (\Exception $e) {
            $this->toast()
                ->error('Error', $e->getMessage())
                ->send();
        }
    }

    public function updatedEditorImage(): void
    {
        $this->validate([
            'editorImage' => 'image|max:10240', // 10MB
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
    
   public function updateStatus(string $status): bool
{
    $validStatuses = ['draft', 'in_review', 'published', 'archived'];

    if (!in_array($status, $validStatuses)) {
        return false;
    }

    // ✅ Article find kar (articleId = Article ID)
    $article = Article::find($this->articleId);

    if (!$article) {
        return false;
    }

    // ✅ Update status on Article
    $article->update([
        'status' => $status,
    ]);

    // ✅ Refresh article list
    $this->dispatch('refresh-articles-list');

    $this->toast()
        ->success('Status Updated', 'Article status updated successfully')
        ->send();

    return true;
}

public function triggerSave(): void
{
    // Alpine/JS ला सांगतो: editor data पाठव
    $this->dispatch('request-editor-save');
}


    public function render()
    {
        return view('livewire.document.partial.article-open');
    }
}
