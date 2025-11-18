<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Space;
use App\Models\Wiki;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $request;
    protected $team;
    protected $space;
    protected $wiki;
    protected $page;

    public function __construct(Request $request, Team $team, Space $space, Wiki $wiki, Page $page)
    {
        $this->request = $request;
        $this->team = $team;
        $this->space = $space;
        $this->wiki = $wiki;
        $this->page = $page;
    }

    public function show()
    {
        return view('pages.index'); // 👉 main view file
    }
}
