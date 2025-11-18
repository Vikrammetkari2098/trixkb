<?php

namespace App\Livewire\Organisation\Segment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Segment;
use App\Models\Team;

class SegmentList extends Component
{
    use WithPagination;

    public Team $team;
    public $search = '';
    public $statusFilter = null;
    public $quantity = 10;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];
    protected $listeners = ['refresh-segment-list' => '$refresh'];
    public array $segmentStatus = [];
    public array $headers = [];

    public function mount(Team $team)
    {
        $this->team = $team;

        $this->segmentStatus = [
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
        ];
        $this->headers = [
            ['index' => 'segment_id', 'label' => 'No.'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true, 'type' => 'status'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
   public function getRowsProperty()
    {
        return Segment::query()
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->when($this->statusFilter !== null, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        return view('livewire.organisation.segment.segment-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'segmentStatus' => $this->segmentStatus,
        ]);
    }
}
