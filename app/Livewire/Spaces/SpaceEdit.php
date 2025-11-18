<?php

namespace App\Livewire\Spaces;

use App\Models\Space;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Traits\OrganisationHelpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;

class SpaceEdit extends Component
{
    use Interactions, OrganisationHelpers;

    public Collection $organisations;
    public ?int $spaceId = null;
    public string $name = '';
    public ?int $organisation_id = null;
    public ?string $outline = null;

    protected $rules = [
        'name'            => 'required|string|max:255',
        'organisation_id' => 'required|exists:organisations,id',
        'outline'         => 'nullable|string',
    ];

    protected $messages = [
        'name.required'            => 'The space name is required.',
        'organisation_id.required' => 'Please select an organisation.',
    ];

    public function mount()
    {
        $this->organisations = $this->getMinistryAndDepartmentWithoutSpace();
    }

    #[On('loadSpace-edit')]
    public function loadData(int $id)
    {
        $space = Space::findOrFail($id);

        $this->spaceId        = $space->id;
        $this->name           = $space->name;
        $this->organisation_id = $space->organisation_id;
        $this->outline        = $space->outline;

        // Open modal (your Blade listens for this)
        $this->dispatch('open-modal-edit-space');
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

   public function update()
    {
        $validated = $this->validate();

        if (!$this->spaceId) {
            $this->toast()->error('Error', 'No space selected for update!')->send();
            return;
        }

        $space = Space::find($this->spaceId);

        if (!$space) {
            $this->toast()->error('Error', 'Space not found!')->send();
            return;
        }

        $space->update([
            'name'            => $validated['name'],
            'organisation_id' => $validated['organisation_id'],
            'outline'         => $validated['outline'] ?? $validated['name'],
            'slug'            => Str::slug($validated['name']),
            'user_id'         => Auth::id(),
            'team_id'         => auth()->user()->team_id,
        ]);

        $this->dispatch('close-modal-edit-space');
        $this->dispatch('refresh-spaces-list');
        $this->toast()->success('Success', 'Space updated successfully!')->send();
    }
    public function render()
    {
        return view('livewire.spaces.space-edit');
    }
}
