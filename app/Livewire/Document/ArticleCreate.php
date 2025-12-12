<?php
namespace App\Livewire\Document;

use Livewire\Component;
use App\Models\Article;
use App\Models\Category;

class ArticleCreate extends Component
{
    public $title, $content, $categories, $category_id;
    public $newCategory;


    public function mount()
    {
        $this->categories = Category::all();

    }

    public function save()
    {
        $this->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        Article::create([
            'title'        => $this->title,
            'content'      => $this->content,
            'category_id'  => $this->category_id,
        ]);

        session()->flash('success', 'Article created successfully!');

        $this->dispatch('article-created');
        $this->dispatch('close-modal', id: 'modal-article-create');

        $this->reset(['title', 'content', 'category_id']);
    }
    public function createCategory()
    {
        $this->validate([
            'newCategory' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $this->newCategory,
        ]);

       // $this->categories = Category::all();
        $this->category_id = $category->id;
        $this->newCategory = '';
        $this->dispatch('close-modal', id: 'modal-create-category');
    }

   public function render()
{
    // Make sure $this->categories is Eloquent collection
    $categoriesOptions = $this->categories->map(function ($cat) {
        return [
            'label' => $cat->category_name, // MUST be 'label'
            'value' => $cat->category_id,   // MUST be 'value'
        ];
    })->toArray();

    return view('livewire.document.article-create', [
        'categoriesOptions' => $categoriesOptions,
    ]);
}

}
