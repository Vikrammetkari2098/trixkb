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

    public ?int $quantity = 5;
    public string $search = '';

    public array $sort = [
        'column' => 'updated_at',
        'direction' => 'desc',
    ];

    public ?int $articleId = null;
    public ?Article $article = null;

    protected $paginationTheme = 'tailwind';
    #[On('refresh-articles-list')]
    public function refreshList(): void
    {
        $this->resetPage();
    }


    /* -------------------------
     | Sorting
     |--------------------------*/
    public function sortBy($column): void
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

    /* -------------------------
     | Computed rows
     |--------------------------*/
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

    /* -------------------------
     | Table headers
     |--------------------------*/
    public function getHeadersProperty(): array
    {
        return [
            ['index' => 'title', 'label' => 'Title', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true],
            ['index' => 'updated_at', 'label' => 'Updated On', 'sortable' => true],
        ];
    }

    /* -------------------------
     | Row click
     |--------------------------*/
    public function openArticle(int $id): void
    {
        $this->articleId = $id;
        $this->article   = Article::find($id);
    }

    #[On('loadData-articles')]
    public function loadData(): void
    {
        $this->resetPage();
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
