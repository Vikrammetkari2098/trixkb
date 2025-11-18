<?php

namespace App\Livewire\Organisation\Directories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wiki;
use App\Models\Ministry;
use App\Models\Department;
use App\Helpers\GeneralHelper;

class DirectoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $ministryFilter = '';
    public $departmentFilter = '';
    public $quantity = 10;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $directoryStatus = [];
    public array $headers = [];
    public array $ministries_list = [];
    public array $departments_list = [];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-directory-list' => '$refresh'];

    public function mount()
    {
        // Status dropdown
        $this->directoryStatus = [
            ['value' => '', 'label' => 'All'],
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
        ];

        // Table headers
        $this->headers = [
            ['index' => 'id', 'label' => 'No.'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'organisation', 'label' => 'Organisation'],
            ['index' => 'created_by', 'label' => 'Created By'],
            ['index' => 'action', 'label' => 'Actions'],
        ];

        // Ministries & Departments
        $this->ministries_list = Ministry::where('status', 1)
            ->get()
            ->map(fn($m) => ['value' => $m->ministry_id, 'label' => $m->name])
            ->toArray();

        $this->departments_list = Department::where('status', 1)
            ->get()
            ->map(fn($d) => ['value' => $d->department_id, 'label' => $d->name])
            ->toArray();
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingMinistryFilter() { $this->resetPage(); }
    public function updatingDepartmentFilter() { $this->resetPage(); }
    public function updatingQuantity() { $this->resetPage(); }

    public function getRowsProperty()
    {
        return Wiki::query()
            ->with(['user', 'organisation.ministry', 'organisation.department', 'organisation.segment', 'organisation.unit', 'organisation.subUnit'])
            ->where('wiki_type', GeneralHelper::wikiTypeDirectory())
            ->when($this->search, fn($query) =>
                $query->where(function ($q) {
                    $q->where('wiki.name', 'like', '%' . $this->search . '%')
                      ->orWhere('wiki.designation', 'like', '%' . $this->search . '%')
                      ->orWhere('wiki.email', 'like', '%' . $this->search . '%')
                      ->orWhere('wiki.mobile_number', 'like', '%' . $this->search . '%');
                })
            )
            ->when($this->ministryFilter !== '', fn($query) =>
                $query->whereHas('organisation.ministry', fn($sub) =>
                    $sub->where('organisations.ministry_id', $this->ministryFilter)
                )
            )
            ->when($this->departmentFilter !== '', fn($query) =>
                $query->whereHas('organisation.department', fn($sub) =>
                    $sub->where('organisations.department_id', $this->departmentFilter)
                )
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

        return view('livewire.organisation.directories.directory-list', [
            'rows' => $rows,
            'headers' => $this->headers,
            'directoryStatus' => $this->directoryStatus,
            'ministries_list' => $this->ministries_list,
            'departments_list' => $this->departments_list,
        ]);
    }
}
