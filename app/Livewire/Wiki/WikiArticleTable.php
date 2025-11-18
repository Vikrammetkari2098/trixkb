<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wiki;

class WikiArticleTable extends Component
{
    use WithPagination;

    public ?int $quantity = 5;
    public string $search = '';
    public $team;
    public array $filters = [];

    public $selectedWikiId = null;
    public $showAiModal = false;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'filters-updated' => 'applyFilters',
        'close-ai-modal' => 'closeAiModal',
    ];

    public function applyFilters($data)
    {
        $this->filters = $data['filters'] ?? [];
        $this->resetPage();
    }

    public function mount($team = null)
    {
        $this->team = $team;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openAiModal($wikiId)
    {
        $this->selectedWikiId = $wikiId;
        $this->showAiModal = true;
        $this->dispatch('open-wiki-ai-modal');
    }

    public function closeAiModal()
    {
        $this->selectedWikiId = null;
        $this->showAiModal = false;
    }

    public function render()
    {
        $wikis = Wiki::query()
            ->where('wiki_type', 'article')
            ->when($this->team, fn($query) => $query->where('team_id', $this->team->id))
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
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
                'space',
                'organisation.ministry',
                'organisation.department',
                'organisation.segment',
                'organisation.unit',
                'organisation.subUnit'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($this->quantity);

        return view('livewire.wiki.wiki-articles-table', [
            'wikis' => $wikis,
        ]);
    }
}
