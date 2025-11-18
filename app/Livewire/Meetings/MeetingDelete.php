<?php

namespace App\Livewire\Meetings;

use App\Models\Meeting;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class MeetingDelete extends Component
{
    use Interactions;

    public $meetingId;

    #[On('delete-meeting')]
    public function openDeleteDialog($meetingId)
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure?')
            ->confirm('Confirm', 'confirmed', $meetingId)
            ->send();
    }

    public function confirmed($meetingId): void
    {
        Meeting::findOrFail($meetingId)->delete();
        $this->toast()->success('Success', 'Meeting deleted successfully')->send();
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->dispatch('loadData-meetings');
    }

    public function render()
    {
        return view('livewire.meetings.meeting-delete');
    }
}
