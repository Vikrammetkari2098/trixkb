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
        // 1. डेटाबेसमधून डेटा आणणे (Professional & Safe)
        $article = Article::with('currentVersion')->find($articleId);

        if ($article) {
            $this->title = $article->title;
            
            // डेटा JSON आहे की Array हे बघून सेट करणे
            $rawContent = $article->currentVersion->content ?? [];
            $this->content = is_string($rawContent) ? json_decode($rawContent, true) : $rawContent;
            
            // 2. मॉडेल उघडणे
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