<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use App\Models\Ministry;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;

class MinistryEdit extends Component
{
    use Interactions;

    public $ministryId;
    public $name = '';
    public $short_name = '';
    public $status = 1;

    // Listen for event
    protected $listeners = ['loadData-edit-ministry' => 'loadMinistry'];

    // Load data when event is fired
    public function loadMinistry($id)
    {
        $this->ministryId = $id;
        $ministry = Ministry::findOrFail($id);

        $this->name = $ministry->name;
        $this->short_name = $ministry->short_name;
        $this->status = $ministry->status;
        // Open modal
        $this->dispatch('open-modal-edit-ministry');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'status' => 'required|boolean',
        ]);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'status' => 'required|boolean',
        ]);

        $ministry = Ministry::findOrFail($this->ministryId);
        $ministry->update([
            'name' => $validatedData['name'],
            'short_name' => $validatedData['short_name'] ?? null,
            'status' => $validatedData['status'],
            'slug' => Str::slug($validatedData['name']),
        ]);

        $this->toast()->success('Success', 'Ministry updated successfully')->send();
        $this->dispatch('close-modal-edit-ministry');
        $this->dispatch('refresh-ministries-list');
    }

    public function render()
    {
        return view('livewire.organisation.ministry-edit');
    }
}
