<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import User model

class MemberController extends Controller
{
    public function show()
    {
        $totalMembers = User::count();
        return view('members', compact('totalMembers'));
    }
}
