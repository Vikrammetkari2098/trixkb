<?php

namespace App\Livewire\Organisation\Casecategory;

use Livewire\Component;
use App\Models\CategoryMatrix;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CaseCategoryCreate extends Component
{
    use Interactions;

    public $name = '';
    public $status = 1;

    // Listen for modal open event
    protected $listeners = ['open-modal-create-case-category' => 'openModal'];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255|unique:category_matrices,name',
            'status' => 'required|boolean',
        ]);
    }

    public function create()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:category_matrices,name',
            'status' => 'required|boolean',
        ]);

        CategoryMatrix::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'status' => $validatedData['status'],
            'created_by' => Auth::id(),
        ]);

        $this->toast()->success('Success', 'Case Category created successfully')->send();
        $this->dispatch('close-modal-create-case-category');
        $this->reset(['name', 'status']);
        $this->dispatch('refresh-case-category-list');
    }

    public function render()
    {
        return view('livewire.organisation.casecategory.case-category-create');
    }
}
