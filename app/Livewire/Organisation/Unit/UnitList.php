<?php

namespace App\Livewire\Organisation\Unit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Unit;
use App\Models\Team;

class UnitList extends Component
{
    use WithPagination;

    public $team;   // ❗ Team type remove
    public $search = '';
    public $statusFilter = null;
    public $quantity = 10;

    public $viewingUnit = null;
    public $editingUnit = null;

    protected $listeners = [
        'refresh-unit-list' => '$refresh',
    ];

    public array $unitStatus = [];
    public array $headers = [];

    public function mount($team = null)   // ❗ now safe no DI error
    {
        $this->team = $team ? Team::find($team) : null;

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

    public function loadViewUnit($id)
    {
        $this->viewingUnit = Unit::find($id);
        $this->dispatch('open-modal-view-unit');
    }

    public function loadEditUnit($id)
{
    $this->dispatch('loadUnit', ['id' => $id])
        ->to(\App\Livewire\Organisation\Unit\UnitEdit::class);

    $this->dispatch('open-modal-edit-unit');
}

    public function getRowsProperty()
    {
        return Unit::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter !== null, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy('created_at', 'desc')
            ->paginate($this->quantity);
    }

    public function render()
    {
        return view('livewire.organisation.unit.unit-list', [
            'rows'   => $this->rows,
            'headers' => $this->headers,
            'unitStatus' => $this->unitStatus,
        ]);
    }
}
