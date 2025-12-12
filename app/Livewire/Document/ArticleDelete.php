<?php

namespace App\Livewire\Document;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;

class ArticleDelete extends Component
{
    use Interactions;

    #[On('open-delete-dialog')]
    public function openDeleteDialog()
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this article?')
            ->confirm('Confirm', 'confirmed')
            ->send();
    }

    public function confirmed(): void
    {
        $this->toast()->success('Deleted', 'Article deleted successfully')->send();
    }

    public function render()
    {
        return view('livewire.document.article-delete');
    }
}
