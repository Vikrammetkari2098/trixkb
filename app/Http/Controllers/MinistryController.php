<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class MinistryController extends Controller
{
    public function index(Team $team)
    {
        return view('organisation.ministry.ministries-list', compact('team'));
    }
}
