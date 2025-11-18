<?php

namespace App\Livewire\Organisation\CategoryMatrix;

use Livewire\Component;
use App\Models\CategoryMatrix;
use TallStackUi\Traits\Interactions;

class CategoryMatrixView extends Component
{
    use Interactions;

    public $matrix;

    // Listen for the event emitted from Blade
    protected $listeners = ['viewCategoryMatrix' => 'loadMatrix'];

    public function loadMatrix($id)
    {
        $this->matrix = CategoryMatrix::with([
            'ministry', 'department', 'caseCategory', 'subCategory1', 'subCategory2'
        ])->find($id);

        // Dispatch Alpine event to open the modal
        $this->dispatch('open-modal-view-category-matrix');
    }

    public function render()
    {
        return view('livewire.organisation.category-matrix.category-matrix-view');
    }
}
