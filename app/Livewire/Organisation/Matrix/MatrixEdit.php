<?php

namespace App\Livewire\Organisation\Matrix;

use Livewire\Component;
use App\Models\Organisation;
use TallStackUi\Traits\Interactions;

class MatrixEdit extends Component
{
    use Interactions;

    public $matrixId;
    public $name, $category, $ministry_id, $department_id, $segment_id, $unit_id, $sub_unit_id, $status;

    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $sub_units_list = [];

    protected $listeners = ['loadData-edit-matrix' => 'loadMatrix'];

    public function loadMatrix($id)
    {
        $matrix = Organisation::findOrFail($id);
        $this->matrixId = $id;
        $this->name = $matrix->name;
        $this->category = $matrix->category;
        $this->ministry_id = $matrix->ministry_id;
        $this->department_id = $matrix->department_id;
        $this->segment_id = $matrix->segment_id;
        $this->unit_id = $matrix->unit_id;
        $this->sub_unit_id = $matrix->sub_unit_id;
        $this->status = $matrix->status;

        $this->dispatch('open-modal-edit-matrix');
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $matrix = Organisation::findOrFail($this->matrixId);
        $matrix->update([
            'name' => $this->name,
            'category' => $this->category,
            'ministry_id' => $this->ministry_id,
            'department_id' => $this->department_id,
            'segment_id' => $this->segment_id,
            'unit_id' => $this->unit_id,
            'sub_unit_id' => $this->sub_unit_id,
            'status' => $this->status,
        ]);

        $this->toast()->success('Success', 'Matrix updated successfully')->send();
        $this->dispatch('close-modal-edit-matrix');
        $this->dispatch('refresh-matrix-list');
    }

    public function render()
    {
        return view('livewire.organisation.matrix.matrix-edit');
    }
}
