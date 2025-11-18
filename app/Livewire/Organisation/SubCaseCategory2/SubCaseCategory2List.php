<?php

namespace App\Livewire\Organisation\SubCaseCategory2;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SubCaseCategory2;

class SubCaseCategory2List extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $quantity = 10;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $subCaseCategory2Status = [];
    public array $headers = [];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-sub-case-category2-list' => '$refresh'];

    public function mount()
    {
        // Dropdown for status filter
        $this->subCaseCategory2Status = [
            ['value' => '', 'label' => 'All'],
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
        ];

        // Table headers
        $this->headers = [
            ['index' => 'id', 'label' => 'No.'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true, 'type' => 'status'],
            ['index' => 'created_by', 'label' => 'Created By'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingQuantity() { $this->resetPage(); }

    public function sortBy($column)
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] = $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }
    }

    public function getRowsProperty()
    {
        return SubCaseCategory2::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        $rows = $this->rows->through(function ($item) {
            $item->created_by_name = $item->user->name ?? 'N/A';
            return $item;
        });

        return view('livewire.organisation.sub-case-category2.sub-case-category2-list', [
            'rows' => $rows,
            'headers' => $this->headers,
            'subCaseCategory2Status' => $this->subCaseCategory2Status,
        ]);
    }
}
