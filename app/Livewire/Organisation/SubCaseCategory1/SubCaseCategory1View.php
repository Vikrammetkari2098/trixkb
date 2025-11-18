<?php

namespace App\Livewire\Organisation\SubCaseCategory1;

use Livewire\Component;
use App\Models\SubCaseCategory1;

class SubCaseCategory1View extends Component
{
    public $subCaseCategory1;

    protected $listeners = ['loadData-view-sub-case-category1' => 'loadData'];

    public function loadData($id)
    {
        $this->subCaseCategory1 = SubCaseCategory1::with('user')->find($id);

        $this->dispatch('open-modal-view-sub-case-category1');
    }

    public function render()
    {
        return view('livewire.organisation.sub-case-category1.sub-case-category1-view');
    }
}
