<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Activity;
use App\Models\Team;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Carbon\Carbon;

class ProfileShow extends Component
{
    public $user;
    public $isReady = false;
    public $statistics = [];
    public $recentActivities = [];
    public $teamMemberships = [];
    public $skillBadges = [];

    #[On('loadData-profile')]
    public function loadData()
    {
        $this->user = Auth::user();
        $this->calculateStatistics();
        $this->loadRecentActivities();
        $this->loadTeamMemberships();
        $this->loadSkillBadges();
        $this->isReady = true;
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->calculateStatistics();
        $this->loadRecentActivities();
        $this->loadTeamMemberships();
        $this->loadSkillBadges();
        $this->isReady = true;
    }

    private function calculateStatistics()
    {
        if (!$this->user) return;

        $this->statistics = [
            'projects_count' => $this->user->projects()->count(),
            'tasks_assigned' => Task::where('assigned_to', $this->user->id)->count(),
            'tasks_completed' => Task::where('assigned_to', $this->user->id)
                ->where('status', '4') // Completed status ID from SQL
                ->count(),
            'teams_count' => $this->user->team ? 1 : 0, // User can only be in one team
            'completion_rate' => $this->calculateCompletionRate(),
            'active_projects' => $this->user->projects()
                ->whereNotIn('id', function($query) {
                    $query->select('project_id')
                          ->from('tasks')
                          ->where('status', '4')
                          ->groupBy('project_id')
                          ->havingRaw('COUNT(*) = (SELECT COUNT(*) FROM tasks WHERE project_id = projects.id)');
                })->count(),
        ];
    }

    private function calculateCompletionRate()
    {
        $totalTasks = Task::where('assigned_to', $this->user->id)->count();

        if ($totalTasks === 0) return 0;

        $completedTasks = Task::where('assigned_to', $this->user->id)
            ->where('status', '4') // Completed status ID from SQL
            ->count();

        return round(($completedTasks / $totalTasks) * 100);
    }

    private function loadRecentActivities()
    {
        if (!$this->user) return;

        $this->recentActivities = Activity::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description ?: $this->getActivityDescription($activity->action),
                    'type' => $activity->action,
                    'project_name' => null, // Will be null since activities table doesn't have project_id yet
                    'task_name' => null, // Will be null since activities table doesn't have task_id yet
                    'created_at' => $activity->created_at->format('M d, Y'),
                    'time_ago' => $activity->created_at->diffForHumans(),
                    'icon' => $this->getActivityIcon($activity->action),
                    'color' => $this->getActivityColor($activity->action),
                ];
            });
    }

    private function loadTeamMemberships()
    {
        if (!$this->user) return;

        // Check if user has a team assigned (from users.team_id)
        $userTeam = $this->user->team;
        $teamMemberships = [];

        if ($userTeam) {
            $teamMemberships[] = [
                'id' => $userTeam->id,
                'name' => $userTeam->name,
                'description' => $userTeam->description ?? '',
                'members_count' => User::where('team_id', $userTeam->id)->count(),
                'role' => 'Member', // Default role since we don't have role info in the pivot
                'color' => 'blue',
            ];
        }

        $this->teamMemberships = $teamMemberships;
    }

    private function loadSkillBadges()
    {
        if (!$this->user) return;

        // This could be based on completed projects, tasks, etc.
        $badges = [];
        
        if ($this->statistics['projects_count'] >= 5) {
            $badges[] = ['name' => 'Project Leader', 'color' => 'green', 'icon' => 'tabler--award'];
        }
        
        if ($this->statistics['completion_rate'] >= 90) {
            $badges[] = ['name' => 'High Performer', 'color' => 'purple', 'icon' => 'tabler--star'];
        }
        
        if ($this->statistics['teams_count'] >= 3) {
            $badges[] = ['name' => 'Team Player', 'color' => 'blue', 'icon' => 'tabler--users'];
        }
        
        if ($this->statistics['tasks_completed'] >= 20) {
            $badges[] = ['name' => 'Task Master', 'color' => 'orange', 'icon' => 'tabler--check'];
        }

        $this->skillBadges = $badges;
    }

    private function getActivityDescription($action)
    {
        return match($action) {
            'deleted_task' => 'Deleted a task',
            'updated_member' => 'Updated team member information',
            'created_project' => 'Created a new project',
            'created_task' => 'Created a new task',
            'completed_task' => 'Completed a task',
            'updated_task' => 'Updated task details',
            'added_comment' => 'Added a comment',
            'uploaded_file' => 'Uploaded a file',
            default => ucfirst(str_replace('_', ' ', $action)),
        };
    }

    private function getActivityIcon($type)
    {
        return match($type) {
            'created_project', 'project_created' => 'tabler--folder-plus',
            'created_task', 'task_created' => 'tabler--plus',
            'completed_task', 'task_completed' => 'tabler--check',
            'updated_task', 'task_updated', 'updated_member' => 'tabler--edit',
            'added_comment', 'comment_added' => 'tabler--message',
            'uploaded_file', 'file_uploaded' => 'tabler--upload',
            'deleted_task' => 'tabler--trash',
            default => 'tabler--activity',
        };
    }

    private function getActivityColor($type)
    {
        return match($type) {
            'created_project', 'project_created' => 'blue',
            'created_task', 'task_created' => 'green',
            'completed_task', 'task_completed' => 'purple',
            'updated_task', 'task_updated', 'updated_member' => 'yellow',
            'added_comment', 'comment_added' => 'indigo',
            'uploaded_file', 'file_uploaded' => 'pink',
            'deleted_task' => 'red',
            default => 'gray',
        };
    }

    public function render()
    {
        return view('livewire.profile.profile-show');
    }
}
