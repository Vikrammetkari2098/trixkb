<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserArticle extends Controller
{
     public function index()
    {
        return view('userarticle-list');
    }
}
