<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class RoleDelete extends Component
{
    use Interactions;

    public $roleId;

    // Listen to the delete event
    #[On('delete-role')]
    public function openDeleteDialog($roleId)
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this role?')
            ->confirm('Confirm', 'confirmed', $roleId)
            ->send();
    }

    public function confirmed($roleId): void
    {
        $role = Role::findOrFail($roleId);
        $role->delete();

        $this->toast()->success('Success', 'Role deleted successfully')->send();

        // Refresh the roles list
        $this->refreshData();
    }

    public function refreshData()
    {
        // Dispatch to RoleList component to reload data
        $this->dispatch('loadData-roles');
    }

    public function render()
    {
        return view('livewire.roles.role-delete');
    }
}
