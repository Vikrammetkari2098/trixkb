<?php
namespace App\Livewire\Organisation;

use Livewire\Component;
use App\Models\Ministry;
use TallStackUi\Traits\Interactions;

class MinistryEdit extends Component
{
    use Interactions;

    public $ministryId;
    public $name;
    public $short_name;
    public $status;

    protected $listeners = ['loadData-edit-ministry' => 'loadMinistry'];

    public function loadMinistry($id)
    {
        $this->ministryId = $id;

        $ministry = Ministry::findOrFail($id);

        $this->name = $ministry->name;
        $this->short_name = $ministry->short_name;
        $this->status = $ministry->status;

        $this->dispatch('open-modal-edit-ministry'); // Opens modal
    }

    public function update()
    {
        $ministry = Ministry::findOrFail($this->ministryId);

        $ministry->update([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'status' => $this->status,
        ]);

        $this->toast()->success('Success', 'Ministry updated successfully')->send();

        $this->dispatch('close-modal-edit-ministry'); // Close modal
        $this->dispatch('refresh-ministries-list'); // Refresh table
    }

    public function render()
    {
        return view('livewire.organisation.ministry-edit');
    }
}
