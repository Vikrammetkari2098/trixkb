<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'priority_id',
        'status',
        'created_by',
        'task_type_id',
        'start_time',
        'end_time',
        ];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'integer',
    ];
    public const TASK_CREATE_RULES = [
        'title' => 'required|string|max:255|min:3',
        'description' => 'required|string|min:10|max:2000',
        'project_id' => 'required|integer|exists:projects,id',
        'assigned_to' => 'required|integer|exists:users,id',
        'status' => 'required|integer|exists:task_statuses,id',
        'task_type_id' => 'required|integer|exists:task_types,id',
        'priority_id' => 'required|integer|exists:priorities,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
    ];

    public const TASK_UPDATE_RULES = [
        'title' => 'sometimes|required|string|max:255|min:3',
        'description' => 'sometimes|required|string|min:10|max:2000',
        'project_id' => 'sometimes|required|integer|exists:projects,id',
        'assigned_to' => 'sometimes|required|integer|exists:users,id',
        'status' => 'sometimes|required|integer|exists:task_statuses,id',
        'task_type_id' => 'sometimes|required|integer|exists:task_types,id',
        'priority_id' => 'sometimes|required|integer|exists:priorities,id',
        'start_time' => 'sometimes|required|date',
        'end_time' => 'sometimes|required|date|after_or_equal:start_time',

    ];

    public const TASK_CREATE_MESSAGES = [
        'title.required' => 'Task title is required.',
        'title.min' => 'Task title must be at least 3 characters.',
        'title.max' => 'Task title cannot exceed 255 characters.',
        'description.required' => 'Task description is required.',
        'description.min' => 'Task description must be at least 10 characters.',
        'description.max' => 'Task description cannot exceed 2000 characters.',
        'project_id.required' => 'Project selection is required.',
        'project_id.exists' => 'The selected project is invalid or does not exist.',
        'assigned_to.required' => 'Task assignee is required.',
        'assigned_to.exists' => 'The selected user is invalid or does not exist.',
        'status.required' => 'Task status is required.',
        'status.exists' => 'The selected status is invalid.',
        'task_type_id.required' => 'Task type is required.',
        'task_type_id.exists' => 'The selected task type is invalid.',
        'priority_id.required' => 'Priority is required.',
        'priority_id.exists' => 'The selected priority is invalid.',
        'start_time.required' => 'Start time is required.',
        'start_time.date' => 'Start time must be a valid date.',
        'end_time.required' => 'End time is required.',
        'end_time.date' => 'End time must be a valid date.',
        'end_time.after_or_equal' => 'End time must be after or equal to start time.',

    ];

    public const TASK_UPDATE_MESSAGES = [
        'title.min' => 'Task title must be at least 3 characters.',
        'title.max' => 'Task title cannot exceed 255 characters.',
        'description.min' => 'Task description must be at least 10 characters.',
        'description.max' => 'Task description cannot exceed 2000 characters.',
        'project_id.exists' => 'The selected project is invalid or does not exist.',
        'assigned_to.exists' => 'The selected user is invalid or does not exist.',
        'status.exists' => 'The selected status is invalid.',
        'task_type_id.exists' => 'The selected task type is invalid.',
        'priority_id.exists' => 'The selected priority is invalid.',
        'start_time.date' => 'Start time must be a valid date.',
        'end_time.date' => 'End time must be a valid date.',
        'end_time.after_or_equal' => 'End time must be after or equal to start time.',

    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function statusInfo()
    {
        return $this->belongsTo(TaskStatus::class, 'status');
    }
    public function taskType()
    {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

   public function comments()
    {
        return $this->belongsToMany(Comment::class, 'task_comment');
    }

    public function docs()
    {
        return $this->hasMany(Doc::class);
    }
}

