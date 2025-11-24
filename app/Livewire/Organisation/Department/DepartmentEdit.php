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

    public bool $open = false;

    protected $listeners = [
        'loadData-edit-department' => 'openModal',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'short_name' => 'nullable|string|max:100',
        'status' => 'required|boolean',
    ];

    public function openModal($data)
{
    $department = Department::findOrFail($data['id']);

    $this->departmentId = $department->department_id;
    $this->name = $department->name;
    $this->short_name = $department->short_name;
    $this->status = $department->status;

    $this->open = true;
}


    public function update()
    {
        $this->validate();

        Department::findOrFail($this->departmentId)->update([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'status' => $this->status,
            'slug' => Str::slug($this->name),
        ]);

        $this->open = false;
        $this->dispatch('refresh-departments-list');
        $this->toast()->success('Success', 'Department updated successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.department.department-edit');
    }
}
