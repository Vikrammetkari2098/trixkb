<?php

namespace App\Livewire\Document;

use Livewire\Component;
use App\Models\Article;

class ArticleShow extends Component
{
    public $articleId;
    public $article;

    protected $listeners = ['openArticle'];

    public function openArticle($id)
    {
        $this->articleId = $id;
        $this->article = Article::find($id);
    }

    public function render()
    {
        return view('livewire.document.article-show');
    }
}
