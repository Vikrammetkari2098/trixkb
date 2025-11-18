<?php

namespace App\Livewire\Organisation\Department;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

class DepartmentEdit extends Component
{
    use Interactions;

    public $departmentId;
    public $name;
    public $short_name;
    public $status = 1;

    public bool $open = false; // modal state

    protected $listeners = [
        'loadData-edit-department' => 'openModal' // listens for dispatch from table
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'short_name' => 'nullable|string|max:100',
        'status' => 'required|boolean',
    ];

    // Open modal and load data
    public function openModal($data)
    {
        $id = is_array($data) ? $data['id'] : $data;

        $department = Department::findOrFail($id);

        $this->departmentId = $department->id;
        $this->name = $department->name;
        $this->short_name = $department->short_name;
        $this->status = $department->status;

        $this->open = true; // open modal
    }

    // Update department
    public function update()
    {
        $this->validate();

        $department = Department::findOrFail($this->departmentId);
        $department->update([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'status' => $this->status,
            'slug' => Str::slug($this->name),
        ]);

        $this->open = false; // close modal
        $this->dispatch('refresh-departments-list');
        $this->toast()->success('Success', 'Department updated successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.department.department-edit');
    }
}
