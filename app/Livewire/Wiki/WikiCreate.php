<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Wiki;
use App\Models\Category;
use App\Models\Space;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;
use App\Models\Organisation;
use App\Models\Activity;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

class WikiCreate extends Component
{
    use WithFileUploads, Interactions;

    public $team, $user;

    public $name, $category_ids = [], $space_ids = [];
    public $organisation_id, $ministry_id, $department_id, $segment_id, $unit_id, $sub_unit_id;
    public $case_category_data, $sub_case_category_1_data, $sub_case_category_2_data;

    public $appendix_1, $appendix_2;

    public $active_date, $expiry_date, $start_date, $end_date;
    public $is_calendar = false;
    public $description;

    public $categories = [], $spaces = [], $ministries = [], $departments = [], $segments = [], $units = [], $subUnits = [], $organisations = [];

    protected $rules = [
        'name' => 'nullable|string|max:255',
        'category_ids' => 'required|array',
        'space_ids' => 'nullable|array',
        'organisation_id' => 'required|integer|exists:organisations,id',
        'ministry_id' => 'required|integer',
        'active_date' => 'required|date',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'description' => 'nullable|string',
        'appendix_1' => 'nullable|file|max:5120',
        'appendix_2' => 'nullable|file|max:5120',
    ];

    protected $listeners = ['openCreateModal' => 'open'];

    public function mount()
    {
        $this->user = auth()->user();
        $this->team = $this->user->team ?? null;

        $this->categories = Category::all();
        $this->spaces = Space::all();
        $this->ministries = Ministry::all();
        $this->departments = Department::all();
        $this->segments = Segment::all();
        $this->units = Unit::all();
        $this->subUnits = SubUnit::all();
        $this->organisations = Organisation::all();

        // Default dates
        $this->active_date = now()->format('Y-m-d');
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->addWeek()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        $wiki = Wiki::create([
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
            'wiki_type' => 'article',
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'active_date' => $this->active_date,
            'expiry_date' => $this->expiry_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_calendar' => $this->is_calendar,
            'organisation_id' => $this->organisation_id,
            'ministry_id' => $this->ministry_id,
            'department_id' => $this->department_id,
            'segment_id' => $this->segment_id,
            'unit_id' => $this->unit_id,
            'sub_unit_id' => $this->sub_unit_id,
            'case_category_data' => $this->case_category_data,
            'sub_case_category_1_data' => $this->sub_case_category_1_data,
            'sub_case_category_2_data' => $this->sub_case_category_2_data,
            'category_ids' => json_encode($this->category_ids),
            'space_ids' => json_encode($this->space_ids),
        ]);

        if ($this->appendix_1) {
            $wiki->appendix_1 = $this->appendix_1->store('wiki_files');
        }

        if ($this->appendix_2) {
            $wiki->appendix_2 = $this->appendix_2->store('wiki_files');
        }

        $wiki->save();
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'created_wiki',
            'description' => 'Created new wiki: ' . $wiki->name,
            'ip_address' => request()->ip(),
        ]);

        $this->dispatch('close-modal-create');
        $this->toast()->success('Success', 'Wiki created successfully')->send();
        $this->dispatch('refreshWikis');
    }

    public function render()
    {
        return view('livewire.wiki.wiki-create');
    }
}
