<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgePulseController extends Controller
{
     public function index()
    {
        return view('knowledge-pulse.index');
    }
}
