<?php

namespace App\Livewire\Organisation\Status;

use Livewire\Component;
use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class StatusEdit extends Component
{
    use Interactions;

    public $statusId;
    public $status_name = '';
    public $is_default = false;
    public $is_private = false;
    public $is_public = false;

    protected $listeners = [
        'open-modal-edit-status' => 'loadStatus'
    ];

    protected $rules = [
        'status_name' => 'required|min:2|unique:statuses,name',
        'is_default' => 'boolean',
        'is_private' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function loadStatus($id)
    {
        $this->statusId = $id;
        $status = Status::findOrFail($id);

        $this->status_name = $status->name;
        $this->is_default = $status->is_default;
        $this->is_private = $status->is_private;
        $this->is_public = $status->is_public;

        $this->dispatch('open-modal-edit-status');
    }

    public function save()
    {
        $validatedData = $this->validate();

        $status = Status::findOrFail($this->statusId);
        $status->update([
            'name' => $validatedData['status_name'],
            'slug' => Str::slug($validatedData['status_name']),
            'is_default' => $validatedData['is_default'] ? 1 : 0,
            'is_private' => $validatedData['is_private'] ? 1 : 0,
            'is_public' => $validatedData['is_public'] ? 1 : 0,
            'last_updated_by' => Auth::id(),
        ]);

        $this->dispatch('close-modal-edit-status');
        $this->dispatch('refresh-status-list');

        $this->toast()->success('Success', 'Status updated successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.status.status-edit');
    }
}
