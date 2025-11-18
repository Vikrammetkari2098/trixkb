<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'priority_id'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    const PROJECT_CREATE_RULES = [
        'title' => ['required', 'string'],
        'description' => ['required'],
        'start_time' => ['required', 'date'],
        'end_time' => ['required', 'date', 'after_or_equal:start_time'],
        'priority' => ['required'],
        'modules' => ['required', 'array'],
        'modules.*' => ['exists:modules,id'],
    ];

    const PROJECT_CREATE_MESSAGES = [
        'title.required' => 'Title is required',
        'description.required' => 'Description is required',
        'start_time.required' => 'Start time is required',
        'start_time.date' => 'Invalid start time format',
        'end_time.required' => 'End time is required',
        'end_time.date' => 'Invalid end time format',
        'end_time.after_or_equal' => 'End time must be after or equal to Start time',
        'priority.required' => 'Priority is required',
        'modules.required' => 'Modules are required',
        'modules.*.exists' => 'Selected module is invalid',
    ];


    const PROJECT_UPDATE_RULES = [
        'title' => ['required', 'string'],
        'description' => ['required'],
        'start_time' => ['required', 'date'],
        'end_time' => ['required', 'date', 'after_or_equal:start_time'],
        'priority' => ['required'],
        'modules' => ['required', 'array'],
        'modules.*' => ['exists:modules,id'],
    ];


    const PROJECT_UPDATE_MESSAGES = [
        'title.required' => 'Title is required',
        'description.required' => 'Description is required',
        'start_time.required' => 'Start time is required',
        'start_time.date' => 'Invalid start time format',
        'end_time.required' => 'End time is required',
        'end_time.date' => 'Invalid end time format',
        'end_time.after_or_equal' => 'End time must be after or equal to Start time',
        'priority.required' => 'Priority is required',
        'modules.required' => 'Modules are required',
        'modules.*.exists' => 'Selected module is invalid',
    ];


    public function modules()
    {
        return $this->belongsToMany(Module::class, 'project_module');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
