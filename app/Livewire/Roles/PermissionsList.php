<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Permission;
use TallStackUi\Traits\Interactions;

class PermissionsList extends Component
{
    use Interactions;

    public function permissions(): array
    {
        $permissions = Permission::orderBy('name')->get();

        return [
            'headers' => [
                ['index' => 'iteration', 'label' => '#'],
                ['index' => 'name', 'label' => 'Permission Name'],
            ],
            'rows' => $permissions->map(function ($permission, $index) {
                return [
                    'iteration' => $index + 1,
                    'name' => ucwords(str_replace('_', ' ', $permission->name)),
                ];
            })->toArray(),
        ];
    }

    public function render()
    {
        $table = $this->permissions();
        return view('livewire.roles.permissions-list', $table);
    }
}
