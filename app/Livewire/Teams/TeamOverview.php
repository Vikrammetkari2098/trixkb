<?php

namespace App\Livewire\Teams;

use App\Models\User;
use App\Models\Activity;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Lazy;
use Carbon\Carbon;

#[Lazy()]
class TeamOverview extends Component
{
    public $isReady = false;
    public $totalMembers = 0;
    public $activitiesCount = 0;
    public $totalTeams = 0;
    public $activeProjects = 0;
    public $completedTasks = 0;
    public $teamStats = [];
    public $recentActivities = [];

    #[On('loadData-team-overview')]
    public function loadData()
    {
        $this->isReady = true;
        $this->calculateStatistics();
        $this->loadTeamStats();
        $this->loadRecentActivities();
    }

    #[On('refresh-other-components')]
    public function refreshData()
    {
        $this->loadData();
    }

    protected function calculateStatistics()
    {
        $this->totalMembers = User::count();
        $this->activitiesCount = Activity::count();
        $this->totalTeams = Team::count();
        $this->activeProjects = Project::where('end_time', '>', Carbon::now())->count();
        $this->completedTasks = Task::where('status', '4')->count(); // Completed status
    }

    protected function loadTeamStats()
    {
        $this->teamStats = Team::withCount('users')
            ->get()
            ->map(function ($team) {
                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'members_count' => $team->users_count,
                    'color' => $this->getTeamColor($team->name)
                ];
            })
            ->toArray();
    }

    protected function loadRecentActivities()
    {
        $this->recentActivities = Activity::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($activity) {
                return [
                    'user_name' => $activity->user->name ?? 'Unknown User',
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'time_ago' => $activity->created_at->diffForHumans()
                ];
            })
            ->toArray();
    }

    protected function getTeamColor($teamName)
    {
        $colors = [
            'PHP' => 'bg-blue-100 text-blue-800',
            '.Net' => 'bg-purple-100 text-purple-800',
            'UI/UX' => 'bg-pink-100 text-pink-800',
            'QA' => 'bg-green-100 text-green-800',
            'Marketing' => 'bg-orange-100 text-orange-800',
        ];

        return $colors[$teamName] ?? 'bg-gray-100 text-gray-800';
    }

    public function mount()
    {
        // Initial state
    }

    public function placeholder()
    {
        return view('livewire.teams.team-overview-placeholder');
    }

    public function render()
    {
        return view('livewire.teams.team-overview');
    }
}
