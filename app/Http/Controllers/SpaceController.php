<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;

class SpaceController extends Controller
{
 public function show()
{
    $spaces = Space::all(); // fetch all records
    $spacesCount = Space::count();

    return view('space.index', compact('spaces','spacesCount'));
}
public function edit($id)
{
    $space = Space::findOrFail($id);
    return view('spaces.edit', compact('space'));
}

}
