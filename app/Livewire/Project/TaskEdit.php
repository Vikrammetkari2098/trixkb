<?php

namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;
use App\Models\TaskType;
use App\Models\Priority;
use App\Models\Comment;
use App\Models\Doc;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Services\RBACService;
use Illuminate\Support\Facades\Auth;

class TaskEdit extends Component
{
    use Interactions,WithFileUploads;

    public $taskId;
    public $title, $description, $project_id, $assigned_to, $priority_id, $status, $task_type_id;
    public $projects, $users, $statuses, $taskTypes,$priorities, $start_time, $end_time;
    public $context = 'global'; // Default context

    public $attachment;
    public $comments = [];
    public $attachments = [];
    public $commentText = '';
    public $newComment = '';
    public $editingCommentId = null;
    
    public $canEdit = false;
    public $canDelete = false;
    public $isViewOnly = false;

    protected $rules = Task::TASK_UPDATE_RULES;
    protected $messages = Task::TASK_UPDATE_MESSAGES;

    #[On('loadTask')]
    public function loadData($taskId, $context = 'global')
    {
        $this->taskId = $taskId;
        $this->context = $context; // Set context from event

        // Single query with all required relationships
        $task = Task::with(['comments.user:id,name', 'docs:id,name,path,type,task_id,project_id'])
            ->findOrFail($taskId);

        // Check permissions
        $this->canEdit = RBACService::canEditTask($task);
        $this->canDelete = RBACService::canDeleteTask($task);
        $this->isViewOnly = !$this->canEdit;

        if (!RBACService::canViewTask($task)) {
            $this->toast()->error('Error', 'You do not have permission to view this task')->send();
            $this->dispatch('close-modal-edit');
            return;
        }

        $this->title = $task->title;
        $this->project_id = $task->project_id;
        $this->assigned_to = (string)$task->assigned_to; // Ensure string for select component
        $this->priority_id = $task->priority_id;
        $this->status = $task->status;
        $this->start_time = optional($task->start_time)->format('Y-m-d\TH:i');
        $this->end_time = optional($task->end_time)->format('Y-m-d\TH:i');
        $this->description = $task->description;
        $this->task_type_id = $task->task_type_id;
        $this->comments = $task->comments->sortByDesc('created_at');
        $this->attachments = $task->docs;

        // Load users based on context and project - SIMPLIFIED DEBUG APPROACH
        $project = $task->project;
        $this->users = [];
        
        // ALWAYS include the currently assigned user first (regardless of permissions)
        if ($task->assigned_to) {
            $assignedUser = User::find($task->assigned_to);
            if ($assignedUser) {
                $this->users[] = ['id' => (string)$assignedUser->id, 'name' => $assignedUser->name];
            }
        }
        
        // If user can edit, add additional assignable users
        if ($this->canEdit) {
            $additionalUsers = RBACService::getAssignableUsers($project, null, $this->context);
            foreach ($additionalUsers as $user) {
                $userId = (string)(is_array($user) ? $user['id'] : $user->id);
                $userName = is_array($user) ? $user['name'] : $user->name;
                
                // Don't duplicate the assigned user
                if (!collect($this->users)->contains('id', $userId)) {
                    $this->users[] = ['id' => $userId, 'name' => $userName];
                }
            }
        }
        
        // Set view-only mode flags
        $this->isViewOnly = !$this->canEdit;

        $this->dispatch('open-modal-edit');
    }
    
    public function mount()
    {
        // Use RBAC to get filtered projects and users as fallback
        $this->projects = RBACService::getFilterableProjects();
        $this->users = []; // Will be loaded in loadData based on context and project
        $this->statuses = TaskStatus::select('id', 'name')->get();
        $this->taskTypes = TaskType::select('id', 'name')->where('is_active', 1)->get();
        $this->priorities = Priority::select('id', 'name')->get();
    }
    
