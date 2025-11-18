<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(Request $request, User $user, Role $role)
    {
        $this->request = $request;
        $this->user = $user;
        $this->role = $role;
    }

    public function show()
    {
        return view('projects.show');
    }

    public function index($projectId)
    {
        $project = Project::with(['priority:id,name', 'modules:id,name,color'])->findOrFail($projectId);
        
        return view('projects.index', [
            'projectId' => $projectId,
            'project' => $project
        ]);
    }
}
