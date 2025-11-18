<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class ProjectDelete extends Component
{
    use Interactions;

    public $projectId;

    #[On('delete-project')]
    public function openDeleteDialog($projectId)
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure?')
            ->confirm('Confirm', 'confirmed', $projectId)
            ->send();
    }

    public function confirmed($projectId): void
    {
        Project::findOrFail($projectId)->delete();
        $this->toast()->success('Success', 'Project deleted successful')->send();
        $this->refreshData();
    }

    public function refreshData()
    {
        // Dispatch directly to both child components since parent coordination isn't working
        logger('ProjectDelete dispatching to both components directly');
        $this->dispatch('loadData-overview');
        $this->dispatch('loadData-list');
    }

    public function render()
    {
        return view('livewire.projects.project-delete');
    }
}
