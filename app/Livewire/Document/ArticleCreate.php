<?php

namespace App\Livewire\Document;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\ArticleVersion;

class ArticleCreate extends Component
{
    use Interactions;
    public $title;
    public $slug;
    public $content;
    public $category_id;
    public $status = 'draft';
    public $is_featured = false;
    public $published_at;
    public $author_id;
    public $tags = [];

    public $newCategory = [
        'name' => '',
        'location' => 'getting_started',
        'type' => 'index'
    ];
    public $showCategoryModal = false;
    public $tagSearch = '';
    public $allTags = [];
    public $users = [];
    public $categories = [];

    protected $rules = [
        'title'        => 'required|string|max:255',
        'category_id'  => 'required|integer|exists:categories,category_id',
        'status'       => 'required|in:draft,in_review,published',
        'is_featured'  => 'boolean',
        'author_id'    => 'required|exists:users,id',
        'tags'         => 'nullable|array',
        'tags.*'       => 'string|max:50',
    ];
    protected function rulesForCategory()
    {
        return [
            'newCategory.name' => 'required|string|min:3|max:255|unique:categories,category_name',
        ];
    }
    public function mount()
    {
        $this->users = User::select('id', 'name')->get();
        $this->loadCategories();
        $this->author_id = auth()->id();
    }
    public function searchTags(string $query)
    {
        return Tag::where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(5)
            ->get()
            ->map(fn ($tag) => [
                'value' => $tag->name,
                'text'  => $tag->name,
            ]);
    }
    public function loadCategories()
    {
        $this->categories = Category::where('category_status', 1)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($cat) => [
                'label' => (string) $cat->category_name,
                'value' => (int) $cat->category_id,
            ])->toArray();
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

        $this->toast()->success('Success', 'Category created successfully!')->send();
    }
    public function resetNewCategoryForm()
    {
        $this->newCategory = [
            'name' => '',
            'location' => 'getting_started',
            'type' => 'index'
        ];
    }

    // Save article
    public function save()
    {
        $data = $this->validate();

        DB::transaction(function () use ($data) {

            //  Create article (master)
            $article = Article::create([
                'title'       => $data['title'],
                'slug'        => $this->slug ?: Str::slug($data['title']),
                'category_id' => $data['category_id'],
                'status'      => $data['status'],
                'is_featured' => $data['is_featured'],
                'author_id'   => $data['author_id'],
            ]);

            //  Create first version
            $version = ArticleVersion::create([
                'article_id'   => $article->id,
                'editor_id'    => auth()->id(),
                'title'        => $data['title'],
                'slug'         => $article->slug,
                'content'      => null, // <-- IMPORTANT
                'status'       => $data['status'],
                'is_featured'  => $data['is_featured'],
                'views'        => 0,
                'likes'        => 0,
                'published_at' => null,
            ]);

            //  Update article with current version
            $article->update([
                'current_version_id' => $version->id,
            ]);

            //  Tags
            if (!empty($data['tags'])) {
                $tagIds = [];

                foreach ($data['tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => trim($tagName)]
                    );

                    $tagIds[] = $tag->id;
                }

                $article->tags()->sync($tagIds);
            }
        });

        $this->toast()->success('Success', 'Article created successfully')->send();
        $this->dispatch('refresh-articles-list');
        $this->dispatch('close-modal', id: 'modal-create');

        $this->reset([
            'title', 'slug', 'content', 'category_id',
            'status', 'author_id', 'tags'
        ]);
    }

    public function render()
    {
        return view('livewire.document.article-create');
    }
}
