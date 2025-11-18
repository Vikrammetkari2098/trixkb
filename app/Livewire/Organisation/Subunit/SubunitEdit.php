<?php

namespace App\Livewire\Organisation\Subunit;

use Livewire\Component;
use App\Models\SubUnit;
use App\Models\AuditTrail;
use TallStackUi\Traits\Interactions;

class SubunitEdit extends Component
{
    use Interactions;

    public $subunitId;
    public $name = '';
    public $status = 1;

    public $subUnitStatus = [
        ['label' => 'Active', 'value' => 1],
        ['label' => 'Inactive', 'value' => 0],
    ];

    protected $listeners = ['loadData-edit-subunit' => 'loadData'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    public function loadData($id)
    {
        $subunit = SubUnit::findOrFail($id);
        $this->subunitId = $subunit->id;
        $this->name = $subunit->name;
        $this->status = $subunit->status;

        $this->dispatch('open-modal-edit-subunit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validatedData = $this->validate();

        $subunit = SubUnit::findOrFail($this->subunitId);
        $subunit->update([
            'name' => $validatedData['name'],
            'status' => $validatedData['status'],
        ]);

        AuditTrail::create([
            'action' => 'update',
            'subject' => 'subunit',
            'subject_id' => $subunit->id,
            'ip_address' => request()->ip(),
            'user_id' => auth()->id(),
        ]);

        $this->dispatch('close-modal-edit-subunit');
        $this->dispatch('refresh-subunit-list');
        $this->toast()->success('Success', 'Sub Unit updated successfully!')->send();
    }

    public function render()
    {
        return view('livewire.organisation.subunit.subunit-edit');
    }
}
