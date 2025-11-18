<?php

namespace App\Livewire\Organisation\Unit;

use Livewire\Component;
use App\Models\Unit;
use App\Models\Team;
use App\Models\AuditTrail;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;

class UnitCreate extends Component
{
    use Interactions;

    public Team $team;
    public $name = '';
    public $status = 1;

    protected $listeners = ['open-modal-create-unit' => 'openModal'];

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

        $unit = Unit::create([
            'team_id' => $this->team->id,
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'status' => $validatedData['status'],
        ]);

        // ✅ Use your AuditTrail helper method instead of raw create()
        $audit = new AuditTrail();
        $audit->recordAuditLog('create', 'unit', $unit->id);

        // Reset form + show toast
        $this->reset(['name', 'status']);
        $this->dispatch('close-modal-create-unit');
        $this->dispatch('refresh-unit-list');
        $this->toast()->success('Success', 'Unit created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.unit.unit-create');
    }
}
