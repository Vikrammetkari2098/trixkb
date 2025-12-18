<?php

namespace App\Livewire\Document;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;
use App\Models\ArticleVersion;

class ArticleDelete extends Component
{
    use Interactions;

    public array $selectedIds = [];

    #[On('open-delete-dialog')]
    public function openDeleteDialog($ids)
    {
        // FORCE array (single or multiple)
        $this->selectedIds = is_array($ids) ? $ids : [$ids];

        $this->dialog()
            ->question(
                'Warning!',
                'Are you sure you want to delete the selected article?'
            )
            ->confirm('Confirm', 'confirmed')
            ->cancel()
            ->send();
    }

    public function confirmed(): void
    {
        ArticleVersion::whereIn('id', $this->selectedIds)->delete();
        $this->toast()
            ->success('Deleted', 'Selected articles deleted successfully')
            ->send();
        $this->selectedIds = [];
        $this->dispatch('loadData-articles');
    }
    public function render()
    {
        return view('livewire.document.article-delete');
    }
}
