<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use App\Models\Space;
use App\Models\Team;

class SegmentController extends Controller
{
    protected $request;
    protected $segment;
    protected $space;
    protected $team;

    public function __construct(Request $request, Segment $segment, Space $space, Team $team)
    {
        $this->request = $request;
        $this->segment = $segment;
        $this->space = $space;
        $this->team = $team;
    }

    public function index()
    {
        $team = Team::find(1);
        return view('organisation.segment.index', compact('team'));
    }
}
