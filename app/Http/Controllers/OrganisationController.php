<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    public function indexContentCreator()
    {
        $totalOrganisations = Organisation::count();

        return view('organisations', compact('totalOrganisations'));
    }
}
