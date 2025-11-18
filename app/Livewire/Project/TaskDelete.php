<?php
namespace App\Livewire\Project;

use App\Models\Task;
use App\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class TaskDelete extends Component
{
    use Interactions;

    public $taskId;
    public ?int $projectId = null;

    #[On('delete-task')]
    public function openDeleteDialog($taskId)
    {
        $this->taskId = $taskId;

        $this->dialog()
            ->question('Warning!', 'Are you sure?')
            ->confirm('Confirm', 'confirmed', $taskId)
            ->send();
    }

    public function confirmed($taskId): void
    {
        $task = Task::findOrFail($taskId);
        $taskTitle = $task->title;

        $task->delete();
        $this->taskId = null;
        // Clear task statistics cache for both general and project-specific caches
        cache()->forget('task_statistics_' . md5(serialize([])));
        if ($this->projectId) {
            cache()->forget('task_statistics_' . md5(serialize(['projectId' => $this->projectId])));
        }

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_task',
            'description' => 'Deleted task: ' . $taskTitle,
            'ip_address' => request()->ip(),
        ]);

        $this->toast()->success('Deleted', "Task '{$taskTitle}' deleted successfully")->send();

        $this->dispatch('task-updated'); // Notify TaskBoard about task deletion
        $this->dispatch('refresh-other-components'); // Notify other components (Overview, List)
        $this->dispatch('loadData-tasks');
    }

    public function render()
    {
        return view('livewire.project.task-delete');
    }
}

