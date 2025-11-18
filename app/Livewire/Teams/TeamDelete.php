<?php

namespace App\Livewire\Teams;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use App\Models\Activity;

class TeamDelete extends Component
{
    use Interactions;

    public $userId;

    #[On('delete-team')]
    public function openDeleteDialog($userId)
    {
        $this->userId = $userId;
        $this->dialog()
            ->question('Warning!', 'Are you sure?')
            ->confirm('Confirm', 'confirmed', $userId)
            ->send();
    }
    public function confirmed($userId): void
    {
        $user = User::findOrFail($userId);
        $userName = $user->name;
        $user->delete();
        // Reset the internal userId to avoid future re-triggers
            $this->userId = null;
            Activity::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_member',
            'description' => 'Deleted user: ' . $userName,
            'ip_address' => request()->ip(),
        ]);
        $this->toast()->success('Success', "Member '{$userName}' deleted successful")->send();
        $this->refreshData();
    }
    public function refreshData()
    {
        $this->dispatch('refresh-other-components');
    }
    public function render()
    {
        return view('livewire.teams.team-delete');
    }
}
