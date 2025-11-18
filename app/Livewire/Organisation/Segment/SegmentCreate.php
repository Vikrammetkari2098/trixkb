<?php

namespace App\Livewire\Organisation\Segment;

use Livewire\Component;
use App\Models\Segment;
use App\Models\Space;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use App\Models\Team;

class SegmentCreate extends Component
{
    use Interactions;

    public Team $team;

    public $name = '';
    public $space_id = null;
    public $status = 1;

    public $spaces = [];
    protected $listeners = ['open-modal-create-segment' => 'openModal'];

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->spaces = Space::where('team_id', $team->id)->get();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Segment::create([
            'team_id' => $this->team->id,
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'status' => $validatedData['status'],
        ]);

        $this->reset(['name', 'status']);
        $this->dispatch('close-modal-create-segment');
        $this->dispatch('refresh-segment-list');
        $this->toast()->success('Success', 'Division created successfully')->send();
    }

    public function render()
    {
        return view('livewire.organisation.segment.segment-create');
    }
}
