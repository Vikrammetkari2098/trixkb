<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use App\Models\Ministry;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;

class MinistryCreate extends Component
{
    use Interactions;

    public $name = '';
    public $short_name = '';
    public $status = 1;

    // Listen for event to open modal
    protected $listeners = ['open-modal-create-ministry' => 'openModal'];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'status' => 'required|boolean',
        ]);
    }

    public function create()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'status' => 'required|boolean',
        ]);

        Ministry::create([
            'name' => $validatedData['name'],
            'short_name' => $validatedData['short_name'] ?? null,
            'status' => $validatedData['status'],
            'slug' => Str::slug($validatedData['name']),
        ]);

        $this->toast()->success('Success', 'Ministry created successfully')->send();
        $this->dispatch('close-modal-create-ministry');
        $this->reset(['name', 'short_name', 'status']);
        $this->dispatch('refresh-ministries-list');
    }
    public function render()
    {
        return view('livewire.organisation.ministry-create');
    }
}
