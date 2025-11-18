<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TaskController extends Controller
{
    protected $request;
    protected $task;
    protected $user;
    protected $project;
    protected $status;

    public function __construct(Request $request, Task $task, User $user, Project $project, TaskStatus $status)
    {
        $this->request = $request;
        $this->task = $task;
        $this->user = $user;
        $this->project = $project;
        $this->status = $status;
    }

    public function show()
    {
        return view('tasks');
    }
}
