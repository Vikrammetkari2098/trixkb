<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class RoleCreate extends Component
{
    use Interactions;

    public $name;
    public $users = [];
    public $permissions = [];
    public $allUsers;
    public $allPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
        'users' => 'nullable|array',
        'permissions' => 'nullable|array',
    ];

    protected $messages = [
        'name.required' => 'Role Name is required',
        'name.unique' => 'This role already exists',
    ];

    public function mount()
    {
        $this->allUsers = User::all();
        $this->allPermissions = Permission::all();
    }

    public function register()
    {
        $validated = $this->validate();

        $authUser = auth()->user();
        $teamId   = optional($authUser->team)->id;

        $role = Role::create([
            'name'      => $validated['name'],
            'slug'      => Str::slug($validated['name']),
            'user_id'   => $authUser?->id,
            'team_id'   => $teamId,
            'is_public' => 0,
        ]);

        // Attach users
        if (!empty($validated['users']) && $teamId) {
            $role->members()->sync(
                collect($validated['users'])->mapWithKeys(fn($userId) => [
                    $userId => [
                        'team_id' => $teamId,
                        'user_id' => $authUser->id, // creator
                    ]
                ])->toArray()
            );
        }

        // Attach permissions
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        // Show success toast
        $this->toast()->success('Success', 'Role created successfully')->send();

        // Close modal
        $this->dispatch('close-modal-create-role');
        //  Refresh roles list
        $this->dispatch('refresh-roles-list');

        // Reset form
        $this->reset(['name', 'users', 'permissions']);
    }

    public function render()
    {
        return view('livewire.roles.role-create');
    }
}
