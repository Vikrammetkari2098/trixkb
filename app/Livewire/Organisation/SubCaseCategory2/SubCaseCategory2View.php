<?php

namespace App\Livewire\Organisation\SubCaseCategory2;

use Livewire\Component;
use App\Models\SubCaseCategory2;

class SubCaseCategory2View extends Component
{
    public $subCaseCategory2Id;
    public $subCaseCategory2;

    protected $listeners = [
        'loadData-view-sub-case-category2' => 'loadData'
    ];

    public function loadData($id)
    {
        $this->subCaseCategory2Id = $id;

        $this->subCaseCategory2 = SubCaseCategory2::with('user')
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.organisation.sub-case-category2.sub-case-category2-view');
    }
}
