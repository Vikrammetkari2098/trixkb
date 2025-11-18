<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewDashboardController extends Controller
{
    public function show()
    {
        return view('newdashboard');
    }
}
