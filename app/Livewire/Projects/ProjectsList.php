<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ProjectsList extends Component
{
    use Interactions;
    public $projects;

    public $isReady = false;

    public $searchTerm = '';

    public $filterPriority = '';

    public $filterStatus = '';

    public function mount()
    {
        $this->projects = collect();
    }

    #[On('loadData-list')]
    public function loadData()
    {
        logger('List received event');

        // Add delay to make skeleton loading visible
        usleep(300000); // 0.3 seconds instead of 1 second

        $this->loadProjects();
        $this->isReady = true;
    }

    public function loadProjects()
    {
        $query = Project::with(['users', 'modules', 'priority', 'tasks', 'tasks.statusInfo']);

        // Apply search filter
        if (! empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$this->searchTerm.'%');
            });
        }

        // Apply priority filter
        if (! empty($this->filterPriority)) {
            $query->where('priority_id', $this->filterPriority);
        }

        // Apply status filter
        if (! empty($this->filterStatus)) {
            if ($this->filterStatus === 'active') {
                $query->where('end_time', '>', now());
            } elseif ($this->filterStatus === 'overdue') {
                $query->where('end_time', '<', now());
            }
        }

        $this->projects = $query->get();
    }

    public function performSearch()
    {
        // Add delay to make loading visible
        usleep(200000); // 200ms delay
        $this->loadProjects();
    }

    public function performFilter()
    {
        // Add delay to make loading visible
        usleep(200000); // 200ms delay
        $this->loadProjects();
    }

    public function clearFilters()
    {
        $this->searchTerm = '';
        $this->filterPriority = '';
        $this->filterStatus = '';
        $this->loadProjects();
    }

    public function search()
    {
        $this->loadProjects();
    }

    public function filter()
    {
        $this->loadProjects();
    }

    public function getProjectProgress($project)
    {
        $totalTasks = $project->tasks->count();
        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $project->tasks->where('status', 4)->count(); // Assuming 4 is completed status

        return round(($completedTasks / $totalTasks) * 100);
    }

    public function render()
    {
        return view('livewire.projects.projects-list');
    }
}
