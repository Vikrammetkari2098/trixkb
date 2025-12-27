<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;
use Livewire\Attributes\On;

class ArticlePreview extends Component
{
    public bool $isOpen = false;
    public string $title = '';
    public array $content = [];

    #[On('open-preview')]
    public function open()
    {
        // Ask ArticleOpen for current editor data
        $this->dispatch('request-preview-data');
    }

    #[On('send-preview-data')]
    public function receive(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->content = $data['content'] ?? [];
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.document.partial.article-preview');
    }
}
