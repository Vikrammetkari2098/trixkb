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

    // 🔽 Suggestions state
    public array $suggestions = [];
    public bool $showSuggestions = false;

    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    protected $listeners = [
        'refresh-articles-list' => '$refresh',
    ];

    /* -------------------------
     | Search update (Suggestions logic ✅)
     |--------------------------*/
    public function updatedSearch(): void
    {
        // 2 characters पेक्षा कमी असतील तर suggestions hide
        if (strlen($this->search) < 2) {
            $this->suggestions = [];
            $this->showSuggestions = false;
            return;
        }

        // 🔍 Suggestions query
        $this->suggestions = ArticleVersion::query()
            ->whereHas('article', function ($q) {
                $q->where('status', 'published')
                  ->where('title', 'like', '%' . $this->search . '%');
            })
            ->with('article:id,title')
            ->limit(5)
            ->get()
            ->pluck('article.title')
            ->unique()
            ->values()
            ->toArray();

        $this->showSuggestions = count($this->suggestions) > 0;

        // pagination safe
        $this->resetPage();
    }

    /* -------------------------
     | Suggestion select
     |--------------------------*/
    public function selectSuggestion(string $value): void
    {
        $this->search = $value;
        $this->showSuggestions = false;
        $this->resetPage();
    }

    /* -------------------------
     | Pagination reset hooks
     |--------------------------*/
    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function updatingQuantity(): void
    {
        $this->resetPage();
    }

    /* -------------------------
     | Filters & sorting
     |--------------------------*/
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
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
     | Articles query (Search already embedded)
     |--------------------------*/
    public function getRowsProperty()
    {
        return ArticleVersion::query()
        ->with([
            'article' => function ($query) {
                $query->with(['author', 'category', 'tags'])
                      ->withCount(['likes', 'comments']);    
            }
        ])
            ->whereHas('article', fn ($q) =>
                $q->where('status', 'published')
            )

            /* 🔍 Main search (min 2 chars) */
            ->when(strlen($this->search) >= 2, fn ($q) =>
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
