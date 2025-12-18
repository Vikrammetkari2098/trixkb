<?php

namespace App\Livewire\Document;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Models\ArticleVersion;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleCreate extends Component
{
    use Interactions;

    // Form fields
    public $title;
    public $slug;
    public $content;
    public $category_id;
    public $status = 'draft';
    public $is_featured = false;
    public $published_at;
    public $author_id;
    public $editor_id;
    public $tags = [];

    // New Category Modal fields
    public $newCategory = [
        'name' => '',
        'location' => 'getting_started',
        'type' => 'index'
    ];
    public $showCategoryModal = false;
    public $tagSearch = '';


    // Data for selects
    public $allTags;
    public $users;
    public $categories;
    public function updatedTagSearch($value)
{
    $this->tagSearch = trim($value);
}
    public function createTag()
    {
        if ($this->tagSearch === '') {
            return;
        }

        // Check if tag exists (case-insensitive)
        $tag = Tag::whereRaw('LOWER(name) = ?', [strtolower($this->tagSearch)])
            ->first();

        if (!$tag) {
            $tag = Tag::create([
                'name' => $this->tagSearch,
                'slug' => Str::slug($this->tagSearch),
            ]);

            // Reload tag list
            $this->allTags = Tag::orderBy('name')->get();
        }

        // Select tag
        if (!in_array($tag->id, $this->tags)) {
            $this->tags[] = $tag->id;
        }

        // Clear search text
        $this->tagSearch = '';
    }

    protected $rules = [
        'title'        => 'required|string|max:255',
        'content'      => 'required|string',
        'category_id'  => 'required|integer|exists:categories,category_id',
        'status'       => 'required|in:draft,in_review,published',
        'is_featured'  => 'boolean',
        'published_at' => 'nullable|date',
        'author_id'    => 'required|exists:users,id',
        'editor_id'    => 'nullable|exists:users,id',
        'tags'         => 'nullable|array',
        'tags.*'       => 'exists:tags,id',
    ];

    protected function rulesForCategory()
    {
        return [
            'newCategory.name' => 'required|string|min:3|max:255|unique:categories,category_name',
        ];
    }


    public function mount()
    {
        $this->allTags = Tag::orderBy('name')->get();
        $this->users = User::select('id', 'name')->get();
        $this->loadCategories();
        $this->author_id = auth()->id();
    }

    public function loadCategories()
    {
        $this->categories = Category::where('category_status', 1)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($cat) {
                return [
                    'label' => (string) $cat->category_name,
                    'value' => (int) $cat->category_id,
                ];
            })
            ->values()
            ->toArray();
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function createCategory()
    {
        $this->validate($this->rulesForCategory());
        $maxSortOrder = Category::max('sort_order') ?? 0;

        $category = Category::create([
            'category_name'   => $this->newCategory['name'],
            'slug'            => Str::slug($this->newCategory['name']),
            'parent_id'       => null,
            'category_status' => 1,
            'sort_order'      => $maxSortOrder + 1,
        ]);

        $this->resetNewCategoryForm();

        $this->showCategoryModal = false;
        $this->loadCategories();
        $this->category_id = $category->category_id;
        $this->toast()
            ->success('Success', 'Category created successfully!')
            ->send();
    }


    public function resetNewCategoryForm()
    {
        $this->newCategory = [
            'name' => '',
            'location' => 'getting_started',
            'type' => 'index'
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $article = ArticleVersion::create([
            'title'        => $data['title'],
            'slug'         => $this->slug ?: Str::slug($data['title']),
            'content'      => $data['content'],
            'category_id'  => $data['category_id'],
            'status'       => $data['status'],
            'is_featured'  => $data['is_featured'],
            'author_id'    => $data['author_id'],
            'editor_id'    => $data['editor_id'],
            'published_at' => $data['status'] === 'published'
                ? ($data['published_at']
                    ? Carbon::parse($data['published_at'])
                    : now())
                : null,
        ]);

        if (!empty($data['tags'])) {
            $article->tags()->sync($data['tags']);
        }
        $this->toast()
            ->success('Success', 'Article created successfully')
            ->send();

        $this->dispatch('refresh-articles-list');
        $this->dispatch('close-modal', id: 'modal-create');
        $this->reset([
            'title',
            'slug',
            'content',
            'category_id',
            'status',
            'is_featured',
            'published_at',
            'editor_id',
            'tags',
        ]);
    }

    public function render()
    {
        return view('livewire.document.article-create');
    }
}
