<?php

namespace App\Livewire\Organisation\SubCaseCategory1;

use Livewire\Component;
use App\Models\SubCaseCategory1;
use Illuminate\Support\Str;
use TallStackUi\Traits\Interactions;

class SubCaseCategory1Create extends Component
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

        SubCaseCategory1::createWithSlug([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->toast()->success('Success', 'Sub Case Category 1 created successfully')->send();
        $this->reset(['name', 'status']);
        $this->dispatch('refresh-sub-case-category1-list');
        $this->dispatch('close-modal-create-sub-case-category1');
    }

    public function render()
    {
        return view('livewire.organisation.sub-case-category1.sub-case-category1-create');
    }
}
