<?php

namespace App\Livewire\Organisation\Unit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Unit;
use App\Models\Team;

class UnitList extends Component
{
    use WithPagination;

    public Team $team;
    public $search = '';
    public $statusFilter = null;
    public $quantity = 10;

    // new: properties for viewing/editing
    public $viewingUnit = null;
    public $editingUnit = null;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    // add listeners for table dispatches
    protected $listeners = [
        'refresh-unit-list' => '$refresh',
        'loadData-view-unit' => 'loadViewUnit',
        'loadData-edit-unit' => 'loadEditUnit',
    ];

    public array $unitStatus = [];
    public array $headers = [];

    public function mount(Team $team)
    {
        $this->team = $team;

        $this->unitStatus = [
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
        ];

        $this->headers = [
            ['index' => 'unit_id', 'label' => 'No.'],
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
        return Unit::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter !== null, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function loadViewUnit($payload)
    {
        $id = is_array($payload) && isset($payload['id']) ? $payload['id'] : $payload;
        $this->viewingUnit = Unit::find($id);
        $this->dispatch('open-modal-view-unit');
    }
    public function loadEditUnit($id)
    {
        $this->editingUnit = Unit::find($id);
        $this->emitTo('organisation.unit.unit-edit', 'loadUnit', $this->editingUnit);
        $this->dispatch('open-modal-edit-unit');
    }

    public function render()
    {
        return view('livewire.organisation.unit.unit-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'unitStatus' => $this->unitStatus,
        ]);
    }
}
