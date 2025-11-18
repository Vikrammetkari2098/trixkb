<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    protected $request;
    protected $user;
    protected $meeting;

    public function __construct(Request $request, User $user, Meeting $meeting)
    {
        $this->request = $request;
        $this->user = $user;
        $this->meeting = $meeting;
    }

    public function show()
    {
        return view('meetings');
    }
}
