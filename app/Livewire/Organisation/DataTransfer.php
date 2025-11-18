<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use App\Models\Team;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Segment;
use App\Models\Unit;
use App\Models\SubUnit;
use App\Models\Organisation;
use App\Models\Space;
use Exception;

class DataTransfer extends Component
{
    public Team $team;

    // Step tracking
    public $step = 1;

    // Step 1 filters
    public $fromMinistryFilter;
    public $fromDepartmentFilter;
    public $fromSegmentFilter;
    public $fromUnitFilter;
    public $fromSubUnitFilter;
    public $fromWikiType;
    public $organisationType;
    public $childDataIncluded = 1;

    // Step 2 filters
    public $toMinistryFilter;
    public $toDepartmentFilter;
    public $toSegmentFilter;
    public $toUnitFilter;
    public $toSubUnitFilter;

    // Lists
    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $subUnits_list = [];
    public $wikiTypes = [];
    public $transferTypes = [];
    public $organisationTypes = [
        'Active' => 1,
        'Inactive' => 0
    ];

    public function mount(Team $team)
    {
        $this->team = $team;

        $this->ministries_list = Ministry::whereHas('organisations')->get();
        $this->departments_list = Department::whereHas('organisations')->get();

        $this->segments_list = [];
        $this->units_list = [];
        $this->subUnits_list = [];

        $this->wikiTypes = ['All', 'Directory', 'Article']; // Replace with GeneralHelper if needed
        $this->transferTypes = ['Full', 'Partial']; // Replace with GeneralHelper if needed
    }

    // Step 1 → Step 2
    public function goToStep2()
    {
        $this->toMinistryFilter = $this->fromMinistryFilter;
        $this->toDepartmentFilter = $this->fromDepartmentFilter;
        $this->toSegmentFilter = $this->fromSegmentFilter;
        $this->toUnitFilter = $this->fromUnitFilter;
        $this->toSubUnitFilter = $this->fromSubUnitFilter;

        $this->step = 2;
    }

    // Step 2 → Process Transfer
    public function processTransfer()
    {
        try {
            // Example transfer logic: implement your own
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Data transferred successfully!'
            ]);

            $this->resetFilters();
        } catch (Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'An error occurred during data transfer.'
            ]);
        }
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->fromMinistryFilter = $this->fromDepartmentFilter = null;
        $this->fromSegmentFilter = $this->fromUnitFilter = $this->fromSubUnitFilter = null;
        $this->toMinistryFilter = $this->toDepartmentFilter = null;
        $this->toSegmentFilter = $this->toUnitFilter = $this->toSubUnitFilter = null;
        $this->organisationType = null;
        $this->childDataIncluded = 1;
        $this->fromWikiType = null;
        $this->step = 1;
    }

    public function render()
    {
        return view('livewire.organisation.data-transfer');
    }
}
