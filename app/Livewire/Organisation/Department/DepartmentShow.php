<?php

namespace App\Livewire\Organisation\Department;

use Livewire\Component;
use App\Models\Department;

class DepartmentShow extends Component
{
    public $departmentId;
    public $name;
    public $short_name;
    public $status;

    public bool $open = false;

    protected $listeners = [
        'loadData-view-department' => 'openModal'
    ];

    public function openModal($data)
    {
        $id = is_array($data) ? $data['id'] : $data;

        $department = Department::findOrFail($id);

        $this->departmentId = $department->id;
        $this->name = $department->name;
        $this->short_name = $department->short_name;
        $this->status = $department->status;

        $this->open = true;
    }

    public function render()
    {
        return view('livewire.organisation.department.department-show');
    }
}