    public function updated($propertyName)
    {
        // When project changes, update assignable users based on RBAC
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
                $this->assigned_to = RBACService::isBasic() ? auth()->id() : null;
            }
        }
    }
    
    public function update()
    {
        $task = Task::findOrFail($this->taskId);
        
        if (!RBACService::canEditTask($task)) {
            $this->toast()->error('Error', 'You do not have permission to edit this task')->send();
            return;
        }

        $data = $this->validate();
        $data['start_time'] = $this->start_time;
        $data['end_time'] = $this->end_time;
        
        // For basic users, ensure they can only assign to themselves
        if (RBACService::isBasic()) {
            $data['assigned_to'] = auth()->id();
        }
        
        $task->update($data);

        // Clear task statistics cache
        cache()->forget('task_statistics_' . md5(serialize([])));

        $this->dispatch('close-modal-edit');
        $this->dispatch('task-updated'); // Notify TaskBoard about task update
        $this->dispatch('refresh-other-components'); // Notify other components (Overview, List)
        $this->dispatch('loadData-tasks');
        $this->toast()->success('Updated', 'Task updated successfully')->send();
    }
    
    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'content' => $this->newComment,
            'user_id' => auth()->id(),
        ]);

        // Attach the comment to the task using the pivot table
        $task = Task::find($this->taskId);
        $task->comments()->attach($comment->id);

        $this->newComment = '';
        $this->loadComments();
    }

    public function loadComments()
    {
        $task = Task::with(['comments.user:id,name'])->find($this->taskId);
        $this->comments = $task ? $task->comments->sortByDesc('created_at') : collect();
    }

    public function saveAttachment()
    {
        $task = Task::findOrFail($this->taskId);
        
        if (!RBACService::canEditTask($task)) {
            $this->toast()->error('Error', 'You do not have permission to edit this task')->send();
            return;
        }

        $files = Arr::wrap($this->attachment);
        foreach ($files as $file) {
            $this->validate([
                'attachment' => 'required|file|max:5120',
            ]);

            $path = $file->store('attachments', 'public');

            Doc::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'type' => $file->getClientMimeType(),
                'restricted' => false,
                'task_id' => $this->taskId,
                'project_id' => $this->project_id,
                'uploaded_by' => auth()->id(),
            ]);
        }

        $this->attachment = null;
        $this->loadAttachments();

        $this->toast()->success('Uploaded', 'Attachment saved successfully')->send();
    }
    
    public function loadAttachments()
    {
        $this->attachments = Doc::where('task_id', $this->taskId)->latest()->get();
    }
    
   public function deleteAttachment($id)
    {
        $task = Task::findOrFail($this->taskId);
        
        if (!RBACService::canEditTask($task)) {
            $this->toast()->error('Error', 'You do not have permission to edit this task')->send();
            return;
        }

        $file = Doc::findOrFail($id);
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();
        $this->loadAttachments();
    }
    
    public function editComment($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            $this->editingCommentId = $id;
            $this->commentText = $comment->content;
        }
    }
    
    public function saveComment()
    {
        $this->validate([
            'commentText' => 'required|string|max:1000',
        ]);

        if ($this->editingCommentId) {
            Comment::where('id', $this->editingCommentId)->update([
                'content' => $this->commentText,
            ]);
        } else {
            $comment = Comment::create([
                'content' => $this->commentText,
                'user_id' => auth()->id(),
            ]);

            // Attach the comment to the task using the pivot table
            $task = Task::find($this->taskId);
            $task->comments()->attach($comment->id);
        }

        $this->commentText = '';
        $this->editingCommentId = null;
        $this->loadComments();
    }

    public function deleteComment($id)
    {
        $task = Task::find($this->taskId);
        $task->comments()->detach($id);

        // Optional: Delete the comment entirely if it's not used by other entities
        // Comment::where('id', $id)->delete();

        $this->loadComments();
    }

    public function getIsViewOnlyProperty()
    {
        return !$this->canEdit;
    }
    
    public function render()
    {
        return view('livewire.project.task-edit');
    }
}
