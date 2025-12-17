<?php

namespace App\Livewire\Document;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class ArticleShow extends Component
{
    use Interactions, WithPagination;
    protected $listeners = ['refresh-articles-list' => '$refresh'];

    public ?int $quantity = 5;
    public string $search = '';

    public array $sort = [
        'column' => 'updated_at',
        'direction' => 'desc',
    ];

    public ?int $articleId = null;
    public ?Article $article = null;

    public array $selectedRows = [];
    protected $paginationTheme = 'tailwind';

    protected $queryString = ['search', 'quantity', 'sort'];

    #[On('refresh-articles-list')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    #[On('loadData-articles')]
    public function loadData(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] =
                $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }

        $this->resetPage();
    }


    public function setQuantity(int $value): void
    {
        $this->quantity = $value;
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }


    public function openArticle(int $id): void
    {
        $this->articleId = $id;
        $this->article   = Article::find($id);
    }
    public function toggleAll($checked): void
    {
        if ($checked) {
            $this->selectedRows = $this->rows->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function getRowsProperty()
    {
        return Article::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                      ->orWhere('slug', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function getHeadersProperty(): array
    {
        return [
            ['index' => 'title', 'label' => 'Title', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true],
            ['index' => 'updated_at', 'label' => 'Updated On', 'sortable' => true],
        ];
    }

    public function render()
    {
        return view('livewire.document.article-show', [
            'rows'    => $this->rows,
            'headers' => $this->headers,
            'sort'    => $this->sort,
        ]);
    }
}
