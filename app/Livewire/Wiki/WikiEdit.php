<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Wiki;
use App\Models\Category;
use App\Models\Space;
use App\Models\Organisation;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class WikiEdit extends Component
{
    use Interactions, WithFileUploads;

    public $wikiId;

    public $name = '';
    public $description = '';
    public $active_date;
    public $expiry_date;
    public $start_date;
    public $end_date;
    public $is_calendar = false;

    // Multi select
    public $category_ids = [];
    public $space_ids = [];

    // Dropdown
    public $organisation_id;
    public $ministry_id;
    public $department_id;
    public $segment_id;

    // Old files
    public $existing_appendix_1;
    public $existing_appendix_2;

    // New uploads
    public $appendix_1;
    public $appendix_2;

    // Dropdown lists
    public $categories;
    public $spaces;
    public $organisations;
    public $ministries;
    public $departments;
    public $segments;

    #[On('loadData-edit-wiki')]
    public function loadWiki($id)
    {
        $this->wikiId = $id;
        $wiki = Wiki::findOrFail($id);

        $this->name = $wiki->name;
        $this->description = $wiki->description;
        $this->active_date = $wiki->active_date;
        $this->expiry_date = $wiki->expiry_date;
        $this->start_date = $wiki->start_date;
        $this->end_date = $wiki->end_date;
        $this->is_calendar = $wiki->is_calendar;

        $this->category_ids = $wiki->categories()->pluck('category_id')->toArray();

        // ✔ Correct many-to-many pluck
        $this->space_ids = $wiki->spaces()->pluck('spaces.id')->toArray();

        $this->organisation_id = $wiki->organisation_id;
        $this->ministry_id = $wiki->ministry_id;
        $this->department_id = $wiki->department_id;
        $this->segment_id = $wiki->segment_id;

        $this->existing_appendix_1 = $wiki->appendix_1;
        $this->existing_appendix_2 = $wiki->appendix_2;

        $this->dispatch('open-modal-edit-wiki');
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->spaces = Space::all();
        $this->organisations = Organisation::all();
        $this->ministries = Ministry::all();
        $this->departments = Department::all();
        $this->segments = Segment::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_calendar' => 'boolean',
            'appendix_1' => 'nullable|file|max:5120',
            'appendix_2' => 'nullable|file|max:5120',
        ]);
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_calendar' => 'boolean',
            'organisation_id' => 'required|integer',
            'ministry_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            'segment_id' => 'nullable|integer',

            'category_ids' => 'array',
            'space_ids' => 'array',

            'appendix_1' => 'nullable|file|max:5120',
            'appendix_2' => 'nullable|file|max:5120',
        ]);

        $wiki = Wiki::findOrFail($this->wikiId);

        // Update basic fields
        $wiki->update([
            'name'          => $validated['name'],
            'slug'          => Str::slug($validated['name']) . '-' . $wiki->id, // Avoid breaking links
            'description'   => $validated['description'],
            'active_date'   => $validated['active_date'],
            'expiry_date'   => $validated['expiry_date'],
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
            'is_calendar'   => $validated['is_calendar'] ?? false,

            'organisation_id' => $validated['organisation_id'],
            'ministry_id'     => $validated['ministry_id'],
            'department_id'   => $validated['department_id'],
            'segment_id'      => $validated['segment_id'],
        ]);

        // Sync many-to-many properly
        $wiki->categories()->sync($this->category_ids);
        $wiki->spaces()->sync($this->space_ids);

        // New Files
        if ($this->appendix_1) {
            $wiki->appendix_1 = $this->appendix_1->store('wiki_files');
        }

        if ($this->appendix_2) {
            $wiki->appendix_2 = $this->appendix_2->store('wiki_files');
        }

        $wiki->save();

        $this->toast()->success('Success', 'Wiki updated successfully!')->send();

        $this->dispatch('close-modal-edit-wiki');
        $this->dispatch('refresh-article-list');
    }

    public function render()
    {
        return view('livewire.wiki.wiki-edit');
    }
}
