<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;

class RoleEdit extends Component
{
    public $roleId;
    public $name;
    public $users = [];
    public $permissions = [];
    public $allUsers;
    public $allPermissions = [];

    // Use validation constants from the Role model
    protected $rules = Role::ROLE_UPDATE_RULES;
    protected $messages = Role::ROLE_UPDATE_MESSAGES;

    // Listen for modal open event
    protected $listeners = ['loadData-edit-role' => 'loadRole'];

    public function mount()
    {
        $this->allUsers = User::all();
        $this->allPermissions = Permission::all();
    }

    /**
     * Load role data into the form
     */
    public function loadRole($roleId)
    {
        $role = Role::with(['members', 'permissions'])->findOrFail($roleId);

        $this->roleId      = $role->id;
        $this->name        = $role->name;
        $this->users       = $role->members->pluck('id')->toArray();
        $this->permissions = $role->permissions->pluck('id')->toArray();
    }

    /**
     * Real-time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Update role details
     */
    public function update()
    {
        $validatedData = $this->validate();

        $role = Role::findOrFail($this->roleId);

        $role->update([
            'name'    => $validatedData['name'],
            'slug'    => Str::slug($validatedData['name']),
            'user_id' => auth()->id(),
            'team_id' => optional(auth()->user()->team)->id,
        ]);

        // Sync pivot tables
        $role->members()->sync($this->users ?? []);
        $role->permissions()->sync($this->permissions ?? []);

        // Close modal and refresh list
        $this->dispatch('close-modal-edit-role');
        $this->refreshData();

        // Reset properties
        $this->reset(['roleId', 'name', 'users', 'permissions']);
    }

    /**
     * Refresh role list
     */
    public function refreshData()
    {
        $this->dispatch('loadData-roles');
    }

    public function render()
    {
        return view('livewire.roles.role-edit');
    }
}
