<?php
namespace App\Http\Controllers;
use App\Models\Wiki;

use Illuminate\Http\Request;

class WikiController extends Controller
{
    public function show($team, $user)
    {
        $wikiCount = Wiki::where('wiki_type', 'article')->count();
        return view('wiki.show', compact('team', 'user','wikiCount'));
    }
}
