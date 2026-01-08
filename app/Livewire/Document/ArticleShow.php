<?php

namespace App\Livewire\Document;

use App\Models\Article;
use Livewire\Component;
use App\Models\ArticleVersion;
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

    /* ------------------
        STATE
    ------------------ */
    public ?int $quantity = 5;

    // 🔍 Title / Slug search
    public string $search = '';

    // 🔢 Version search
    public string $version = '';

    public array $sort = [
        'column' => 'updated_at',
        'direction' => 'desc',
    ];

    public ?int $articleId ;
    public ?Article $article  ;

    public array $selectedRows = [];

    protected $queryString = [
        'search',
        'version',
        'quantity',
        'sort',
    ];

    /* ------------------
        LIFECYCLE
    ------------------ */
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

    /* ------------------
        UPDATERS
    ------------------ */
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

    /* ------------------
        SORTING
    ------------------ */
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

    /* ------------------
        DATA
    ------------------ */
   public function getRowsProperty()
{
    return Article::with(['tags', 'labels'])
        ->where('is_hide', 0) // 👈 hidden remove
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

    public ?int $selectedArticleId = null;

  /* ------------------
        UNPUBLISH
    ------------------ */
    public function unpublishSelected(): void
    {
        if (! $this->selectedArticleId) {
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
            $this->toast()
                ->warning('Please select an article first')
                ->send();
            return;
        }

        $version = ArticleVersion::where('article_id', $this->selectedArticleId)->first();

        if (!$version) {
            $this->toast()
                ->error('Article version not found')
                ->send();
            return;
        }

        $newVisibility = $version->visibility === 'public'
            ? 'internal'
            : 'public';

        $version->update([
            'visibility' => $newVisibility,
        ]);

        $this->toast()
            ->success(
                $newVisibility === 'public'
                    ? 'Moved to Public'
                    : 'Moved to Internal'
            )
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


    /* ------------------
        ACTIONS
    ------------------ */
    public function openArticle(int $id): void
    {
        $this->articleId = $id;
        $this->article   = Article::find($id);
    }

    public function toggleAll(bool $checked): void
    {
        if ($checked) {
            $this->selectedRows = $this->rows->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function exportExcel(array $ids = [])
    {
        return Excel::download(
            new ArticlesExport($ids),
            'articles_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
    /* ------------------
    FAVOURITE
------------------ */
public function toggleFavourite(int $articleId): void
{
    $article = Article::findOrFail($articleId);
    $article->timestamps = false;

    $article->update([
        'is_favourite' => ! $article->is_favourite,
    ]);
}

public function bulkFavourite(array $ids = []): void
{
    $ids = $ids ?: $this->selectedRows;
    if (empty($ids)) return;

    Article::whereIn('id', $ids)
        ->update(['is_favourite' => true]);

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



    /* ------------------
        RENDER
    ------------------ */
    public function render()
    {
        return view('livewire.document.article-show', [
            'rows'    => $this->rows,
            'headers' => $this->headers,
            'sort'    => $this->sort,
        ]);
    }
}
