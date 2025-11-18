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

class TaskBoard extends Component
{
    use WithPagination, Interactions;

    public bool $isReady = false;
    public ?string $search = null;
    public ?int $quantity = 5;
    public ?int $projectId = null;
    public ?string $selectedProject = '';
    public ?int $selectedTeam = null;
    public ?string $selectedUser = '';
    public array $projects = [];
    public array $teams = [];
    public array $users = [];
    public string $context = 'global';

    #[On('loadData-task-board')]
    public function loadData()
    {
        $this->isReady = true;
    }

    #[On('task-updated')]
    public function refreshFromUpdate()
    {
        $this->dispatch('loadData-task-board');
    }

    #[On('refresh-components')]
    public function refreshComponents()
    {
        // Refresh this component when other components make updates
        $this->isReady = false;
        $this->dispatch('loadData-task-board');
    }

    public function mount($projectId = null, $context = 'global')
    {
        $this->projectId = $projectId;
        $this->context = $context;
        
        // Apply RBAC filtering for projects
        $this->projects = RBACService::getFilterableProjects();
        $this->teams = Team::all()->toArray();
        $this->users = User::all()->toArray();
    }

    public function getPriorityColor($priorityName)
    {
        $colors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red',
            'critical' => 'red',
            'urgent' => 'red',
            'normal' => 'blue',
        ];

        return $colors[strtolower($priorityName)] ?? 'gray';
    }

    public function getTaskTypeColor($taskTypeName)
    {
        $colors = [
            'task' => 'blue',
            'issue' => 'red',
            'design' => 'purple',
            'bug' => 'red',
            'feature' => 'green',
            'improvement' => 'yellow',
            'enhancement' => 'indigo',
            'maintenance' => 'gray',
        ];

        return $colors[strtolower($taskTypeName)] ?? 'indigo';
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::find($taskId);
        
        if (!$task) {
            $this->toast()->error('Task not found')->send();
            return false;
        }
        
        // Check if user can move this task
        if (!RBACService::canMoveTask($task)) {
            $this->toast()->error('You do not have permission to move this task')->send();
            return false;
        }
        
        $task->update(['status' => $newStatus]);

        // Clear cache to reflect updated counts
        cache()->forget('task_board_statistics_' . md5(serialize(['projectId' => $this->projectId])));

        // Dispatch to refresh other components but not this one (for smooth drag & drop)
        $this->dispatch('refresh-other-components');
        
        $this->toast()->success('Task updated successfully!')->send();
        return true;
    }

    public function getTasksByStatus()
    {
        if (!$this->isReady) {
            $empty = fn () => collect();
            return [
                'todoTasks' => $empty(),
                'progressTasks' => $empty(),
                'reviewTasks' => $empty(),
                'completedTasks' => $empty(),
                'todoCount' => 0,
                'progressCount' => 0,
                'reviewCount' => 0,
                'doneCount' => 0,
            ];
        }

        $baseQuery = function() {
            $query = Task::with([
                'assignee:id,name',
                'project:id,title',
                'statusInfo:id,name',
                'taskType:id,name',
                'priority:id,name'
            ])
            ->withCount(['comments', 'docs'])
            ->when($this->projectId, fn ($q) =>
                $q->where('project_id', $this->projectId))
            ->when($this->selectedProject && !$this->projectId, fn ($q) =>
                $q->where('project_id', $this->selectedProject))
            ->when($this->selectedTeam, function ($q) {
                $q->whereHas('assignee', function ($subQ) {
                    $subQ->where('team_id', $this->selectedTeam);
                });
            })
            ->when($this->selectedUser && $this->selectedUser !== '', fn ($q) =>
                $q->where('assigned_to', $this->selectedUser))
            ->when($this->search, fn ($q) =>
                $q->where('title', 'like', "%{$this->search}%"));

            // Apply RBAC filtering
            $project = $this->projectId ? Project::find($this->projectId) : null;
            return RBACService::applyTaskFiltering($query, $project, null, $this->context);
        };

        $formatTasks = function ($tasks) {
            return $tasks->map(function ($task) {
                $task->project_name = optional($task->project)->title ?? '—';
                $task->assigned_to_name = optional($task->assignee)->name ?? '—';
                $task->status_label = optional($task->statusInfo)->name ?? 'Unknown';
                $task->task_type_label = ucfirst(optional($task->taskType)->name ?? '—');
                $task->priority_name = optional($task->priority)->name ?? '—';
                
                // Add RBAC permissions to each task
                $task->can_edit = RBACService::canEditTask($task);
                $task->can_delete = RBACService::canDeleteTask($task);
                $task->can_move = RBACService::canMoveTask($task);
                
                return $task;
            });
        };

        // Get counts for status badges with RBAC filtering
        $statusCountsQuery = Task::query()
            ->when($this->projectId, fn ($query) => $query->where('project_id', $this->projectId))
            ->when($this->selectedProject && !$this->projectId, fn ($query) => $query->where('project_id', $this->selectedProject));
            
        $project = $this->projectId ? Project::find($this->projectId) : null;
        $statusCountsQuery = RBACService::applyTaskFiltering($statusCountsQuery, $project, null, $this->context);
        $statusCounts = $statusCountsQuery->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return [
            'todoTasks' => $formatTasks($baseQuery()->where('status', 1)->get()),
            'progressTasks' => $formatTasks($baseQuery()->where('status', 2)->get()),
            'reviewTasks' => $formatTasks($baseQuery()->where('status', 3)->get()),
            'completedTasks' => $formatTasks($baseQuery()->where('status', 4)->get()),
            'todoCount' => $statusCounts[1] ?? 0,
            'progressCount' => $statusCounts[2] ?? 0,
            'reviewCount' => $statusCounts[3] ?? 0,
            'doneCount' => $statusCounts[4] ?? 0,
        ];
    }

    public function updatedSelectedProject($value)
    {
        $this->resetPage();
    }

    public function updatedSelectedTeam($value)
    {
        $this->resetPage();
    }

    public function updatedSelectedUser($value)
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = $this->getTasksByStatus();

        return view('livewire.project.task-board', array_merge($data, [
            'projects' => $this->projects,
            'teams' => $this->teams,
            'users' => $this->users,
        ]));
    }
}
