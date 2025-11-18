<?php

namespace App\Livewire\Organisation\CategoryMatrix;

use Livewire\Component;
use App\Models\CategoryMatrix;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\CaseCategory;
use App\Models\SubCaseCategory1;
use App\Models\SubCaseCategory2;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

class CategoryMatrixCreate extends Component
{
    use Interactions;

    public $status = 1;

    public $ministry_id;
    public $department_id;
    public $case_category_id;
    public $sub_case_category_1_id;
    public $sub_case_category_2_id;

    public $ministries = [];
    public $departments = [];
    public $caseCategories = [];
    public $subCaseCategories1 = [];
    public $subCaseCategories2 = [];

    protected $listeners = [
        'open-modal-create-category-matrix' => 'openModal'
    ];

    protected $rules = [
        'status' => 'required|boolean',
        'ministry_id' => 'required|exists:ministry,ministry_id',
        'department_id' => 'required|exists:department,department_id',
        'case_category_id' => 'nullable|exists:categories,category_id',
        'sub_case_category_1_id' => 'nullable|exists:sub_case_categories_1,id',
        'sub_case_category_2_id' => 'nullable|exists:sub_case_categories_2,id',
    ];


    public function mount()
    {
        $this->ministries = Ministry::where('status', 1)
            ->get(['ministry_id', 'name'])
            ->map(fn($m) => ['id' => $m->ministry_id, 'name' => $m->name])
            ->toArray();

        $this->departments = Department::where('status', 1)
            ->get(['department_id', 'name'])
            ->map(fn($d) => ['id' => $d->department_id, 'name' => $d->name])
            ->toArray();

        $this->caseCategories = CaseCategory::where('category_status', 1)
            ->get(['category_id', 'category_name'])
            ->map(fn($c) => ['id' => $c->category_id, 'name' => $c->category_name])
            ->toArray();


        $this->subCaseCategories1 = SubCaseCategory1::where('status', 1)
            ->get(['id', 'name'])
            ->map(fn($s1) => ['id' => $s1->id, 'name' => $s1->name])
            ->toArray();


        $this->subCaseCategories2 = SubCaseCategory2::where('status', 1)
            ->get(['id', 'name'])
            ->map(fn($s2) => ['id' => $s2->id, 'name' => $s2->name])
            ->toArray();


    }

    public function save()
    {
        $this->validate();

        $ministry = Ministry::find($this->ministry_id);
        $department = Department::find($this->department_id);
        $caseCategory = CaseCategory::find($this->case_category_id);
        $sub1 = SubCaseCategory1::find($this->sub_case_category_1_id);
        $sub2 = SubCaseCategory2::find($this->sub_case_category_2_id);

        // Auto-generate matrix name dynamically
        $parts = array_filter([
            $ministry?->name,
            $department?->name,
            $caseCategory?->name,
            $sub1?->name,
            $sub2?->name,
        ]);

        $name = implode(' - ', $parts);
        $slug = Str::slug($name);

        CategoryMatrix::create([
            'name' => $name,
            'slug' => $slug,
            'status' => $this->status,
            'ministry_id' => $this->ministry_id,
            'department_id' => $this->department_id,
            'case_category_id' => $this->case_category_id,
            'sub_category_1_id' => $this->sub_case_category_1_id,
            'sub_category_2_id' => $this->sub_case_category_2_id,
            'created_by' => auth()->id(),
        ]);

        $this->toast()->success('Success', 'Category Matrix created successfully')->send();
        $this->reset([
            'status', 'ministry_id', 'department_id', 'case_category_id',
            'sub_case_category_1_id', 'sub_case_category_2_id'
        ]);
        $this->dispatch('refresh-category-matrix-list');
        $this->dispatch('close-modal-create-category-matrix');
    }

    public function render()
    {
        return view('livewire.organisation.category-matrix.category-matrix-create');
    }
}
