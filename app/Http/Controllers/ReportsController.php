<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;

class ReportsController extends Controller
{
    public function show(Team $team, User $user)
    {

        return view('reportings', compact('team', 'user'));
    }
}
