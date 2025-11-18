<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wiki;
use App\Models\Team;

class WikiShow extends Component
{
    use WithPagination;

    public Team $team;
    public $user;
    public $pageType = 'article';
    public $perPage = 10;
    public $sortBy = 'latest';
    public $title = '';

    protected $paginationTheme = 'tailwind';

    public function mount($team, $user, $pageType = 'article')
    {
        $this->team = $team;
        $this->user = $user;
        $this->pageType = strtolower($pageType);

        // Set page title
        $this->title = $this->pageType === 'directory' ? 'Directory' : 'Article';
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $wikis = Wiki::with(['space'])
            ->where('wiki_type', $this->pageType);

        // Sorting
        if ($this->sortBy === 'latest') {
            $wikis->orderBy('created_at', 'desc');
        } elseif ($this->sortBy === 'oldest') {
            $wikis->orderBy('created_at', 'asc');
        } else { // views
            $wikis->orderBy('views', 'desc');
        }

        return view('livewire.wiki.wiki-show', [
                'wikis' => $wikis,
                'title' => ucfirst($this->pageType), // 'Article' or 'Directory'
        ]);
    }
}
