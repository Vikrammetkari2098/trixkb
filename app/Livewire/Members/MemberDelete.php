<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\User;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;

class MemberDelete extends Component
{
    use Interactions;

    public $memberId;

    // Listen to the delete event
    #[On('delete-member')]
    public function openDeleteDialog($memberId)
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this member?')
            ->confirm('Confirm', 'confirmed', $memberId)
            ->send();
    }

    public function confirmed($memberId): void
    {
        $member = User::findOrFail($memberId);
        $member->delete();

        // Show success toast
        $this->toast()->success('Success', 'Member deleted successfully')->send();

        // Refresh the members list
        $this->refreshData();
    }

    public function refreshData()
    {
        // Dispatch to MemberList component to reload data
        $this->dispatch('refresh-members-list');
    }

    public function render()
    {
        return view('livewire.members.member-delete');
    }
}
