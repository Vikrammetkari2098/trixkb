<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use App\Models\Article;
use App\Models\ArticleVersion;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use Livewire\WithFileUploads;

class ArticleOpen extends Component
{
    use Interactions;
    use WithFileUploads;

    public $editorImage;
    public $articleId;
    public $title;
    public $content = [];

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    /* ---------------------------------
     | Load article + version content
     |---------------------------------*/
    #[On('openArticle')]
    public function loadArticleData(int $id): void
    {
        $article = Article::find($id);
        if ($article) {
            $this->articleId = $article->id;
            $this->title = $article->title;
            $this->content = json_decode($article->content, true) ?? [];
        
            $this->dispatch('article-loaded', [
                'title' => $this->title,
                'content' => $this->content
            ]);
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

    public function save($editorData)
    {
        $this->validate();
        try {
            DB::transaction(function () use ($editorData) {
                Article::where('id', $this->articleId)->update([
                    'title' => $this->title,
                    'content' => json_encode($editorData),
                    'updated_at' => now(),
                ]);
            });
            $this->dispatch('refresh-articles-list');

            $this->toast()->success('Success', 'Article updated successfully')->send();

        } catch (\Exception $e) {
            $this->toast()->error('Error', $e->getMessage())->send();
        }
    }

    public function updatedEditorImage()
{
    $this->validate([
        'editorImage' => 'image|max:10240', // 10MB limit
    ]);
}

public function saveEditorImage()
{
    if (!$this->editorImage) return null;

    $path = $this->editorImage->store('articles', 'public');
    
    
    return asset('storage/' . $path);
}


    public function render()
    {
        return view('livewire.document.partial.article-open');
    }
}
