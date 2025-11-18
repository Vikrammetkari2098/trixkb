<?php

namespace App\Livewire\Organisation\ApprovalFlow;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ApprovalLevel;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class ApprovalFlowEdit extends Component
{
    public $flowId;

    public $roleName;
    public $statusFromName;
    public $statusToName;

    public $roles = []; // editable roles
    public $allRoles = [];

    protected $listeners = [
        'loadData-edit-approval-flow' => 'loadFlow'
    ];

    public function mount()
    {
        $this->allRoles = Role::all();
    }

    public function loadFlow($flowId)
    {
        $flow = ApprovalLevel::with(['role', 'statusFrom', 'statusTo'])->findOrFail($flowId);

        $this->flowId = $flow->id;

        // SHOW ONLY
        $this->roleName        = $flow->role?->name;
        $this->statusFromName  = $flow->statusFrom?->name;
        $this->statusToName    = $flow->statusTo?->name;

        // editable roles list (if you want multi-select)
        $this->roles = [$flow->role_id];
    }

    public function update()
    {
        $flow = ApprovalLevel::findOrFail($this->flowId);

        $flow->update([
            'role_id'         => $this->roles[0] ?? $flow->role_id,
            'last_updated_by' => Auth::id(),
        ]);

        $this->dispatch('close-modal-edit-approval-flow');
        $this->dispatch('refresh-approval-flow-list');
    }

    public function render()
    {
        return view('livewire.organisation.approvalflow.approval-flow-edit');
    }
}
