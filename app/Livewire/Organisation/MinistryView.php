<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use App\Models\Ministry;

class MinistryView extends Component
{
    public ?Ministry $ministry = null;

    protected $listeners = ['loadData-view-ministry' => 'loadData'];

    public function loadData($id)
    {
        $this->ministry = Ministry::find($id);
        $this->dispatch('open-modal-view-ministry');
    }

    public function render()
    {
        return view('livewire.organisation.ministry-view');
    }
}
