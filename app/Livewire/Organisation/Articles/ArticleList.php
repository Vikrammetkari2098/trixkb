<?php

namespace App\Livewire\Organisation\Articles;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wiki;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;
use Illuminate\Support\Facades\Auth;

class ArticleList extends Component
{
    use WithPagination;

    public ?int $quantity = 50;
    public ?string $barSearch = '';
    public ?int $ministryFilter = null;
    public ?int $departmentFilter = null;
    public ?int $segmentFilter = null;
    public ?int $unitFilter = null;
    public ?int $subUnitFilter = null;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $ministries_list = [];
    public array $departments_list = [];
    public array $segments_list = [];
    public array $units_list = [];
    public array $subUnits_list = [];
    public array $paginationRange = [50, 100, 150, 200];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-article-list' => '$refresh'];

    public function mount()
    {
        $this->ministries_list = Ministry::whereHas('organisations')
            ->get()
            ->map(fn($m) => ['value' => $m->ministry_id, 'label' => $m->name])
            ->toArray();

        $this->departments_list = Department::whereHas('organisations')
            ->get()
            ->map(fn($d) => ['value' => $d->department_id, 'label' => $d->name])
            ->toArray();
    }

    public function updatedMinistryFilter()
    {
        $this->resetPage();
        $this->populateDepartments();
        $this->populateSegments();
    }

    public function updatedDepartmentFilter()
    {
        $this->resetPage();
        $this->populateSegments();
        $this->populateUnits();
    }

    public function updatedSegmentFilter()
    {
        $this->resetPage();
        $this->populateUnits();
    }

    public function updatedUnitFilter()
    {
        $this->resetPage();
        $this->populateSubUnits();
    }

    public function updatingBarSearch()
    {
        $this->resetPage();
    }

    public function populateDepartments()
    {
        if ($this->ministryFilter) {
            $this->departments_list = Auth::user()->populateDeptDropdownBasedMinistry($this->ministryFilter)
                ->map(fn($d) => ['value' => $d->department_id, 'label' => $d->name])
                ->toArray();
        } else {
            $this->departments_list = Department::whereHas('organisations')
                ->get()
                ->map(fn($d) => ['value' => $d->department_id, 'label' => $d->name])
                ->toArray();
        }
        $this->departmentFilter = null;
    }

    public function populateSegments()
    {
        $user = Auth::user();

        if ($this->departmentFilter) {
            $this->segments_list = $user->populateSegmentDropdownBasedDept($this->departmentFilter)
                ->map(fn($s) => ['value' => $s->segment_id, 'label' => $s->name])
                ->toArray();
        } elseif ($this->ministryFilter) {
            $this->segments_list = $user->populateSegmentDropdownBasedMinistry($this->ministryFilter)
                ->map(fn($s) => ['value' => $s->segment_id, 'label' => $s->name])
                ->toArray();
        } else {
            $this->segments_list = [];
        }
        $this->segmentFilter = null;
    }

    public function populateUnits()
    {
        $user = Auth::user();

        if ($this->departmentFilter && $this->segmentFilter) {
            $this->units_list = $user->populateUnitDropdownBasedDept($this->departmentFilter, $this->segmentFilter)
                ->map(fn($u) => ['value' => $u->unit_id, 'label' => $u->name])
                ->toArray();
        } elseif ($this->ministryFilter && $this->segmentFilter) {
            $this->units_list = $user->populateUnitDropdownBasedMinistry($this->ministryFilter, $this->segmentFilter)
                ->map(fn($u) => ['value' => $u->unit_id, 'label' => $u->name])
                ->toArray();
        } else {
            $this->units_list = [];
        }
        $this->unitFilter = null;
    }

    public function populateSubUnits()
    {
        $user = Auth::user();

        if ($this->departmentFilter && $this->segmentFilter && $this->unitFilter) {
            $this->subUnits_list = $user->populateSubUnitDropdownBasedDept($this->departmentFilter, $this->segmentFilter, $this->unitFilter)
                ->map(fn($s) => ['value' => $s->sub_unit_id, 'label' => $s->name])
                ->toArray();
        } elseif ($this->ministryFilter && $this->segmentFilter && $this->unitFilter) {
            $this->subUnits_list = $user->populateSubUnitDropdownBasedMinistry($this->ministryFilter, $this->segmentFilter, $this->unitFilter)
                ->map(fn($s) => ['value' => $s->sub_unit_id, 'label' => $s->name])
                ->toArray();
        } else {
            $this->subUnits_list = [];
        }
        $this->subUnitFilter = null;
    }

    public function getRowsProperty()
    {
        return Wiki::with(['user', 'organisation.ministry', 'organisation.department', 'organisation.segment', 'organisation.unit', 'organisation.subUnit'])
            ->where('wiki_type', 'article')
            ->when($this->ministryFilter, fn($q) =>
                $q->whereHas('organisation.ministry', fn($sub) => $sub->where('organisations.ministry_id', $this->ministryFilter))
            )
            ->when($this->departmentFilter, fn($q) =>
                $q->whereHas('organisation.department', fn($sub) => $sub->where('organisations.department_id', $this->departmentFilter))
            )
            ->when($this->segmentFilter, fn($q) =>
                $q->whereHas('organisation.segment', fn($sub) => $sub->where('organisations.segment_id', $this->segmentFilter))
            )
            ->when($this->unitFilter, fn($q) =>
                $q->whereHas('organisation.unit', fn($sub) => $sub->where('organisations.unit_id', $this->unitFilter))
            )
            ->when($this->subUnitFilter, fn($q) =>
                $q->whereHas('organisation.subUnit', fn($sub) => $sub->where('organisations.sub_unit_id', $this->subUnitFilter))
            )
            ->when($this->barSearch, fn($q) =>
                $q->where(function ($query) {
                    $query->where('wiki.name', 'like', '%' . $this->barSearch . '%')
                          ->orWhere('wiki.description', 'like', '%' . $this->barSearch . '%')
                          ->orWhereHas('organisation', fn($org) => $org->where('organisations.name', 'like', '%' . $this->barSearch . '%'));
                })
            )
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        $rows = $this->rows->through(function ($item) {
            $item->created_by_name = $item->user->name ?? 'N/A';
            $item->organisation_data = [
                'ministry' => $item->organisation?->ministry->name ?? '-',
                'department' => $item->organisation?->department->name ?? '-',
                'segment' => $item->organisation?->segment->name ?? '-',
                'unit' => $item->organisation?->unit->name ?? '-',
                'subUnit' => $item->organisation?->subUnit->name ?? '-',
            ];
            return $item;
        });

        return view('livewire.organisation.articles.article-list', [
            'rows' => $rows,
            'ministries_list' => $this->ministries_list,
            'departments_list' => $this->departments_list,
            'segments_list' => $this->segments_list,
            'units_list' => $this->units_list,
            'subUnits_list' => $this->subUnits_list,
        ]);
    }
}
