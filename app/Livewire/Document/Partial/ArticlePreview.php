<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Article; 

class ArticlePreview extends Component
{
    public bool $isOpen = false;
    public string $title = '';
    public array $content = [];

    #[On('preview-article')] 
    public function loadPreview($articleId)
    {
       
        $article = Article::with('currentVersion')->find($articleId);

        if ($article) {
            $this->title = $article->title;
            
            
            $rawContent = $article->currentVersion->content ?? [];
            $this->content = is_string($rawContent) ? json_decode($rawContent, true) : $rawContent;
            
           
            $this->isOpen = true;
        }
    }

    public function close()
    {
        $this->isOpen = false;
        $this->reset(['title', 'content']);
    }

    public function render()
    {
        return view('livewire.document.partial.article-preview');
    }
}