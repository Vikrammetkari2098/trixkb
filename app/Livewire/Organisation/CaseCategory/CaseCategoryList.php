<?php

namespace App\Livewire\Organisation\CaseCategory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategoryMatrix;

class CaseCategoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $quantity = 10;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $caseCategoryStatus = [];
    public array $headers = [];

    protected $paginationTheme = 'tailwind';
   protected $listeners = ['refresh-case-category-list' => '$refresh'];

    public function mount()
    {
        // Dropdown options for status filter
        $this->caseCategoryStatus = [
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
        return CategoryMatrix::query()
            ->with(['caseCategory', 'ministry', 'user'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('caseCategory', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        // Use through() to preserve pagination
        $rows = $this->rows->through(function ($item) {
            $item->created_by_name = $item->user->name ?? 'N/A';
            $item->display_name = $item->caseCategory->name ?? $item->name ?? '-';
            return $item;
        });

        return view('livewire.organisation.casecategory.case-category-list', [
            'rows' => $rows,
            'headers' => $this->headers,
            'caseCategoryStatus' => $this->caseCategoryStatus,
        ]);
    }
}
