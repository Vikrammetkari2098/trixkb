<?php

namespace App\Livewire\Organisation\SubCaseCategory2;

use Livewire\Component;
use App\Models\SubCaseCategory2;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

class SubCaseCategory2Create extends Component
{
    use Interactions;

    public $name = '';
    public $status = 1;

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    public function save()
    {
        $this->validate();

        SubCaseCategory2::createWithSlug([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->toast()->success('Success', 'Sub Case Category 2 created successfully')->send();

        $this->reset(['name', 'status']);
        $this->dispatch('refresh-sub-case-category2-list');
        $this->dispatch('close-modal-create-sub-case-category2');
    }

    public function render()
    {
        return view('livewire.organisation.sub-case-category2.sub-case-category2-create');
    }
}
