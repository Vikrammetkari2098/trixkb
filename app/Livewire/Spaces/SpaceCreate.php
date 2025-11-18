<?php

namespace App\Livewire\Spaces;

use App\Models\Space;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Traits\OrganisationHelpers;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SpaceCreate extends Component
{
    use Interactions, OrganisationHelpers;

    public Collection $organisations;
    public string $name = '';
    public ?int $organisation_id = null;
    public ?string $outline = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'organisation_id' => 'required|exists:organisations,id',
        'outline' => 'nullable|string',
    ];

    public function mount()
    {
        // Load Ministries & Departments without a Space
        $this->organisations = $this->getMinistryAndDepartmentWithoutSpace();
    }
    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

   public function register()
    {
        $validatedData = $this->validate();

        Space::create([
            'name'            => $validatedData['name'],
            'organisation_id' => $validatedData['organisation_id'],
            'slug'            => Str::slug($validatedData['name']),
            'outline'         => $validatedData['outline'] ?? $validatedData['name'], // single field now
            'user_id'         => Auth::id(),
            'team_id'         => auth()->user()->team_id,
        ]);

        $this->dispatch('close-modal-create-space');
        $this->dispatch('refresh-spaces-list');
        $this->toast()->success('Success', 'Space created successfully!')->send();
    }


    public function render()
    {
        return view('livewire.spaces.space-create');
    }
}
