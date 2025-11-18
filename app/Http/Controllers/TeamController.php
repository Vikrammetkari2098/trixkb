<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(Request $request, User $user, Role $role)
    {
        $this->request = $request;
        $this->user = $user;
        $this->role = $role;
    }

    public function show()
    {
        return view('teams');
    }
}
