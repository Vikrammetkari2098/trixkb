<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Doc;
use Illuminate\Support\Facades\Auth;

class DocumentList extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Doc::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.dashboard.document-list', compact('documents'));
    }
}
