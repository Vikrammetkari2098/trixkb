<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Chatbot;
use App\Models\Organisation;
use App\Models\Space;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class CreateChatbot extends Component
{
    use Interactions;

    public object $team;
    public object $user;

    public Collection $ministries;
    public Collection $departments;
    public Collection $organisations;
    public Collection $spaces;
    public array $regions;
    public array $languages;

    public string $main_category = '';
    public string $service = '';
    public ?string $sub_service = null;
    public ?string $description = null;
    public ?string $region = null;
    public ?int $organisation_id = null;
    public ?int $department_id = null;
    public ?int $ministry_id = null;
    public ?int $space_id = null;
    public ?int $language_id = null;

    protected $rules = [
        'ministry_id' => 'required|exists:organisations,id',
        'department_id' => 'nullable|exists:organisations,id',
        'organisation_id' => 'required|exists:organisations,id',
        'space_id' => 'nullable|exists:spaces,id',
        'main_category' => 'required|string|max:255',
        'region' => 'required',
        'language_id' => 'required',
        'service' => 'required|string|max:255',
        'sub_service' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ];

    public function mount($team)
    {
        $this->team = $team;
        $this->user = Auth::user();

        $this->ministries = (new Organisation())->getMinistriesForChatbot();
        $this->regions = Chatbot::REGION;
        $this->languages = Chatbot::LANGUAGE;
        $this->organisations = Organisation::where('category', 1)
                                    ->where('status', 1)
                                    ->get();
        $this->spaces = Space::where('team_id', $this->team->id)->get();
        $this->departments = collect();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedMinistryId($ministryId)
    {
        $this->departments = (new Organisation())->getDepartmentsByMinistry($ministryId);
        $this->department_id = null;

        $this->organisations = Organisation::where('ministry_id', $ministryId)
                                ->where('category', 1)
                                ->where('status', 1)
                                ->get();
        $this->organisation_id = null;
    }

    public function updatedDepartmentId($departmentId)
    {
        if ($this->ministry_id) {
            $this->organisations = Organisation::where('ministry_id', $this->ministry_id)
                                    ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
                                    ->where('category', 1)
                                    ->where('status', 1)
                                    ->get();
            $this->organisation_id = null;
        }
    }

    public function register()
    {
        $validated = $this->validate();

        Chatbot::create([
            'team_id'         => $this->team->id,
            'user_id'         => $this->user->id,
            'created_by'      => $this->user->id,
            'ministry_id'     => $this->ministry_id,
            'department_id'   => $this->department_id,
            'organisation_id' => $this->organisation_id,
            'space_id'        => $this->space_id,
            'language_id'     => $this->language_id,
            'main_category'   => $this->main_category,
            'region'          => $this->region,
            'service'         => $this->service,
            'sub_service'     => $this->sub_service,
            'description'     => $this->description,
            'slug'            => Str::slug($this->main_category . '-' . time()),
            'ref_id'          => Chatbot::generateRefId(),
        ]);

        // Dispatch modal close and refresh events
        $this->dispatch('close-modal-create-chatbot');
        $this->toast()->success('Success', 'Chatbot created successfully!')->send();
        $this->dispatch('refresh-chatbots-list');
    }

    public function render()
    {
        return view('livewire.users.create-chatbot');
    }
}
