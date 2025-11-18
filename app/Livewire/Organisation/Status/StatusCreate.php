<?php

namespace App\Livewire\Organisation\Status;

use Livewire\Component;
use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class StatusCreate extends Component
{
    use Interactions;

    public $status_name = '';
    public $is_default = false;
    public $is_private = false;
    public $is_public = false;

    protected $listeners = ['open-modal-create-status' => 'openModal'];

    protected $rules = [
        'status_name' => 'required|min:2|unique:statuses,name',
        'is_default' => 'boolean',
        'is_private' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validatedData = $this->validate();

        Status::create([
            'name' => $validatedData['status_name'],
            'slug' => Str::slug($validatedData['status_name']),
            'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'is_default' => $validatedData['is_default'] ? 1 : 0,
            'is_private' => $validatedData['is_private'] ? 1 : 0,
            'is_public' => $validatedData['is_public'] ? 1 : 0,
            'created_by' => Auth::id(),
            'last_updated_by' => Auth::id(),
        ]);


        $this->reset(['status_name', 'is_default', 'is_private', 'is_public']);

        $this->dispatch('close-modal-create-status');
        $this->dispatch('refresh-status-list');

        $this->toast()->success('Success', 'Status created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.status.status-create');
    }
}
