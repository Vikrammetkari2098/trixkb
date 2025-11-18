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
class TeamRoleView extends Component
{
    use WithPagination, Interactions;

    public $isReady = false;
    public ?string $search = null;
    public ?int $quantity = 8;
    public array $selected = [];
    public ?string $selectedTeam = null;
    public ?string $selectedRole = null;
    public array $sort = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    #[On('loadData-team-role-view')]
    public function loadData()
    {
        $this->isReady = true;
    }

    #[On('refresh-other-components')]
    public function refreshData()
    {
        $this->loadData();
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedTeam()
    {
        $this->resetPage();
    }

    public function updatedSelectedRole()
    {
        $this->resetPage();
    }

    public function headers(): array
    {
        return [
            ['index' => 'name', 'label' => 'Name'],
            ['index' => 'email', 'label' => 'Email'],
            ['index' => 'team_name', 'label' => 'Team'],
            ['index' => 'role_name', 'label' => 'Role'],
            ['index' => 'member_created', 'label' => 'Date Added'],
            ['index' => 'last_active_at', 'label' => 'Last Active'],
            ['index' => 'action', 'label' => 'Actions'],
        ];
    }

    public function getTeamsProperty()
    {
        return Team::orderBy('name')->get();
    }

    public function getRolesProperty()
    {
        return Role::orderBy('name')->get();
    }

    public function mount()
    {
        // Initial state
    }

    public function placeholder()
    {
        return view('livewire.teams.team-role-view-placeholder');
    }

    public function with(): array
    {
        $baseQuery = User::query()
            ->with(['roles', 'team'])
            ->when($this->search, function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->selectedTeam, function (Builder $query) {
                $query->where('team_id', $this->selectedTeam);
            })
            ->when($this->selectedRole, function (Builder $query) {
                if ($this->selectedRole === 'none') {
                    $query->whereDoesntHave('roles');
                } else {
                    $query->whereHas('roles', function ($q) {
                        $q->where('roles.id', $this->selectedRole);
                    });
                }
            })
            ->orderBy($this->sort['column'], $this->sort['direction']);

        $users = $this->isReady 
            ? $baseQuery->paginate($this->quantity)
            : new LengthAwarePaginator([], 0, $this->quantity, 1, ['path' => request()->url()]);

        if ($users->count() > 0) {
            $users->getCollection()->transform(function ($user) {
                $user->team_name = $user->team ? $user->team->name : 'No Team';
                $roleNames = $user->roles->pluck('name')->map(function($name) {
                    return str_replace('_', ' ', ucwords($name, '_'));
                })->join(', ');
                $user->role_name = $roleNames ?: 'No Role';
                $user->member_created = $user->created_at ? $user->created_at->format('M d, Y') : '';
                $user->last_active_at = $user->updated_at ? $user->updated_at->diffForHumans() : 'Never';
                return $user;
            });
        }

        return [
            'headers' => $this->headers(),
            'users' => $users,
            'teams' => $this->teams,
            'roles' => $this->roles,
        ];
    }

    public function render()
    {
        return view('livewire.teams.team-role-view', $this->with());
    }
}
