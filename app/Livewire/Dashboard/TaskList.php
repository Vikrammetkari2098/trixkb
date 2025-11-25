<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskList extends Component
{
    use WithPagination;

    public $activeWorkflowTab = 'in-progress';
    public $assignedFilter = 'assigned_to_me';
    public $search = '';
    public $statusFilter = 'all';
    protected $paginationTheme = 'tailwind';

    public $statusMap = [
        'completed'        => 4,
        'in-progress'      => 2,
        'pending-review'   => 3,
    ];
    public $countThisWeek = 0;
    public $countToday = 0;
    public $countOverdue = 0;
    public $countSnoozed = 0;

    public function updatingActiveWorkflowTab()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAssignedFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function viewAllTasks()
    {
        $this->resetPage();
        $this->activeWorkflowTab = ''; // no tab filter
        $this->assignedFilter = 'assigned_to_me';
        $this->search = '';
    }

    public function render()
    {
        $query = Task::query();

        // Assigned filter
        if ($this->assignedFilter === 'assigned_to_me') {
            $query->where('assigned_to', Auth::id());
        } else {
            $query->where('created_by', Auth::id());
        }

        // Status filter
        if ($this->activeWorkflowTab && isset($this->statusMap[$this->activeWorkflowTab])) {
            $query->where('status', $this->statusMap[$this->activeWorkflowTab]);
        }

        // Search filter
        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }

        $tasks = $query->orderBy('id', 'DESC')->paginate(10);

        $now = now();
        $today = $now->toDateString();
        $weekStart = $now->startOfWeek()->toDateString();

        // Update component properties (reactive)
        $this->countToday = Task::whereDate('created_at', $today)->count();
        $this->countThisWeek = Task::whereBetween('created_at', [$weekStart, $today])->count();
        $this->countOverdue = Task::where('end_time', '<', $now)
            ->where('status', '!=', $this->statusMap['completed'])
            ->count();
        $this->countSnoozed = Task::where('start_time', '>', $now)->count();

        return view('livewire.dashboard.task-list', [
            'tasks' => $tasks,
        ]);
    }
}
