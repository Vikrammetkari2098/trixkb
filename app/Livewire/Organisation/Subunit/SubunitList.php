<?php

namespace App\Livewire\Organisation\Subunit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SubUnit;
use App\Models\Team;

class SubunitList extends Component
{
    use WithPagination;

    public Team $team;
    public $search = '';
     public $viewingSubUnit = null;
    public $statusFilter = null;
    public $quantity = 10;
    public $subUnitStatus = [
    ['label' => 'Active', 'value' => 1],
    ['label' => 'Inactive', 'value' => 0],
];


    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    protected $listeners = ['refresh-subunit-list' => '$refresh'];

    public array $subunitStatus = [];
    public array $headers = [];

    public function mount(Team $team)
    {
        $this->team = $team;

        $this->subunitStatus = [
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
        ];

        $this->headers = [
            ['index' => 'sub_unit_id', 'label' => 'No.'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true, 'type' => 'status'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function getRowsProperty()
    {
        return SubUnit::query()
            ->where('team_id', $this->team->id)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter !== null, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        return view('livewire.organisation.subunit.subunit-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'subunitStatus' => $this->subunitStatus,
        ]);
    }
}
