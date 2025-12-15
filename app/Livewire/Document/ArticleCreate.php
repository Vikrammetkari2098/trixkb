<?php

namespace App\Livewire\Document;

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Models\Article;
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

    // Data for selects
    public $allTags;
    public $users;
    public $categories;

    protected $rules = [
        'title'        => 'required|string|max:255',
        'content'      => 'required|string',
        'category_id' => 'required|integer|exists:categories,category_id',
        'status'       => 'required|in:draft,in_review,published',
        'is_featured'  => 'boolean',
        'published_at' => 'nullable|date',
        'author_id'    => 'required|exists:users,id',
        'editor_id'    => 'nullable|exists:users,id',
        'tags'         => 'nullable|array',
        'tags.*'       => 'exists:tags,id',
    ];

    public function mount()
    {
        $this->allTags = Tag::orderBy('name')->get();
        $this->users = User::select('id', 'name')->get();
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

        $this->author_id = auth()->id();
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

   public function save()
    {
        $data = $this->validate();

        $article = Article::create([
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

        // ✅ success toast
        $this->toast()
            ->success('Success', 'Article created successfully')
            ->send();

        // ✅ refresh article table
        $this->dispatch('refresh-articles-list');

        // ✅ close modal (THIS WAS THE BUG)
        $this->dispatch('close-modal', id: 'modal-create');

        // ✅ reset form
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
