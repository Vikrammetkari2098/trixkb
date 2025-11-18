<?php

namespace App\Livewire\Directories;

use Livewire\Component;
use App\Models\Wiki;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;
use App\Models\Space;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;

class DirectoryCreate extends Component
{
    use Interactions;

    public Team $team;

    // Form fields
    public string $name = '';
    public array $space_ids = [];
    public ?int $ministry_id = null;
    public ?int $department_id = null;
    public ?int $segment_id = null;
    public ?int $unit_id = null;
    public ?int $sub_unit_id = null;
    public ?string $dial_code = null;
    public ?string $extension_number = null;
    public string $office_number = '';
    public ?string $office_number_2 = null;
    public ?string $office_number_3 = null;
    public ?string $office_number_4 = null;
    public ?string $mobile_number = null;
    public ?string $fax = null;
    public ?string $designation = null;
    public ?string $grade = null;
    public ?string $work_scope = null;
    public ?string $email = null;
    public ?string $address = null;
    public ?string $remark = null;

    // Dropdown data
    public $spaces;
    public $ministries;
    public $departments = [];
    public $segments = [];
    public $units = [];
    public $subUnits = [];

    // Validation rules & messages
    protected $rules = [
        'name' => 'required|string|max:255',
        'office_number' => 'required|string|max:50',
        'space_ids' => 'required|array|min:1',
        'ministry_id' => 'required|integer|exists:ministry,ministry_id',
        'department_id' => 'nullable|integer|exists:department,department_id',
        'segment_id' => 'nullable|integer|exists:segment,segment_id',
        'unit_id' => 'nullable|integer|exists:unit,unit_id',
        'sub_unit_id' => 'nullable|integer|exists:sub_unit,sub_unit_id',
        'email' => 'nullable|email|max:255',
    ];


    protected $messages = [
        'name.required' => 'The directory name is required.',
        'office_number.required' => 'The office number is required.',
        'space_ids.required' => 'Please select at least one space.',
        'ministry_id.required' => 'The ministry field is required.',
        'email.email' => 'Please provide a valid email address.',
    ];

       public function mount($team)
    {
        $this->team = $team;
        $this->spaces = Space::where('team_id', $team->id)->get();
        $this->ministries = Ministry::all();
        $this->departments = Department::all();
        $this->segments =Segment::all();
        $this->units = Unit::all();
        $this->subUnits = SubUnit::all();
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

   public function register()
    {
        $validated = $this->validate();


        $wiki = Wiki::create([

            'wiki_type'       => 'directory',
            'name'            => $validated['name'],
            'space_ids'        => json_encode($validated['space_ids']),
            'ministry_id'     => $validated['ministry_id'],
            'department_id'    => $validated['department_id'] ?? null,
            'segment_id'       => $validated['segment_id'] ?? null,
            'unit_id'          => $validated['unit_id'] ?? null,
            'sub_unit_id'      => $validated['sub_unit_id'] ?? null,
            'dial_code'       => $this->dial_code,
            'extension_number'=> $this->extension_number,
            'office_number'   => $validated['office_number'],
            'office_number_2' => $this->office_number_2,
            'office_number_3' => $this->office_number_3,
            'office_number_4' => $this->office_number_4,
            'mobile_number'   => $this->mobile_number,
            'fax'             => $this->fax,
            'designation'     => $this->designation,
            'grade'           => $this->grade,
            'work_scope'      => $this->work_scope,
            'email'           => $this->email,
            'address'         => $this->address,
            'remark'          => $this->remark,
            'created_by'      => Auth::id(),
        ]);

        $this->dispatch('close-modal-create');
        $this->toast()->success('Success', 'Directory created successfully')->send();

        return redirect()->route('dashboard', [$this->team->slug]);
    }

    public function render()
    {
        return view('livewire.directories.directory-create');
    }
}
