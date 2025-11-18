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

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    public function mount(Team $team, Unit $unit)
    {
        $this->team = $team;
        $this->unit = $unit;
        $this->name = $unit->name;
        $this->status = $unit->status;
    }

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
        return redirect()->route('unit.show', [$this->team->slug, $this->unit->slug]);
    }

    public function render()
    {
        return view('livewire.organisation.unit.unit-edit');
    }
}
