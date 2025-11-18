<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Role;

class RoleList extends Component
{
     public $team;
    public $roles;

    protected $listeners = [
        'loadData-roles' => 'loadRoles',
        'refresh-roles-list' => 'loadRoles',
    ];

    public function mount()
    {
        $this->loadRoles();
    }

    public function loadRoles()
    {
        $teamId = optional(auth()->user()->team)->id;

        $this->roles = Role::with(['members', 'permissions'])
                            ->where('team_id', $teamId)
                            ->orderBy('id', 'asc')
                            ->get();
    }

    public function render()
    {
        return view('livewire.roles.role-list');
    }
}
