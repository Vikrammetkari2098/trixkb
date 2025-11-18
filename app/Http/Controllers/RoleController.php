<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $request;
    protected $role;
    protected $user;

    public function __construct(Request $request, Role $role, User $user)
    {
        $this->request = $request;
        $this->role = $role;
        $this->user = $user;
    }

    // Show the roles page
    public function show()
    {
             $totalRoles = $this->role->count();

        return view('roles', compact('totalRoles'));
    }
}
