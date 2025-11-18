<?php

namespace App\Livewire\Organisation\CategoryMatrix;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategoryMatrix;

class CategoryMatrixList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $quantity = 10;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $categoryMatrixStatus = [];
    public array $headers = [];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-category-matrix-list' => '$refresh'];

    public function mount()
    {
        // Status dropdown
        $this->categoryMatrixStatus = [
            ['value' => '', 'label' => 'All'],
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
        ];

        // Table headers
        $this->headers = [
            ['index' => 'id', 'label' => 'No.'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'matrix_details', 'label' => 'Matrix Details'],
            ['index' => 'status', 'label' => 'Status'],
            ['index' => 'created_by', 'label' => 'Created By'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingQuantity() { $this->resetPage(); }

    public function getRowsProperty()
    {
        return CategoryMatrix::query()
            ->with(['user', 'ministry', 'department', 'caseCategory', 'subCategory1', 'subCategory2'])
            ->when($this->search, fn($query) =>
                $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->when($this->statusFilter !== '', fn($query) =>
                $query->where('status', $this->statusFilter)
            )
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        $rows = $this->rows->through(function ($item) {
            $item->created_by_name = $item->user->name ?? 'N/A';
            $item->matrix_details = [
                'ministry' => $item->ministry->name ?? '-',
                'department' => $item->department->name ?? '-',
                'caseCategory' => $item->caseCategory->name ?? '-',
                'subCategory1' => $item->subCategory1->name ?? '-',
                'subCategory2' => $item->subCategory2->name ?? '-',
            ];
            return $item;
        });

        return view('livewire.organisation.category-matrix.category-matrix-list', [
            'rows' => $rows,
            'headers' => $this->headers,
            'categoryMatrixStatus' => $this->categoryMatrixStatus,
            'categoryMatrixCount' => $this->rows->total(),
        ]);
    }
}
