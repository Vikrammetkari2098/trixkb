<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ArticleVersion;
use App\Models\User;

class ArticleList extends Component
{
    use WithPagination;
public $sort = 'recent';

    public function updatedSort()
    {
        $this->resetPage();
    }
    public $filter = 'recent';
    protected $paginationTheme = 'tailwind';

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        // Start query
        $query = ArticleVersion::with('author')->where('status','published');

        // Apply filter
        if($this->filter == 'popular'){
            $query->orderByDesc('likes_count');
        } elseif($this->filter == 'trending'){
            $query->orderByDesc('views_count'); // Make sure views_count exists
        } else {
            $query->orderByDesc('published_at');
        }

        // Paginate
        $articles = $query->paginate(10);

        // Top authors based on published articles
        $topAuthors = User::withCount(['articles' => function($q){
                $q->where('status','published');
            }])
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        return view('livewire.user.article-list', compact('articles','topAuthors'));
    }
    
}
