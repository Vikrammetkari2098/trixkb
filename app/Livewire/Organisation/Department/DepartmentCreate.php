<?php

namespace App\Livewire\Organisation\Department;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

class DepartmentCreate extends Component
{
    use Interactions;

    public $name;
    public $short_name;
    public $status = 1;

    protected $listeners = ['open-modal-create-department' => 'openModal'];

    public bool $open = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'short_name' => 'nullable|string|max:100',
        'status' => 'required|boolean',
    ];

    public function openModal()
    {
        $this->reset(['name', 'short_name', 'status']);
        $this->open = true;
    }

    public function save()
    {
        $this->validate();

        Department::create([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'status' => $this->status,
            'slug' => Str::slug($this->name),
        ]);

        $this->open = false;
        $this->dispatch('close-modal-create-department');
        $this->dispatch('refresh-departments-list');
        $this->toast()->success('Success', 'Department created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.department.department-create');
    }
}
