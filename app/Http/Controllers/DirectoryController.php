<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\Wiki;

class DirectoryController extends Controller
{
    public function show(Team $team, User $user)
    {
        $totalDirectories = Wiki::where('wiki_type', 'directory')->count();

        return view('directories.index', compact('team', 'user','totalDirectories'));
    }
}
