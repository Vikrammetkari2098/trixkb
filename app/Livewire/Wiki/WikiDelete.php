<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\Wiki; // your model
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;

class WikiDelete extends Component
{
    use Interactions;

    public $wikiId;

    #[On('delete-wiki')]
    public function openDeleteDialog($wikiId)
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this wiki?')
            ->confirm('Confirm', 'confirmed', $wikiId)
            ->send();
    }

    public function confirmed($wikiId): void
    {
        $wiki = Wiki::findOrFail($wikiId);
        $wiki->delete();

        // Success message
        $this->toast()->success('Deleted', 'Wiki deleted successfully')->send();

        // Refresh list
       $this->dispatch('refresh-article-list');
    }

    public function render()
    {
        return view('livewire.wiki.wiki-delete');
    }
}
