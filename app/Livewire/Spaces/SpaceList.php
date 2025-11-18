<?php

namespace App\Livewire\Spaces;

use App\Models\Space;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;

class SpaceList extends Component
{
    use Interactions, WithPagination;

    public ?int $quantity = 5;
    public string $search = '';
    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refresh-spaces-list' => '$refresh'];

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
        return Space::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('slug', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function getHeadersProperty()
    {
        return [
            ['index' => 'id', 'label' => '#'],
            ['index' => 'name', 'label' => 'Name', 'sortable' => true],
            ['index' => 'slug', 'label' => 'Slug', 'sortable' => true],
            ['index' => 'created_at', 'label' => 'Created At', 'sortable' => true],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    #[On('loadData-spaces')]
    public function loadData()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.spaces.space-list', [
            'rows' => $this->rows,
            'headers' => $this->headers,
            'sort' => $this->sort,
        ]);
    }
}
