<?php

namespace App\Livewire\Spaces;

use Livewire\Component;
use App\Models\Space;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;

class SpaceDelete extends Component
{
    use Interactions;

    public $spaceId;

    // Listen for the delete event from the table
    #[On('delete-space')]
    public function openDeleteDialog($spaceId)
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this space?')
            ->confirm('Confirm', 'confirmed', $spaceId)
            ->send();
    }

    public function confirmed($spaceId): void
    {
        $space = Space::findOrFail($spaceId);
        $space->delete();

        // Show success toast
        $this->toast()->success('Success', 'Space deleted successfully')->send();

        // Refresh the spaces list
        $this->refreshData();
    }

    public function refreshData()
    {
        // Dispatch to SpaceList component to reload data
        $this->dispatch('refresh-spaces-list');
    }

    public function render()
    {
        return view('livewire.spaces.space-delete');
    }
}
