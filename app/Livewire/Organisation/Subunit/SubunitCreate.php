<?php

namespace App\Livewire\Organisation\Subunit;

use Livewire\Component;
use App\Models\SubUnit;
use App\Models\Team;
use App\Models\AuditTrail;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;

class SubunitCreate extends Component
{
    use Interactions;

    public Team $team;
    public $name = '';
    public $status = 1;

    protected $listeners = ['open-modal-create-subunit' => 'openModal'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validatedData = $this->validate();

        $subunit = SubUnit::create([
            'team_id' => $this->team->id,
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'status' => $validatedData['status'],
        ]);

        AuditTrail::create([
            'action' => 'create',
            'subject' => 'subunit',
            'subject_id' => $subunit->id,
        ]);

        $this->reset(['name', 'status']);
        $this->dispatch('close-modal-create-subunit');
        $this->dispatch('refresh-subunit-list');
        $this->toast()->success('Success', 'Sub Unit created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.subunit.subunit-create');
    }
}
