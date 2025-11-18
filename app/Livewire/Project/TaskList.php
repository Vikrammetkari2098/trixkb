<?php

namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;
use TallStackUi\Traits\Interactions;
use App\Models\Project;
use App\Models\Team;
use App\Services\RBACService;

class TaskList extends Component
{
    use WithPagination, Interactions;

    public bool $isReady = false;
    public ?string $search = null;
    public ?int $quantity = 5;
    public array $selected = [];
    public ?int $projectId = null;
    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];
    public string $status = 'all';
    public ?string $selectedProject = '';
    public ?int $selectedTeam = null;
    public ?string $selectedUser = '';
    public array $projects = [];
    public array $teams = [];
    public array $users = [];
    public string $context = 'global';

    #[On('loadData-task-list')]
    public function loadData()
    {
        $this->isReady = true;
    }

    public function mount($projectId = null, $context = 'global')
    {
        $this->projectId = $projectId;
        $this->context = $context;
        $this->projects = Project::all()->toArray();
        $this->teams = Team::all()->toArray();
        $this->users = User::all()->toArray();
    }

    public function sortBy($column)
    {
        if ($this->sort['column'] === $column) {
            $this->sort['direction'] = $this->sort['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort['column'] = $column;
            $this->sort['direction'] = 'asc';
        }
    }

    public function headers(): array
    {
        return [
            ['index' => 'id', 'label' => '#', 'sortable' => true],
            ['index' => 'title', 'label' => 'Task', 'sortable' => true],
            ['index' => 'priority_name', 'label' => 'Priority', 'sortable' => true],
            ['index' => 'task_type_label', 'label' => 'Task Type', 'sortable' => false],
            ['index' => 'project_name', 'label' => 'Project', 'sortable' => false],
            ['index' => 'assigned_to_name', 'label' => 'Assigned To', 'sortable' => false],
            ['index' => 'status_label', 'label' => 'Status', 'sortable' => false],
            ['index' => 'start_time', 'label' => 'Start Time', 'sortable' => true],
            ['index' => 'action', 'label' => 'Actions', 'sortable' => false],
        ];
    }

    public function getTasksByStatus()
    {
        if (!$this->isReady) {
            $empty = fn () => new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->quantity);
            return [
                'tasks' => $empty(),
            ];
        }

        $baseQuery = fn () => Task::with([
            'assignee:id,name',
            'project:id,title',
            'statusInfo:id,name',
            'taskType:id,name',
            'priority:id,name'
        ])
        ->withCount(['comments', 'docs'])
        ->when($this->projectId, fn ($query) =>
            $query->where('project_id', $this->projectId))
        ->when($this->selectedProject && !$this->projectId, fn ($query) =>
            $query->where('project_id', $this->selectedProject))
        ->when($this->selectedTeam, function (Builder $query) {
            $query->whereHas('assignee', function ($q) {
                $q->where('team_id', $this->selectedTeam);
            });
        })
        ->when($this->selectedUser && $this->selectedUser !== '', fn ($query) =>
            $query->where('assigned_to', $this->selectedUser))
        ->when($this->search, fn ($query) =>
            $query->where('title', 'like', "%{$this->search}%"))
        ->when($this->status !== 'all', fn ($query) =>
            $query->where('status', $this->getStatusId($this->status)))
        ->when($this->sort['column'] === 'priority_name', function ($query) {
            return $query->leftJoin('priorities', 'tasks.priority_id', '=', 'priorities.id')
                        ->orderBy('priorities.name', $this->sort['direction'])
                        ->select('tasks.*');
        }, function ($query) {
            return $query->orderBy($this->sort['column'], $this->sort['direction']);
        });

        // Apply RBAC filtering
        $applyRBAC = function ($query) {
            $project = $this->projectId ? Project::find($this->projectId) : null;
            return RBACService::applyTaskFiltering($query, $project, null, $this->context);
        };

        $formatRows = function ($paginator) {
            $paginator->getCollection()->transform(function ($task) {
                $task->project_name = optional($task->project)->title ?? '—';
                $task->assigned_to_name = optional($task->assignee)->name ?? '—';
                $task->status_label = optional($task->statusInfo)->name ?? 'Unknown';
                $task->task_type_label = ucfirst(optional($task->taskType)->name ?? '—');
                $task->priority_name = optional($task->priority)->name ?? '—';
                $task->start_dates = $task->start_time
                    ? date('F j, Y', strtotime($task->start_time))
                    : '-';
                return $task;
            });
            return $paginator;
        };

        return [
            'tasks' => $formatRows(
                $applyRBAC($baseQuery())->paginate($this->quantity, ['*'], 'tasks')
            ),
        ];
    }

    private function getStatusId($status)
    {
        return match($status) {
            'todo' => 1,
            'progress' => 2,
            'review' => 3,
            'completed' => 4,
            default => null,
        };
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

    public function updatedStatus($value)
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = $this->getTasksByStatus();

        return view('livewire.project.task-list', array_merge($data, [
            'headers' => $this->headers(),
            'sort' => $this->sort,
            'search' => $this->search,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'projects' => $this->projects,
            'teams' => $this->teams,
            'users' => $this->users,
        ]));
    }

    #[On('refresh-other-components')]
    public function refreshData()
    {
        $this->js('$wire.$refresh()');
    }
}
