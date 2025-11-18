<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ministry;
use Illuminate\Support\Facades\Auth;

class MinistriesList extends Component
{
    use WithPagination;

    public ?int $quantity = 10;
    public ?string $search = null;
    public ?string $statusFilter = null;
    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public array $ministriesStatus = [];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-ministries-list' => '$refresh'];

    public function mount()
    {
        $this->ministriesStatus = [
            ['value' => 1, 'name' => 'Active'],
            ['value' => 0, 'name' => 'Inactive'],
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

    public function updatedQuantity()
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

    public function getRowsProperty()
    {
        return Ministry::query()
            ->select('ministry_id as id', 'name', 'short_name', 'status', 'created_at')
            ->when($this->search, fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")
            )
            ->when($this->statusFilter !== null, fn($query) =>
                $query->where('status', $this->statusFilter)
            )
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }


   public function getHeadersProperty()
{
    return [
        ['index' => 'id', 'label' => 'No.'],
        ['index' => 'name', 'label' => 'Name', 'sortable' => true],
        ['index' => 'short_name', 'label' => 'Short Name', 'sortable' => true],
        ['index' => 'status', 'label' => 'Status', 'sortable' => true, 'type' => 'status'], // custom type
        ['index' => 'action', 'label' => 'Actions'],
    ];
}

    public function render()
    {
        return view('livewire.organisation.ministries-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'sort' => $this->sort,
        ]);
    }
}
