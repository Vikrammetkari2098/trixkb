<?php

namespace App\Livewire\Organisation\Matrix;

use Livewire\Component;
use App\Models\Organisation;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MatrixCreate extends Component
{
    use Interactions;

    public $name = '';
    public $category = '';
    public $status = 1;

    public $ministry_id = '';
    public $department_id = '';
    public $segment_id = '';
    public $unit_id = '';
    public $sub_unit_id = '';

    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $sub_units_list = [];

    protected $listeners = ['open-modal-create-matrix' => 'openModal'];

    public function mount()
    {
        // Ministry
        $this->ministries_list = Ministry::pluck('name', 'ministry_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();

        // Department
        $this->departments_list = Department::pluck('name', 'department_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();

        // Segment
        $this->segments_list = Segment::pluck('name', 'segment_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();

        // Unit
        $this->units_list = Unit::pluck('name', 'unit_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();

        // Sub Unit
        $this->sub_units_list = SubUnit::pluck('name', 'sub_unit_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();
    }

    // Cascade dropdown updates
    public function updatedMinistryId()
    {
        $this->departments_list = Department::where('ministry_id', $this->ministry_id)
            ->pluck('name', 'department_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();

        $this->department_id = '';
        $this->segment_id = '';
        $this->unit_id = '';
        $this->sub_unit_id = '';
    }

    public function updatedDepartmentId()
    {
        // Segment table मध्ये foreign key team_id वापरला आहे
        $this->segments_list = Segment::where('team_id', $this->department_id)
            ->pluck('name', 'segment_id')
            ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
            ->values()
            ->toArray();

        $this->segment_id = '';
        $this->unit_id = '';
        $this->sub_unit_id = '';
    }

    public function updatedSegmentId()
    {
        $this->units_list = Unit::where('segment_id', $this->segment_id)
        ->pluck('name', 'unit_id')
        ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
        ->values()
        ->toArray();
        $this->unit_id = '';
        $this->sub_unit_id = '';
    }


    public function updatedUnitId()
    {
       $this->sub_units_list = SubUnit::where('unit_id', $this->unit_id)
        ->pluck('name', 'sub_unit_id')
        ->map(fn($name, $id) => ['value' => $id, 'text' => $name])
        ->values()
        ->toArray();


        $this->sub_unit_id = '';
    }

    // Validation
    public function updated($property)
    {
        $this->validateOnly($property, $this->rules());
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|integer',
            'status' => 'required|boolean',
            'ministry_id' => 'nullable|exists:ministry,ministry_id',
            'department_id' => 'nullable|exists:department,department_id',
            'segment_id' => 'nullable|exists:segment,segment_id',
            'unit_id' => 'nullable|exists:unit,unit_id',
            'sub_unit_id' => 'nullable|exists:sub_unit,sub_unit_id',
        ];
    }
    public function generateCode()
    {
        return 'ORG-' . strtoupper(Str::random(5));
    }
   private function nullifyEmptyFields(array $data)
    {
        foreach (['department_id', 'segment_id', 'unit_id', 'sub_unit_id'] as $key) {
            if (empty($data[$key])) {
                $data[$key] = null;
            }
        }
        return $data;
    }

   public function create()
{
    $validated = $this->validate([
        'name' => 'required|string|max:255',
        'category' => 'required',
        'status' => 'required|boolean',
        'ministry_id' => 'nullable|integer',
        'department_id' => 'nullable|integer',
        'segment_id' => 'nullable|integer',
        'unit_id' => 'nullable|integer',
        'sub_unit_id' => 'nullable|integer',
    ]);

    $validated = $this->nullifyEmptyFields($validated);

    Organisation::create([
        'name'            => $validated['name'],
        'slug'            => Str::slug($validated['name']),
        'category'        => $validated['category'],
        'status'          => $validated['status'],
        'ministry_id'     => $validated['ministry_id'],
        'department_id'   => $validated['department_id'],
        'segment_id'      => $validated['segment_id'],
        'unit_id'         => $validated['unit_id'],
        'sub_unit_id'     => $validated['sub_unit_id'],
        'code'            => $this->generateCode(),
        'created_by'      => Auth::id(),
        'last_updated_by' => Auth::id(),
    ]);

    $this->dispatch('refresh-matrix-list');
    $this->reset(['name', 'category', 'status', 'ministry_id', 'department_id', 'segment_id', 'unit_id', 'sub_unit_id']);
    $this->status = 1;
}

    public function render()
    {
        return view('livewire.organisation.matrix.matrix-create');
    }
}
