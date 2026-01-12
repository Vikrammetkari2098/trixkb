<?php

namespace App\Livewire\Document;

use App\Models\Article;
use App\Models\ArticleVersion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArticlesExport;

class ArticleShow extends Component
{
    use Interactions, WithPagination;

    protected $listeners = ['refresh-articles-list' => '$refresh'];
    protected $paginationTheme = 'tailwind';

    public ?int $quantity = 5;
    public string $search = '';
    public string $version = '';
    public array $sort = [
        'column' => 'updated_at',
        'direction' => 'desc',
    ];

    public ?int $articleId;
    public ?Article $article;
    public array $selectedRows = [];
    public ?int $selectedArticleId = null;
    public array $hiddenArticleIds = [];

    protected $queryString = [
        'search',
        'version',
        'quantity',
        'sort',
    ];

    #[On('refresh-articles-list')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    #[On('loadData-articles')]
    public function loadData(): void
    {
        $this->resetPage();
        $this->hiddenArticleIds = Article::where('is_hide', 1)->pluck('id')->toArray();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedVersion(): void
    {
        $this->resetPage();
    }

    public function setQuantity(int $value): void
    {
        $this->quantity = $value;
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

    public function getRowsProperty()
    {
        return Article::with(['tags', 'labels'])

            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                      ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->when($this->version, function ($query) {
                $query->whereHas('versions', function ($q) {
                    $q->where('version', 'like', "%{$this->version}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate($this->quantity);
    }

    public function unpublishSelected(): void
    {
        if (!$this->selectedArticleId) {
            return;
        }

        Article::where('id', $this->selectedArticleId)
            ->where('status', 'published')
            ->update([
                'status' => 'draft',
            ]);
    }

    public function setSelectedArticle(int $id): void
    {
        $this->selectedArticleId = $id;
    }

    public function toggleVisibility(): void
    {
        if (!$this->selectedArticleId) {
            $this->toast()->warning('Please select an article first')->send();
            return;
        }

        $version = ArticleVersion::where('article_id', $this->selectedArticleId)->first();

        if (!$version) {
            $this->toast()->error('Article version not found')->send();
            return;
        }

        $newVisibility = $version->visibility === 'public' ? 'internal' : 'public';

        $version->update(['visibility' => $newVisibility]);

        $this->toast()
            ->success($newVisibility === 'public' ? 'Moved to Public' : 'Moved to Internal')
            ->send();
    }

    public function getHeadersProperty(): array
    {
        return [
            ['index' => 'title', 'label' => 'Title', 'sortable' => true],
            ['index' => 'status', 'label' => 'Status', 'sortable' => true],
            ['index' => 'updated_at', 'label' => 'Updated On', 'sortable' => true],
        ];
    }

    public function openArticle(int $id): void
    {
        $this->articleId = $id;
        $this->article = Article::find($id);
    }

    public function toggleAll(bool $checked): void
    {
        if ($checked) {
            $this->selectedRows = $this->rows->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
    }
    public function hideSelected(array $ids = []): void
    {
        if (empty($ids)) {
            $this->toast()->warning('Please select at least one article')->send();
            return;
        }

        Article::whereIn('id', $ids)->update([
            'is_hide' => 1,
        ]);

        $this->toast()->success('Selected articles hidden successfully')->send();
    }

    public function toggleHide(array $ids = []): void
 {
    if (empty($ids)) return;

    $hasHidden = Article::whereIn('id', $ids)->where('is_hide', 1)->exists();

    Article::whereIn('id', $ids)->update([
        'is_hide' => $hasHidden ? 0 : 1,
    ]);

    // Update hiddenArticleIds property
    $this->hiddenArticleIds = Article::where('is_hide', 1)->pluck('id')->toArray();

    $this->toast()->success($hasHidden ? 'Selected articles are now visible' : 'Selected articles are now hidden')->send();
 }


    public function exportExcel(array $ids = [])
    {
        return Excel::download(
            new ArticlesExport($ids),
            'articles_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function toggleFavourite(int $articleId): void
    {
        $article = Article::findOrFail($articleId);
        $article->timestamps = false;
        $article->update(['is_favourite' => !$article->is_favourite]);
    }

    public function bulkFavourite(array $ids = []): void
    {
        $ids = $ids ?: $this->selectedRows;
        if (empty($ids)) return;

        Article::whereIn('id', $ids)->update(['is_favourite' => true]);
        $this->selectedRows = [];
    }

    public function starSelected(array|int $articleIds): void
    {
        $ids = is_array($articleIds) ? $articleIds : [$articleIds];
        if (empty($ids)) return;

        Article::whereIn('id', $ids)->update([
            'is_favourite' => true,
            'updated_at' => \DB::raw('updated_at')
        ]);

        if (is_array($articleIds)) {
            $this->selectedRows = [];
        }
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
