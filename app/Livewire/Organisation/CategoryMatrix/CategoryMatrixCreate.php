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
    public $statusOptions = [
        ['value' => 1, 'text' => 'Active'],
        ['value' => 0, 'text' => 'Inactive'],
    ];

    protected $listeners = [
        'open-modal-create-category-matrix' => 'openModal'
    ];

    protected $rules = [
        'status' => 'required|boolean',
        'ministry_id' => 'required|exists:ministries,ministry_id',
        'department_id' => 'required|exists:departments,department_id',
        'case_category_id' => 'nullable|exists:case_categories,category_id',
        'sub_case_category_1_id' => 'nullable|exists:sub_case_categories_1,id',
        'sub_case_category_2_id' => 'nullable|exists:sub_case_categories_2,id',
    ];

    public function mount()
    {
        $this->ministries = Ministry::where('status', 1)
            ->get(['ministry_id', 'name'])
            ->map(fn($m) => ['value' => $m->ministry_id, 'text' => $m->name])
            ->toArray();

        $this->departments = Department::where('status', 1)
            ->get(['department_id', 'name'])
            ->map(fn($d) => ['value' => $d->department_id, 'text' => $d->name])
            ->toArray();

        $this->caseCategories = CaseCategory::where('category_status', 1)
            ->get(['category_id', 'category_name'])
            ->map(fn($c) => ['value' => $c->category_id, 'text' => $c->category_name])
            ->toArray();

        $this->subCaseCategories1 = SubCaseCategory1::where('status', 1)
            ->get(['id', 'name'])
            ->map(fn($s1) => ['value' => $s1->id, 'text' => $s1->name])
            ->toArray();

        $this->subCaseCategories2 = SubCaseCategory2::where('status', 1)
            ->get(['id', 'name'])
            ->map(fn($s2) => ['value' => $s2->id, 'text' => $s2->name])
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

        $parts = array_filter([
            $ministry?->name,
            $department?->name,
            $caseCategory?->category_name,
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

        $this->dispatch('reset-tomselect');
        $this->dispatch('refresh-category-matrix-list');
        $this->dispatch('close-modal-create-category-matrix');
    }

    public function render()
    {
        return view('livewire.organisation.category-matrix.category-matrix-create');
    }
}
