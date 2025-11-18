<?php

namespace App\Livewire\Projects;

use App\Models\Module;
use App\Models\User;
use App\Models\Project;
use Livewire\Component;
use App\Models\Priority;
use TallStackUi\Traits\Interactions;

class ProjectCreate extends Component
{
    use Interactions;

    public $title, $description, $priority, $priorities, $modules, $moduleAll, $users;
    public $start_time, $end_time;
    protected $rules = Project::PROJECT_CREATE_RULES;
    protected $messages = Project::PROJECT_CREATE_MESSAGES;

    public function mount()
    {
        $this->priorities = Priority::all();
        $this->moduleAll = Module::all();
        $this->start_time = now()->addHour()->format('Y-m-d\TH:i');
        $this->end_time = now()->addHours(2)->format('Y-m-d\TH:i');
    }

    public function refreshData()
    {
        // Dispatch directly to both child components since parent coordination isn't working
        logger('ProjectCreate dispatching to both components directly');
        $this->dispatch('loadData-overview');
        $this->dispatch('loadData-list');
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        $project = Project::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'priority_id' => $validatedData['priority']
        ]);

        $project->modules()->attach($validatedData['modules']);

        $this->dispatch('close-modal-create');
        $this->toast()->success('Success', 'Project created successful')->send();
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.projects.project-create');
    }
}
