<?php

namespace App\Livewire\Internal;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ArticleVersion;
use App\Models\Article;

class ArticleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $quantity = 4;
    public string $search = '';
    public string $filter = 'recent';
    public array $suggestions = [];
    public bool $showSuggestions = false;

    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    protected $listeners = [
        'refresh-articles-list' => '$refresh',
    ];

    public function updatedSearch(): void
    {
        if (strlen($this->search) < 2) {
            $this->suggestions = [];
            $this->showSuggestions = false;
            return;
        }

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
        $this->resetPage();
    }

    public function selectSuggestion(string $value): void
    {
        $this->search = $value;
        $this->showSuggestions = false;
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function updatingQuantity(): void
    {
        $this->resetPage();
    }

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

    public function getRowsProperty()
    {
        return ArticleVersion::query()
            ->where('visibility', 'internal')
            ->with([
                'article' => function ($query) {
                    $query->with(['author', 'category', 'tags'])
                          ->withCount(['likes', 'comments']);
                }
            ])
            ->whereHas('article', fn ($q) =>
                $q->where('status', 'published')
            )
            ->when(strlen($this->search) >= 2, fn ($q) =>
                $q->whereHas('article', fn ($qq) =>
                    $qq->where('title', 'like', '%' . $this->search . '%')
                       ->orWhere('slug', 'like', '%' . $this->search . '%')
                )
            )
            ->when($this->filter === 'popular', fn ($q) =>
                $q->orderByDesc('likes')
            )
            ->when($this->filter === 'trending', fn ($q) =>
                $q->orderByDesc('views')
            )
            ->when($this->filter === 'recent', fn ($q) =>
                $q->orderBy($this->sort['column'], $this->sort['direction'])
            )
            ->paginate($this->quantity);
    }

    public function getTopArticlesProperty()
    {
        return Article::query()
            ->where('status', 'published')
            ->whereExists(function ($q) {
                $q->selectRaw(1)
                  ->from('article_version')
                  ->whereColumn('article_version.article_id', 'article.id')
                  ->where('article_version.visibility', 'internal');
            })
            ->with(['author', 'category'])
            ->withCount(['likes', 'comments'])
            ->orderByRaw('(likes_count + comments_count) DESC')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.internal.article-list', [
            'articles'    => $this->rows,
            'topArticles' => $this->topArticles,
        ]);
    }
}
