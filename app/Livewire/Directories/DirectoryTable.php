<?php

namespace App\Livewire\Directories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wiki;

class DirectoryTable extends Component
{
    use WithPagination;

    public ?int $quantity = 5;
    public string $search = '';
      public $title = "Directory";
    public $team;
    public array $filters = [];

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'filters-updated' => 'applyFilters',
        'reset-tomselect' => 'resetFilters',
    ];

    public function mount($team = null)
    {
        $this->team = $team;
    }

    public function applyFilters($data)
    {
        $this->filters = $data['filters'] ?? [];
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filters = [];
        $this->search = '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $wikis = Wiki::query()
            ->where('wiki_type', 'directory')
            ->when($this->team, fn($query) => $query->where('team_id', $this->team->id))
            ->when($this->search, fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('designation', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->when(!empty($this->filters['ministry']), fn($query) =>
                $query->whereHas('organisation', fn($q) => $q->where('ministry_id', $this->filters['ministry']))
            )
            ->when(!empty($this->filters['department']), fn($query) =>
                $query->whereHas('organisation', fn($q) => $q->where('department_id', $this->filters['department']))
            )
            ->when(!empty($this->filters['segment']), fn($query) =>
                $query->whereHas('organisation', fn($q) => $q->where('segment_id', $this->filters['segment']))
            )
            ->when(!empty($this->filters['unit']), fn($query) =>
                $query->whereHas('organisation', fn($q) => $q->where('unit_id', $this->filters['unit']))
            )
            ->when(!empty($this->filters['subUnit']), fn($query) =>
                $query->whereHas('organisation', fn($q) => $q->where('sub_unit_id', $this->filters['subUnit']))
            )
            ->with([
                'organisation.ministry',
                'organisation.department',
                'organisation.segment',
                'organisation.unit',
                'organisation.subUnit'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($this->quantity);

        return view('livewire.directories.directory-table', [
            'wikis' => $wikis,
        ]);
    }
}
