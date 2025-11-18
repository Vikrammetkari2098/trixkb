<?php

namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Priority;
use App\Services\RBACService;
use Illuminate\Support\Facades\Auth;

class TaskCreate extends Component
{
    use Interactions;

    public $title, $description, $project_id, $assigned_to,$priority_id, $priorities, $status,$taskTypes, $task_type_id;
    public  $users, $statuses;
    public $start_time, $end_time;
    public $projects = [];
    public ?int $projectId = null;
    public string $context = 'global'; // 'global' for My Tasks, 'project' for project tasks
    
    protected $rules = Task::TASK_CREATE_RULES;
    protected $messages = Task::TASK_CREATE_MESSAGES;
    
    public function mount($projectId = null, $context = 'global')
    {
        $this->projectId = $projectId;
        $this->context = $context;
        
        // Get projects based on user role
        $this->projects = RBACService::getTaskCreationProjects();
        
        // Get assignable users based on role, project, and context
        $project = $projectId ? Project::find($projectId) : null;
        $users = RBACService::getAssignableUsers($project, null, $this->context);
        
        // ALWAYS ensure proper array format for the select component
        $this->users = [];
        foreach ($users as $user) {
            $this->users[] = [
                'id' => is_array($user) ? $user['id'] : $user->id,
                'name' => is_array($user) ? $user['name'] : $user->name
            ];
        }
        
        $this->statuses = TaskStatus::select('id', 'name')->get();
        $this->taskTypes = TaskType::select('id', 'name')->where('is_active', 1)->get();
        $this->priorities = Priority::select('id', 'name')->get();
        $this->start_time = now()->format('Y-m-d\TH:i');
        $this->end_time = now()->addHour()->format('Y-m-d\TH:i');

        // Pre-select project if projectId is provided
        if ($this->projectId) {
            $this->project_id = $this->projectId;
            $this->context = 'project'; // Override context if projectId provided
        }
        
        // Pre-select current user based on context and role
        if ($this->context === 'global') {
            // In "My Tasks" page, EVERYONE assigns to themselves
            $this->assigned_to = (string)Auth::id();
        } elseif (RBACService::isBasic(Auth::user())) {
            // Basic users always assign to themselves
            $this->assigned_to = (string)Auth::id();
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        // When project changes, update assignable users
        if ($propertyName === 'project_id') {
            $project = $this->project_id ? Project::find($this->project_id) : null;
            $users = RBACService::getAssignableUsers($project, null, $this->context);
            
            // Ensure proper array format for the select component
            $this->users = collect($users)->map(function($user) {
                return [
                    'id' => $user['id'] ?? $user->id,
                    'name' => $user['name'] ?? $user->name
                ];
            })->toArray();
            
            // Reset assigned_to if current selection is no longer valid
            if (!collect($this->users)->contains('id', $this->assigned_to)) {
                // For "My Tasks" context OR basic users, always assign to current user
                if ($this->context === 'global' || RBACService::isBasic()) {
                    $this->assigned_to = auth()->id();
                } else {
                    $this->assigned_to = null;
                }
            }
        }
    }

    public function register()
    {
        // Check if user can create tasks
        $project = $this->project_id ? Project::find($this->project_id) : null;
        if (!RBACService::canCreateTask($project)) {
            $this->toast()->error('Error', 'You do not have permission to create tasks in this project')->send();
            return;
        }
        
        $validated = $this->validate();
        $validated['created_by'] = auth()->id();
        $validated['title'] = ucfirst($validated['title']);
        $validated['start_time'] = $this->start_time;
        $validated['end_time'] = $this->end_time;

        // For My Tasks context, ensure basic users can only assign to themselves
        if ($this->context === 'global' && RBACService::isBasic()) {
            $validated['assigned_to'] = auth()->id();
        }

        Task::create($validated);

        // Clear task statistics cache for both general and project-specific caches
        cache()->forget('task_statistics_' . md5(serialize([])));
        if ($this->projectId) {
            cache()->forget('task_statistics_' . md5(serialize(['projectId' => $this->projectId])));
        }

        $this->dispatch('close-modal-create');
        $this->dispatch('task-updated'); // Notify TaskBoard about new task
        $this->dispatch('refresh-other-components'); // Notify other components (Overview, List)
        $this->toast()->success('Success', 'Task created successfully')->send();
        $this->dispatch('loadData-tasks');

        // Reset form
        $this->reset(['title', 'description', 'project_id', 'assigned_to', 'priority_id', 'status', 'task_type_id','start_time','end_time']);
        
        // Re-apply defaults after reset
        if (RBACService::isBasic()) {
            $this->assigned_to = auth()->id();
        }
        if ($this->projectId) {
            $this->project_id = $this->projectId;
        }
    }

    public function render()
    {
        return view('livewire.project.task-create');
    }
}
