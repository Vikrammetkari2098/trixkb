<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DecisionTreeController extends Controller
{
    public function index()
    {
        return view('decision-tree.index');
    }
}
