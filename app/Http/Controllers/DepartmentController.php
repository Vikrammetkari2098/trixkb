<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Team;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
     public function index(Team $team)
    {
        $departments = $team->departments;
        return view('organisation.departments.index', compact('team', 'departments'));
    }
}
