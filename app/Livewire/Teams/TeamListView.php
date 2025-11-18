<?php

namespace App\Livewire\Teams;

use App\Models\Role;
use App\Models\User;
use App\Models\Team;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Lazy;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use TallStackUi\Traits\Interactions;

#[Lazy()]
class TeamListView extends Component
{
    use WithPagination, Interactions;

    public $isReady = false;
    public $teamStats = [];

    #[On('loadData-team-list-view')]
    public function loadData()
    {
        $this->isReady = true;
        $this->loadTeamStats();
    }

    #[On('refresh-other-components')]
    public function refreshData()
    {
        $this->loadData();
    }

    protected function loadTeamStats()
    {
        $this->teamStats = Team::withCount(['users' => function ($query) {
                // You can add additional filters here if needed
            }])
            ->with(['users' => function ($query) {
                $query->with('roles')->limit(6); // Get first 6 members for preview
            }])
            ->get()
            ->map(function ($team) {
                $activeMembers = $team->users->filter(function ($user) {
                    return $user->email_verified_at !== null;
                })->count();

                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'total_members' => $team->users_count,
                    'active_members' => $activeMembers,
                    'inactive_members' => $team->users_count - $activeMembers,
                    'preview_members' => $team->users->take(6),
                    'color' => $this->getTeamColor($team->name),
                    'created_at' => $team->created_at ? $team->created_at->format('M d, Y') : 'N/A'
                ];
            })
            ->toArray();
    }

    protected function getTeamColor($teamName)
    {
        $colors = [
            'PHP' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-100', 'text' => 'text-blue-600'],
            '.Net' => ['bg' => 'bg-purple-500', 'light' => 'bg-purple-100', 'text' => 'text-purple-600'],
            'UI/UX' => ['bg' => 'bg-pink-500', 'light' => 'bg-pink-100', 'text' => 'text-pink-600'],
            'QA' => ['bg' => 'bg-green-500', 'light' => 'bg-green-100', 'text' => 'text-green-600'],
            'Marketing' => ['bg' => 'bg-orange-500', 'light' => 'bg-orange-100', 'text' => 'text-orange-600'],
        ];

        return $colors[$teamName] ?? ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-600'];
    }

    public function mount()
    {
        // Initial state
    }

    public function placeholder()
    {
        return view('livewire.teams.team-list-view-placeholder');
    }

    public function render()
    {
        return view('livewire.teams.team-list-view');
    }
}
