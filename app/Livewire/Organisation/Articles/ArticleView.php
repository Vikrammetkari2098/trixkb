<?php

namespace App\Livewire\Organisation\Articles;

use Livewire\Component;
use App\Models\Wiki;
use Livewire\Attributes\On;

class ArticleView extends Component
{
    public $article;
    public $articleId;

    #[On('loadData-view-article')]
    public function loadArticle($data)
    {
        $id = $data['id'];

        $this->article = Wiki::with([
            'categories',
            'spaces',
            'organisation.ministry',
            'organisation.department',
            'organisation.segment',
            'organisation.unit',
            'organisation.subUnit',
        ])->find($id);

        $this->dispatch('open-modal-view-article');
    }

    public function render()
    {
        return view('livewire.organisation.articles.article-view');
    }
}
