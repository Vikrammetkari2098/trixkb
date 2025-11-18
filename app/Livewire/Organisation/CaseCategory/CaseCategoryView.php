<?php

namespace App\Livewire\Organisation\CaseCategory;

use Livewire\Component;
use App\Models\CategoryMatrix;

class CaseCategoryView extends Component
{
    public $caseCategory;

    protected $listeners = ['loadData-view-case-category' => 'loadData'];

    public function loadData($id)
    {
        $this->caseCategory = CategoryMatrix::with(['user'])->find($id);

        $this->dispatch('open-modal-view-case-category');
    }

    public function render()
    {
        return view('livewire.organisation.casecategory.case-category-view');
    }
}
