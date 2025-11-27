<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackManagerController extends Controller
{
    public function index()
    {
        return view('feedback.index');
    }
}
