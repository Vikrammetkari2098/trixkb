<?php

namespace App\Livewire\Projects;

use Livewire\Attributes\On;
use Livewire\Component;

class ProjectShow extends Component
{
    public $isReady = false;

    public function mount()
    {
        // Trigger initial loading
        $this->loadData();
    }

    public function loadData()
    {
        $this->isReady = true;

        // Dispatch events to child components
        $this->dispatch('loadData-overview');
        $this->dispatch('loadData-list');
    }

    #[On('loadData-projects')]
    public function reloadData()
    {
        // Handle event from project CRUD operations
        logger('ProjectShow received loadData-projects event');
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.projects.project-show');
    }
}
