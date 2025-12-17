<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class ArticleOpen extends Component
{
    use Interactions;

    public $articleId;
    public $title;
    public $content = [];

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    #[On('openArticle')]
    public function loadArticleData($id)
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

    public function render()
    {
        return view('livewire.document.partial.article-open');
    }
}