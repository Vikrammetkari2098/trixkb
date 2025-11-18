<?php

namespace App\Livewire\Projects;

use App\Models\Module;
use App\Models\Project;
use Livewire\Component;
use App\Models\Priority;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class ProjectEdit extends Component
{
    use Interactions;

    public $title, $description, $priority, $priorities, $modules = [], $moduleAll, $projectId, $placement;
    public $start_time, $end_time;
    protected $rules = Project::PROJECT_UPDATE_RULES;
    protected $messages = Project::PROJECT_UPDATE_MESSAGES;

    public function mount()
    {
        $this->priorities = Priority::all();
        $this->moduleAll = Module::all();
    }

   #[On('loadData-edit')]
    public function loadData($projectId)
    {
        $this->projectId = $projectId;
        $this->project = Project::findOrFail($projectId);

        if (!empty($this->project)) {
            $this->title = $this->project->title;
            $this->description = $this->project->description;
            $this->priority = $this->project->priority_id;
            $this->modules = $this->project->modules()->pluck('modules.id')->toArray();
            $this->start_time = $this->project->start_time?->format('Y-m-d\TH:i');
            $this->end_time = $this->project->end_time?->format('Y-m-d\TH:i');
        }
    }

    public function refreshData()
    {
        // Dispatch directly to both child components since parent coordination isn't working
        logger('ProjectEdit dispatching to both components directly');
        $this->dispatch('loadData-overview');
        $this->dispatch('loadData-list');
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $validatedData = $this->validate();

        $project = Project::findOrFail($this->projectId);
        $project->title = $validatedData['title'];
        $project->description = $validatedData['description'];
        $project->start_time = $validatedData['start_time'];
        $project->end_time = $validatedData['end_time'];
        $project->priority_id = $validatedData['priority'];
        $project->save();

        $project->modules()->sync($validatedData['modules']);

        $this->dispatch('close-modal-update');
        $this->toast()->success('Success', 'Project updated successful')->send();
        $this->refreshData();
    }
    public function render()
    {
        return view('livewire.projects.project-edit');
    }
}
