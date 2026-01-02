<?php

namespace App\Livewire\Document;

use Livewire\Component;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Label;

class ArticleCreate extends Component
{
    use Interactions, WithFileUploads;

    /* =======================
     | Form Fields
     |=======================*/
    public $title;
    public $slug;
    public $content;
    public $category_id;
    public $status = 'draft';
    public $is_featured = false;
    public $author_id;
    public $tags = [];
    public $labels = [];
    public $article_image;

    public $users = [];
    public $categories = [];

    public $newCategory = [
        'name' => '',
        'location' => 'getting_started',
        'type' => 'index',
    ];

    public $showCategoryModal = false;
    public $kb_type = 'article';
    public $visibility = 'public';

    /* =======================
     | Validation
     |=======================*/
    protected $rules = [
        'title'         => 'required|string|max:255',
        'category_id'   => 'required|exists:categories,category_id',
        'status'        => 'required|in:draft,in_review,published',
        'kb_type'       => 'required|in:article,directory',
        'visibility'    => 'required|in:public,internal',
        'is_featured'   => 'boolean',
        'author_id'     => 'required|exists:users,id',
        'tags'          => 'nullable|array',
        'tags.*'        => 'string|max:50',
        'labels'        => 'nullable|array',
        'labels.*'      => 'string|max:50',
        'article_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ];
    protected function rulesForCategory()
    {
        return [
            'newCategory.name' => 'required|string|min:3|max:255|unique:categories,category_name',
        ];
    }
     public function searchLabels(string $query)
    {
        return Label::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn ($label) => [
                'value' => $label->name,
                'text'  => $label->name,
            ]);
    }
    public function searchTags(string $query)
    {
        return Tag::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn ($tag) => [
                'value' => $tag->name,
                'text'  => $tag->name,
            ]);
    }
    /* =======================
     | Mount
     |=======================*/
    public function mount()
    {
        $this->users = User::select('id', 'name')->get();
        $this->loadCategories();
        $this->author_id = auth()->id();
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    /* =======================
     | Categories
     |=======================*/
    public function loadCategories()
    {
        $this->categories = Category::where('category_status', 1)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($cat) => [
                'label' => $cat->category_name,
                'value' => $cat->category_id,
            ])
            ->toArray();
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
    /* =======================
     | Save Article (CMS Style)
     |=======================*/
    public function save()
    {
        $data = $this->validate();

        $initialVersion = '1.0';
        $imagePath = null;

        // Upload image
        if ($this->article_image) {
            $filename = time() . '_' . auth()->id() . '.' . $this->article_image->getClientOriginalExtension();
            $this->article_image->storeAs('assets/article_image', $filename, 'public');
            $imagePath = 'article_image/' . $filename;
        }

        DB::transaction(function () use ($data, $imagePath, $initialVersion) {

            /*  Create Article (NO version number here) */
            $article = Article::create([
                'title'         => $data['title'],
                'slug'          => $this->slug,
                'category_id'   => $data['category_id'],
                'status'        => $data['status'],
                'is_featured'   => $data['is_featured'],
                'author_id'     => $data['author_id'],
                'article_image' => $imagePath,
                'current_version_id' => null, // temporary
            ]);

            /*  Create First Version (1.0) */

                $initialVersion = '1.0'; // first version

               $version = ArticleVersion::create([
                'article_id'  => $article->id,
                'editor_id'   => auth()->id(),
                'version'     => $initialVersion,
                'content'     => $this->content,
                'status'      => $data['status'],
                'kb_type'     => $data['kb_type'],
                'visibility'  => $data['visibility'],
                'is_featured' => $data['is_featured'],
                'views'       => 0,
                'likes'       => 0,
            ]);


            /*  Sync current_version_id */
            $article->update([
                'current_version_id' => $version->id,
            ]);

            /* Tags */
            if (!empty($data['tags'])) {
                $tagIds = collect($data['tags'])->map(function ($name) {
                    return Tag::firstOrCreate(
                        ['slug' => Str::slug($name)],
                        ['name' => trim($name)]
                    )->id;
                });
                $article->tags()->sync($tagIds);
            }

            /* Labels */
            if (!empty($data['labels'])) {
                $labelIds = collect($data['labels'])->map(function ($name) {
                    return Label::firstOrCreate(
                        ['slug' => Str::slug($name)],
                        ['name' => trim($name)]
                    )->id;
                });
                $article->labels()->sync($labelIds);
            }
        });

        $this->toast()->success('Success', 'Article created with version 1.0')->send();

        $this->dispatch('refresh-articles-list');
        $this->dispatch('close-modal', id: 'modal-create');

        $this->reset([
            'title',
            'slug',
            'content',
            'category_id',
            'status',
            'kb_type',
            'visibility',
            'is_featured',
            'tags',
            'labels',
            'article_image',
        ]);

    }

    public function render()
    {
        return view('livewire.document.article-create');
    }
}
