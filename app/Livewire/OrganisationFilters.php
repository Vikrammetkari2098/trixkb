<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;

class OrganisationFilters extends Component
{
    public $statusFilter = '';
    public $categoryFilter = '';
    public $ministryFilter = '';
    public $departmentFilter = '';
    public $segmentFilter = '';
    public $unitFilter = '';
    public $subUnitFilter = '';
    public $searchTerm = '';
    public $childDataIncluded = false;

    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $sub_units_list = [];

    public function mount()
    {
        $this->ministries_list = Ministry::orderBy('name')->get()
            ->map(fn($m) => ['value' => $m->ministry_id, 'text' => $m->name])->toArray();

        $this->departments_list = Department::orderBy('name')->get()
            ->map(fn($d) => ['value' => $d->department_id, 'text' => $d->name])->toArray();

        $this->segments_list = Segment::orderBy('name')->get()
            ->map(fn($s) => ['value' => $s->segment_id, 'text' => $s->name])->toArray();

        $this->units_list = Unit::orderBy('name')->get()
            ->map(fn($u) => ['value' => $u->unit_id, 'text' => $u->name])->toArray();

        $this->sub_units_list = SubUnit::orderBy('name')->get()
            ->map(fn($su) => ['value' => $su->sub_unit_id, 'text' => $su->name])->toArray();
    }


    public function applySearch()
    {
        $this->dispatch('filtersApplied', [
            'ministry' => $this->ministryFilter,
            'department' => $this->departmentFilter,
            'segment' => $this->segmentFilter,
            'unit' => $this->unitFilter,
            'subUnit' => $this->subUnitFilter,
            'search' => $this->searchTerm,
            'childData' => $this->childDataIncluded,
        ]);
    }
    public function updated($propertyName)
    {
        $this->dispatch('filters-updated', ['filters' => $this->getFilters()]);
    }
    public function resetFilters()
    {
        $this->reset([
            'ministryFilter',
            'departmentFilter',
            'segmentFilter',
            'unitFilter',
            'subUnitFilter',
            'searchTerm',
            'childDataIncluded'
        ]);
        $this->dispatch('reset-tomselect');
    }
    public function getFilters()
    {
        return [
            'ministry' => $this->ministryFilter,
            'department' => $this->departmentFilter,
            'segment' => $this->segmentFilter,
            'unit' => $this->unitFilter,
            'subUnit' => $this->subUnitFilter,
            'search' => $this->searchTerm,
            'childData' => $this->childDataIncluded,
        ];
    }

    public function render()
    {
        return view('livewire.organisation-filters');
    }
}
