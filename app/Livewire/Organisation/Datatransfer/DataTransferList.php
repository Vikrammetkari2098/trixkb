<?php

namespace App\Livewire\Organisation\Datatransfer;

use Livewire\Component;
use App\Models\Team;
use App\Models\Ministry;
use App\Models\Department;
use App\Models\Space;
use App\Helpers\GeneralHelper;

class DataTransferList extends Component
{
    public $team;

    public $ministries_list = [];
    public $departments_list = [];
    public $segments_list = [];
    public $units_list = [];
    public $subUnits_list = [];
    public $wikiTypes = [];
    public $transferTypes = [];
    public $organisationTypes = [];

    public $ministryFilter;
    public $departmentFilter;
    public $segmentFilter;
    public $unitFilter;
    public $subUnitFilter;

    public function mount(Team $team)
    {
        $this->team = $team;

        // Load data
        $this->ministries_list = Ministry::whereHas('organisations')->get()->toArray();
        $this->departments_list = Department::whereHas('organisations')->get()->toArray();
        $this->segments_list = []; // Replace with actual segments
        $this->units_list = []; // Replace with actual units
        $this->subUnits_list = []; // Replace with actual sub-units

        $this->wikiTypes = [
            'All',
            GeneralHelper::wikiTypeDirectory(),
            GeneralHelper::wikiTypeArticle(),
        ];

        $this->transferTypes = GeneralHelper::transferType();

        $this->organisationTypes = [
            'Active' => 1,
            'Inactive' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.organisation.datatransfer.data-transfer-list');
    }
}
