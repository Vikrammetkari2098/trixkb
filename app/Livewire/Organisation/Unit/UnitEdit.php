<?php

namespace App\Livewire\Organisation\Unit;

use Livewire\Component;
use App\Models\Unit;
use App\Models\Team;
use App\Models\AuditTrail;

class UnitEdit extends Component
{
    public Team $team;
    public Unit $unit;
    public $name;
    public $status;

    protected $listeners = [
        'loadUnit' => 'loadUnit',
    ];

    public function loadUnit($data)
    {
        $this->unit = Unit::find($data['id']);
        $this->name = $this->unit->name;
        $this->status = $this->unit->status;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    public function update()
    {
        $this->validate();

        $this->unit->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        AuditTrail::create([
            'action' => 'update',
            'subject' => 'unit',
            'subject_id' => $this->unit->id,
        ]);

        session()->flash('success', 'Unit updated successfully!');

        $this->dispatch('refresh-unit-list');
        $this->dispatch('close-modal-edit-unit');
    }

    public function render()
    {
        return view('livewire.organisation.unit.unit-edit');
    }
}
