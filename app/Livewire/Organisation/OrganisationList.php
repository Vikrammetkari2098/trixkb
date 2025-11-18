<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Organisation;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganisationsExport;

class OrganisationList extends Component
{
    use WithPagination;

    // Filters (from child component)
    public $statusFilter = '';
    public $categoryFilter = '';
    public $ministryFilter = '';
    public $departmentFilter = '';
    public $segmentFilter = '';
    public $unitFilter = '';
    public $subUnitFilter = '';
    public $searchTerm = '';
    public  $departments='';
    public $ministries = [];
    // Lists for dropdown filters
    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $sub_units_list = [];
    public $segments = [];
    public $units = [];
    public $subUnits = [];
    public $selectedMinistry;
    public $selectedDepartment;
    public $selectedSegment;
    public $selectedUnit;

    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public function mount()
    {
        // Only load ministries initially
        $this->ministries = Ministry::orderBy('name')->get();
        // All dependent dropdowns are empty initially
        $this->departments = Department::orderBy('name')->get();
        $this->segments = [];
        $this->units = [];
        $this->subUnits = [];
    }

    public function updatedSelectedMinistry($ministryId)
    {
        $this->departments = Department::where('ministry_id', $ministryId)
                                    ->orderBy('name')
                                    ->get();
        $this->selectedDepartment = null;
        $this->segments = [];
        $this->units = [];
        $this->subUnits = [];
    }

    public function updatedSelectedDepartment($departmentId)
    {
        $this->segments = Segment::where('department_id', $departmentId)->orderBy('name')->get();
        $this->selectedSegment = null;
        $this->units = [];
        $this->subUnits = [];
    }

    public function updatedSelectedSegment($segmentId)
    {
        $this->units = Unit::where('segment_id', $segmentId)->orderBy('name')->get();
        $this->selectedUnit = null;
        $this->subUnits = [];
    }

    public function updatedSelectedUnit($unitId)
    {
        $this->subUnits = SubUnit::where('unit_id', $unitId)->orderBy('name')->get();
    }

   #[On('filtersUpdated')]
    public function updateFilters($filters)
    {
        $this->ministryFilter   = $filters['ministryFilter'] ?? '';
        $this->departmentFilter = $filters['departmentFilter'] ?? '';
        $this->segmentFilter    = $filters['segmentFilter'] ?? '';
        $this->unitFilter       = $filters['unitFilter'] ?? '';
        $this->subUnitFilter    = $filters['subUnitFilter'] ?? '';
        $this->searchTerm       = $filters['searchTerm'] ?? '';
        $this->childDataIncluded= $filters['childDataIncluded'] ?? false;
    }

    public function queryBuilder()
    {
        $query = Organisation::with(['ministry','department','segment','unit','subUnit']);

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }

        if ($this->selectedMinistry) {
            $query->where('ministry_id', $this->selectedMinistry);
        }
        if ($this->selectedDepartment) {
            $query->where('department_id', $this->selectedDepartment);
        }
        if ($this->selectedSegment) {
            $query->where('segment_id', $this->selectedSegment);
        }
        if ($this->selectedUnit) {
            $query->where('unit_id', $this->selectedUnit);
        }
        if ($this->subUnitFilter) {
            $query->where('sub_unit_id', $this->subUnitFilter);
        }

        return $query;
    }

    public function exportExcel()
    {
        return Excel::download(new OrganisationsExport, 'organisations.xlsx');
    }
    public function applySearch()
    {
        $this->resetPage();
    }
    public function resetFilters()
    {
        // Reset all filter properties
        $this->selectedMinistry = null;
        $this->selectedDepartment = null;
        $this->selectedSegment = null;
        $this->selectedUnit = null;
        $this->subUnitFilter = null;
        $this->searchTerm = '';
        $this->childDataIncluded = false;

        // Reset dependent lazy-loaded arrays
        $this->departments = [];
        $this->segments = [];
        $this->units = [];
        $this->subUnits = [];

        // Reset pagination
        $this->resetPage();
    }


    public function render()
    {
        $organisations = $this->queryBuilder()->paginate(10);

        return view('livewire.organisation.organisation-list', [
            'organisations'    => $organisations,
            'ministries_list'  => $this->ministries_list,
            'departments_list' => $this->departments_list,
            'segments_list'    => $this->segments_list,
            'units_list'       => $this->units_list,
            'sub_units_list'   => $this->sub_units_list,
        ]);
    }
}
