<?php

namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use App\Models\Project;
use App\Models\Team;
use App\Services\RBACService;

class TaskOverview extends Component
{
    use WithPagination, Interactions;

    public bool $isReady = false;
    public ?int $quantity = 5;
    public ?int $projectId = null;
    public ?int $selectedTeam = null;
    public ?string $selectedUser = '';
    public array $teams = [];
    public array $users = [];
    public string $context = 'global';

    #[On('loadData-task-overview')]
    public function loadData()
    {
        $this->isReady = true;
    }

    public function mount($projectId = null, $context = 'global')
    {
        $this->projectId = $projectId;
        $this->context = $context;
        $this->teams = Team::all()->toArray();
        $this->users = User::all()->toArray();
    }

    public function memberHeaders(): array
    {
        return [
            ['index' => 'name', 'label' => 'Name'],
            ['index' => 'assigned', 'label' => 'Assigned'],
            ['index' => 'completed', 'label' => 'Completed'],
            ['index' => 'ongoing', 'label' => 'Ongoing'],
            ['index' => 'action', 'label' => 'Action'],
        ];
    }

    public function teamPerformance()
    {
        if (!$this->isReady) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->quantity);
        }

        $users = User::select('id', 'name')
            ->when($this->selectedTeam, function ($query) {
                $query->where('team_id', $this->selectedTeam);
            })
            ->when($this->selectedUser && $this->selectedUser !== '', function ($query) {
                $query->where('id', $this->selectedUser);
            })
            ->withCount([
                'assignedTasks as assigned' => function($q) {
                    return $this->projectId ? $q->where('project_id', $this->projectId) : $q;
                },
                'assignedTasks as completed' => function($q) {
                    return $this->projectId
                        ? $q->where('status', 4)->where('project_id', $this->projectId)
                        : $q->where('status', 4);
                },
                'assignedTasks as ongoing' => function($q) {
                    return $this->projectId
                        ? $q->where('status', 2)->where('project_id', $this->projectId)
                        : $q->where('status', 2);
                },
            ])
            ->orderBy('name')
            ->paginate($this->quantity);

        $users->getCollection()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'assigned' => $user->assigned ?? 0,
                'completed' => $user->completed ?? 0,
                'ongoing' => $user->ongoing ?? 0,
            ];
        });

        return $users;
    }

    public function getTaskStatistics()
    {
        if (!$this->isReady) {
            return [
                'totalTasks' => 0,
                'completedTasks' => 0,
                'progressTasks' => 0,
                'reviewTasks' => 0,
                'overdueTasks' => 0,
                'completionRate' => 0,
                'avgCompletionTime' => 0,
                'completedTask' => 0,
                'completedIssue' => 0,
                'completedDesign' => 0,
                'progressTask' => 0,
                'progressIssue' => 0,
                'progressDesign' => 0,
                'reviewTask' => 0,
                'reviewIssue' => 0,
                'reviewDesign' => 0,
                'overdueTask' => 0,
                'overdueIssue' => 0,
                'overdueDesign' => 0,
                'highPriorityTasks' => 0,
                'tasksDueToday' => 0,
                'tasksDueThisWeek' => 0,
            ];
        }

        // Cache key for statistics (include filters to separate caches)
        $cacheKey = 'task_overview_statistics_' . md5(serialize([
            'projectId' => $this->projectId,
            'selectedTeam' => $this->selectedTeam,
            'selectedUser' => $this->selectedUser
        ]));

        return cache()->remember($cacheKey, 300, function () {
            // Base query with project filtering and user/team filtering
            $baseStatsQuery = Task::query()
                ->when($this->projectId, fn ($query) =>
                    $query->where('project_id', $this->projectId)
                )
                ->when($this->selectedUser && $this->selectedUser !== '', fn ($query) =>
                    $query->where('assigned_to', $this->selectedUser)
                )
                ->when($this->selectedTeam, function ($query) {
                    $query->whereHas('assignee', function ($q) {
                        $q->where('team_id', $this->selectedTeam);
                    });
                });

            // Apply RBAC filtering
            $project = $this->projectId ? Project::find($this->projectId) : null;
            $baseStatsQuery = RBACService::applyTaskFiltering($baseStatsQuery, $project, null, $this->context);

            // Overall task statistics
            $totalTasks = (clone $baseStatsQuery)->count();
            $completedTasks = (clone $baseStatsQuery)->where('status', 4)->count();
            $progressTasks = (clone $baseStatsQuery)->where('status', 2)->count();
            $reviewTasks = (clone $baseStatsQuery)->where('status', 3)->count();
            $overdueTasks = (clone $baseStatsQuery)->where('end_time', '<', now())->whereIn('status', [1,2,3])->count();
            
            // High priority and due date stats
            $highPriorityTasks = (clone $baseStatsQuery)->where('priority_id', 1)->whereIn('status', [1,2,3])->count();
            $tasksDueToday = (clone $baseStatsQuery)->whereDate('end_time', today())->whereIn('status', [1,2,3])->count();
            $tasksDueThisWeek = (clone $baseStatsQuery)->whereBetween('end_time', [now()->startOfWeek(), now()->endOfWeek()])->whereIn('status', [1,2,3])->count();

            // Completion rate
            $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

            // Average completion time (in days)
            $avgCompletionTime = (clone $baseStatsQuery)
                ->where('status', 4)
                ->whereNotNull('updated_at')
                ->whereNotNull('created_at')
                ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
                ->value('avg_days') ?? 0;

            // Single query for task type and status combinations
            $taskTypeCounts = (clone $baseStatsQuery)->selectRaw('
                status,
                task_type_id,
                COUNT(*) as count,
                SUM(CASE WHEN end_time < NOW() AND status IN (1,2,3) THEN 1 ELSE 0 END) as overdue_count
            ')->groupBy('status', 'task_type_id')->get();

            $taskTypeStats = $taskTypeCounts->groupBy('task_type_id');

            return [
                // Overall statistics
                'totalTasks' => $totalTasks,
                'completedTasks' => $completedTasks,
                'progressTasks' => $progressTasks,
                'reviewTasks' => $reviewTasks,
                'overdueTasks' => $overdueTasks,
                'completionRate' => $completionRate,
                'avgCompletionTime' => round($avgCompletionTime, 1),
                'highPriorityTasks' => $highPriorityTasks,
                'tasksDueToday' => $tasksDueToday,
                'tasksDueThisWeek' => $tasksDueThisWeek,

                // Completed by task type
                'completedTask' => $taskTypeStats->get(1, collect())->where('status', 4)->sum('count'),
                'completedIssue' => $taskTypeStats->get(2, collect())->where('status', 4)->sum('count'),
                'completedDesign' => $taskTypeStats->get(3, collect())->where('status', 4)->sum('count'),

                // In-progress by task type
                'progressTask' => $taskTypeStats->get(1, collect())->where('status', 2)->sum('count'),
                'progressIssue' => $taskTypeStats->get(2, collect())->where('status', 2)->sum('count'),
                'progressDesign' => $taskTypeStats->get(3, collect())->where('status', 2)->sum('count'),

                // Review
                'reviewTask' => $taskTypeStats->get(1, collect())->where('status', 3)->sum('count'),
                'reviewIssue' => $taskTypeStats->get(2, collect())->where('status', 3)->sum('count'),
                'reviewDesign' => $taskTypeStats->get(3, collect())->where('status', 3)->sum('count'),

                // Overdue
                'overdueTask' => $taskTypeStats->get(1, collect())->sum('overdue_count'),
                'overdueIssue' => $taskTypeStats->get(2, collect())->sum('overdue_count'),
                'overdueDesign' => $taskTypeStats->get(3, collect())->sum('overdue_count'),
            ];
        });
    }

    public function getRecentActivities()
    {
        if (!$this->isReady) {
            return collect();
        }

        $baseQuery = Task::with(['assignee:id,name', 'project:id,title'])
            ->when($this->projectId, fn ($query) =>
                $query->where('project_id', $this->projectId)
            )
            ->when($this->selectedUser && $this->selectedUser !== '', fn ($query) =>
                $query->where('assigned_to', $this->selectedUser)
            )
            ->when($this->selectedTeam, function ($query) {
                $query->whereHas('assignee', function ($q) {
                    $q->where('team_id', $this->selectedTeam);
                });
            });

        // Apply RBAC filtering
        $project = $this->projectId ? Project::find($this->projectId) : null;
        $baseQuery = RBACService::applyTaskFiltering($baseQuery, $project, null, $this->context);

        return $baseQuery
            ->where('updated_at', '>=', now()->subDays(7))
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'assignee' => $task->assignee?->name ?? 'Unassigned',
                    'project' => $task->project?->title ?? 'No Project',
                    'updated_at' => $task->updated_at,
                    'type' => $task->task_type_id,
                ];
            });
    }

    public function getUpcomingDeadlines()
    {
        if (!$this->isReady) {
            return collect();
        }

        $baseQuery = Task::with(['assignee:id,name', 'project:id,title'])
            ->when($this->projectId, fn ($query) =>
                $query->where('project_id', $this->projectId)
            )
            ->when($this->selectedUser && $this->selectedUser !== '', fn ($query) =>
                $query->where('assigned_to', $this->selectedUser)
            )
            ->when($this->selectedTeam, function ($query) {
                $query->whereHas('assignee', function ($q) {
                    $q->where('team_id', $this->selectedTeam);
                });
            });

        // Apply RBAC filtering
        $project = $this->projectId ? Project::find($this->projectId) : null;
        $baseQuery = RBACService::applyTaskFiltering($baseQuery, $project, null, $this->context);

        return $baseQuery
            ->whereIn('status', [1, 2, 3])
            ->where('end_time', '>=', now())
            ->where('end_time', '<=', now()->addDays(7))
            ->orderBy('end_time', 'asc')
            ->limit(8)
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'assignee' => $task->assignee?->name ?? 'Unassigned',
                    'project' => $task->project?->title ?? 'No Project',
                    'end_time' => $task->end_time,
                    'type' => $task->task_type_id,
                    'priority' => $task->priority_id,
                    'days_left' => (int) ceil(now()->diffInDays($task->end_time, false)),
                ];
            });
    }

    public function updatedSelectedTeam($value)
    {
        $this->resetPage();
    }

    public function updatedSelectedUser($value)
    {
        $this->resetPage();
    }

    #[On('refresh-other-components')]
    public function refreshData()
    {
        $this->js('$wire.$refresh()');
    }

    public function render()
    {
        $statistics = $this->getTaskStatistics();
        $recentActivities = $this->getRecentActivities();
        $upcomingDeadlines = $this->getUpcomingDeadlines();

        return view('livewire.project.task-overview', array_merge([
            'memberHeaders' => $this->memberHeaders(),
            'teamPerformance' => $this->teamPerformance(),
            'teams' => $this->teams,
            'users' => $this->users,
            'recentActivities' => $recentActivities,
            'upcomingDeadlines' => $upcomingDeadlines,
        ], $statistics));
    }
}
