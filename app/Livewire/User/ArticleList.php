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

    // UI state
    public int $quantity = 3;
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
     | Reactive hooks
     |--------------------------*/
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function updatedQuantity()
    {
        $this->resetPage();
    }

    /* -------------------------
     | Filter & sorting
     |--------------------------*/
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        $this->sort['column'] = $column;
        $this->sort['direction'] = 'desc'; // always DESC
        $this->resetPage();
    }

    /* -------------------------
     | Articles query
     |--------------------------*/
    public function getRowsProperty()
    {
        $query = ArticleVersion::query()
            ->with([
                'article.author',
                'article.labels',
            ])
            ->where('status', 'published');

        // 🔍 Search
        if (!empty($this->search)) {
            $query->whereHas('article', function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('slug', 'like', "%{$this->search}%");
            });
        }

        // 🔽 Filters
        if ($this->filter === 'popular') {
            $query->orderByDesc('likes');
        } elseif ($this->filter === 'trending') {
            $query->orderByDesc('views');
        } else {
            // recent (default)
            $query->orderBy(
                $this->sort['column'],
                $this->sort['direction']
            );
        }

        return $query->paginate($this->quantity);
    }

    /* -------------------------
     | Top Authors
     |--------------------------*/
    public function getTopAuthorsProperty()
    {
        return User::withCount([
                'articles as articles_count' => function ($q) {
                    $q->where('status', 'published');
                }
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
