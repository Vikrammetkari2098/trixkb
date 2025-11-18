<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wiki;
use App\Models\Team;
use App\Models\User;

class TicketTable extends Component
{
    use WithPagination;

    public Team $team;
    public User $user;

    public string $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $wikis = Wiki::with('organisation.ministry', 'organisation.department', 'organisation.segment', 'organisation.unit', 'organisation.subUnit')
            ->where('wiki_type', 'resolution')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhere('remark', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.users.ticket-table', [
            'wikis' => $wikis,
            'wikiCount' => $wikis->total(),
        ]);
    }
}
