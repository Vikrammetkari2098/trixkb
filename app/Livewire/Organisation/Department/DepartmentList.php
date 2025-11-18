<?php

namespace App\Livewire\Organisation\Department;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department;
use TallStackUi\Traits\Interactions;

class DepartmentList extends Component
{
    use WithPagination, Interactions;

    public ?int $quantity = 10;
    public ?string $search = null;
    public ?int $statusFilter = null;

    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $departmentStatus = [];

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'refresh-departments-list' => '$refresh'
   ];
    public function mount()
    {
        $this->departmentStatus = [
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive'],
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

    public function sortBy($column)
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] = $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }

        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = null;
        $this->statusFilter = null;
        $this->resetPage();
    }

    public function getRowsProperty()
    {
        return Department::query()
            ->select('department_id as id', 'name', 'short_name', 'status', 'created_at')
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter !== null, fn($query) => $query->where('status', $this->statusFilter))
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function getHeadersProperty()
    {
        return [
            ['index' => 'id', 'label' => 'No.'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'short_name', 'label' => 'Short Name', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true, 'type' => 'status'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    public function render()
    {
        return view('livewire.organisation.department.department-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
        ]);
    }
}
