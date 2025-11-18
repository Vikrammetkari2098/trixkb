<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Team;
use App\Models\Meeting;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardShow extends Component
{
    public $userStats = [];
    public $projectStats = [];
    public $teamStats = [];
    public $recentActivities = [];
    public $upcomingDeadlines = [];
    public $todaysMeetings = [];
    public $teamMembers = [];
    public $activeProjects = [];
    public $isReady = false;
    
    public function loadData()
    {
        $this->loadDashboardData();
        $this->isReady = true;
    }
    
    public function mount()
    {
        // Don't load data immediately to show skeleton
    }

    private function loadDashboardData()
    {
        $this->loadUserStats();
        $this->loadProjectStats();
        $this->loadTeamStats();
        $this->loadRecentActivities();
        $this->loadUpcomingDeadlines();
        $this->loadTodaysMeetings();
        $this->loadTeamMembers();
        $this->loadActiveProjects();
    }

    #[On('refreshDashboard')]
    public function refreshDashboard()
    {
        $this->loadDashboardData();
        $this->isReady = true;
        $this->dispatch('dashboard-refreshed');
    }

    private function loadUserStats()
    {
        $user = Auth::user();
        
        // Get user's assigned tasks statistics
        $completedTasks = $user->assignedTasks()
            ->where('status', 4) // Completed status ID as integer
            ->count();
            
        $inProgressTasks = $user->assignedTasks()
            ->where('status', 2) // In-Progress status ID as integer
            ->count();
            
        $totalTasks = $user->assignedTasks()->count();
        
        // Calculate completion rate
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        
        // Tasks due this week
        $tasksDueThisWeek = $user->assignedTasks()
            ->whereBetween('end_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $this->userStats = [
            'completed_tasks' => $completedTasks,
            'in_progress_tasks' => $inProgressTasks,
            'total_tasks' => $totalTasks,
            'completion_rate' => $completionRate,
            'tasks_due_this_week' => $tasksDueThisWeek,
        ];
    }

    private function loadProjectStats()
    {
        $user = Auth::user();
        
        // Get user's projects
        $activeProjects = $user->projects()
            ->where('end_time', '>=', Carbon::now())
            ->count();
            
        $endingSoonProjects = $user->projects()
            ->whereBetween('end_time', [Carbon::now(), Carbon::now()->addDays(7)])
            ->count();

        $this->projectStats = [
            'active_projects' => $activeProjects,
            'ending_soon' => $endingSoonProjects,
        ];
    }

    private function loadTeamStats()
    {
        $user = Auth::user();
        
        if ($user->team) {
            $teamMembersCount = $user->team->users()->count();
            $onlineMembers = $user->team->users()
                ->where('updated_at', '>=', Carbon::now()->subMinutes(5))
                ->count();
        } else {
            $teamMembersCount = 0;
            $onlineMembers = 0;
        }

        $this->teamStats = [
            'total_members' => $teamMembersCount,
            'online_members' => $onlineMembers,
        ];
    }

    private function loadRecentActivities()
    {
        $user = Auth::user();
        
        // Get user's project IDs
        $userProjectIds = $user->projects->pluck('id')->toArray();
        
        $this->recentActivities = Activity::where(function($query) use ($user, $userProjectIds) {
                $query->where('user_id', $user->id);
                if (!empty($userProjectIds)) {
                    $query->orWhereIn('project_id', $userProjectIds);
                }
            })
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description ?: $activity->action,
                    'user_name' => $activity->user->name ?? 'Unknown User',
                    'created_at' => $activity->created_at->diffForHumans(),
                    'type' => $activity->type ?? 'general',
                ];
            });
    }

    private function loadUpcomingDeadlines()
    {
        $user = Auth::user();
        
        $this->upcomingDeadlines = $user->assignedTasks()
            ->with(['project', 'priority'])
            ->where('end_time', '>=', Carbon::now())
            ->orderBy('end_time', 'asc')
            ->take(5)
            ->get()
            ->map(function($task) {
                $daysUntilDeadline = Carbon::now()->diffInDays($task->end_time, false);
                $urgency = 'low';
                
                if ($daysUntilDeadline <= 1) {
                    $urgency = 'high';
                } elseif ($daysUntilDeadline <= 3) {
                    $urgency = 'medium';
                }
                
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'project_name' => $task->project->title ?? 'No Project',
                    'due_date' => $task->end_time->format('M d'),
                    'due_time' => $task->end_time->format('g:i A'),
                    'urgency' => $urgency,
                    'days_until' => $daysUntilDeadline,
                ];
            });
    }

    private function loadTodaysMeetings()
    {
        $user = Auth::user();
        
        $this->todaysMeetings = $user->meetings()
            ->whereDate('start_time', Carbon::today())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get()
            ->map(function($meeting) {
                return [
                    'id' => $meeting->id,
                    'title' => $meeting->title,
                    'start_time' => $meeting->start_time->format('g:i A'),
                    'end_time' => $meeting->end_time->format('g:i A'),
                    'type' => $meeting->meetingType->name ?? 'General',
                ];
            });
    }

    private function loadTeamMembers()
    {
        $user = Auth::user();
        
        if ($user->team) {
            $this->teamMembers = $user->team->users()
                ->with(['assignedTasks'])
                ->take(4)
                ->get()
                ->map(function($member) {
                    $activeTasks = $member->assignedTasks()
                        ->whereIn('status', [1, 2]) // To-do and In-Progress as integers
                        ->count();
                    $completedTasks = $member->assignedTasks()
                        ->where('status', 4) // Completed as integer
                        ->count();
                    
                    $totalTasks = $member->assignedTasks()->count();
                    $performance = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                    
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'initials' => $this->getInitials($member->name),
                        'email' => $member->email,
                        'active_tasks' => $activeTasks,
                        'performance' => $performance,
                        'last_active' => $member->updated_at->diffForHumans(),
                    ];
                });
        } else {
            $this->teamMembers = collect();
        }
    }

    private function loadActiveProjects()
    {
        $user = Auth::user();
        
        $this->activeProjects = $user->projects()
            ->with(['tasks', 'priority', 'users'])
            ->where('end_time', '>=', Carbon::now())
            ->orderBy('end_time', 'asc')
            ->take(3)
            ->get()
            ->map(function($project) {
                $totalTasks = $project->tasks->count();
                $completedTasks = $project->tasks->where('status', 4)->count(); // Completed status ID as integer
                $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                
                $daysUntilDeadline = Carbon::now()->diffInDays($project->end_time, false);
                
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'progress' => $progress,
                    'total_tasks' => $totalTasks,
                    'completed_tasks' => $completedTasks,
                    'due_date' => $project->end_time->format('M d, Y'),
                    'days_until_deadline' => $daysUntilDeadline,
                    'priority' => $project->priority->name ?? 'Medium',
                    'team_count' => $project->users->count(),
                    'team_members' => $project->users->take(3)->map(function($user) {
                        return [
                            'initials' => $this->getInitials($user->name),
                            'name' => $user->name,
                        ];
                    }),
                ];
            });
    }

    private function getInitials($name)
    {
        $names = explode(' ', $name);
        $initials = '';
        
        foreach ($names as $n) {
            if (!empty($n)) {
                $initials .= strtoupper($n[0]);
            }
        }
        
        return substr($initials, 0, 2);
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-show');
    }
}
