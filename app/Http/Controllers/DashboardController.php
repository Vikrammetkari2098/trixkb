<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('dashboard', [
            'userName' => $user->name ?? 'User',
        ]);
    }
}
