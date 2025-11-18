<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ProjectsOverview extends Component
{
    use Interactions;
    public $isReady = false;

    // Statistics
    public $totalProjects = 0;

    public $activeProjects = 0;

    public $completedProjects = 0;

    public $overdueProjects = 0;

    #[On('loadData-overview')]
    public function loadData()
    {
        logger('Overview received event');
        $this->isReady = false; // Reset to show skeleton loading for all 4 cards
        
        // Add delay to make loading visible like meetings
        sleep(1);
        
        $this->calculateStatistics();
        $this->isReady = true;
        
        // REMOVED: Don't dispatch to other components - let parent coordinate
    }

    public function calculateStatistics()
    {
        $this->totalProjects = Project::count();
        $this->activeProjects = Project::where('end_time', '>', now())->count();
        $this->overdueProjects = Project::where('end_time', '<', now())->count();
        $this->completedProjects = $this->totalProjects - $this->activeProjects - $this->overdueProjects;
    }

    public function render()
    {
        return view('livewire.projects.projects-overview');
    }
}
