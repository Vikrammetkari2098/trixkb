<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ArticleVersion;
use App\Models\User;

class ArticleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /* -------------------------
     | UI State
     |--------------------------*/
    public int $quantity = 4;
    public string $search = '';
    public string $filter = 'recent';

    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    protected $listeners = [
        'refresh-articles-list' => '$refresh',
    ];

    /* -------------------------
     | Pagination reset hooks
     |--------------------------*/
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingQuantity()
    {
        $this->resetPage();
    }

    /* -------------------------
     | Filters & sorting
     |--------------------------*/
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        // DO NOT resetPage() here
    }

    public function sortBy(string $column): void
    {
        if (!in_array($column, ['created_at', 'views', 'likes'])) {
            return;
        }

        if ($this->sort['column'] === $column) {
            $this->sort['direction'] =
                $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = [
                'column'    => $column,
                'direction' => 'desc',
            ];
        }

        $this->resetPage();
    }

    /* -------------------------
     | Articles query
     |--------------------------*/
    public function getRowsProperty()
    {
        return ArticleVersion::query()
            ->with([
                'article.author',
                'article.category',
                'article.tags',
            ])
            ->whereHas('article', fn ($q) =>
                $q->where('status', 'published')
            )

            /* 🔍 Search */
            ->when($this->search, fn ($q) =>
                $q->whereHas('article', fn ($qq) =>
                    $qq->where('title', 'like', '%' . $this->search . '%')
                       ->orWhere('slug', 'like', '%' . $this->search . '%')
                )
            )

            /* 🔽 Filters */
            ->when($this->filter === 'popular', fn ($q) =>
                $q->orderByDesc('likes')
            )
            ->when($this->filter === 'trending', fn ($q) =>
                $q->orderByDesc('views')
            )
            ->when($this->filter === 'recent', fn ($q) =>
                $q->orderBy(
                    $this->sort['column'],
                    $this->sort['direction']
                )
            )

            ->paginate($this->quantity);
    }

    /* -------------------------
     | Top Authors
     |--------------------------*/
    public function getTopAuthorsProperty()
    {
        return User::withCount([
                'articles as articles_count' => fn ($q) =>
                    $q->where('status', 'published')
            ])
            ->orderByDesc('articles_count')
            ->limit(5)
            ->get();
    }

    /* -------------------------
     | Render
     |--------------------------*/
    public function render()
    {
        return view('livewire.user.article-list', [
            'articles'   => $this->rows,
            'topAuthors' => $this->topAuthors,
        ]);
    }
}
