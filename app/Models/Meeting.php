<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'agenda',
        'notes',
        'start_time',
        'end_time',
        'timezone',
        'location',
        'meeting_link',
        'meeting_password',
        'platform_id',
        'type',
        'status',
        'meeting_type_id',
        'status_id',
        'project_id',
        'created_by',
        'max_participants',
        'is_recurring',
        'recurring_pattern',
        'requires_approval',
        'reminder_sent_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_recurring' => 'boolean',
        'requires_approval' => 'boolean',
        'recurring_pattern' => 'array',
        'reminder_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Meeting validation rules and messages following the same pattern as Project
    const MEETING_CREATE_RULES = [
        'title' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'max:2000'],
        'agenda' => ['nullable', 'string', 'max:2000'],
        'start_time' => ['required', 'date', 'after:now'],
        'end_time' => ['required', 'date', 'after:start_time'],
        'location' => ['nullable', 'string', 'max:500'],
        'meeting_link' => ['nullable', 'url', 'max:500'],
        'platform_id' => ['nullable', 'integer', 'exists:platforms,id'],
        'meeting_type_id' => ['required', 'integer', 'exists:meeting_types,id'],
        'status_id' => ['required', 'integer', 'exists:meeting_statuses,id'],
        'project_id' => ['nullable', 'integer', 'exists:projects,id'],
        'user_ids' => ['nullable', 'array'],
        'user_ids.*' => ['integer', 'exists:users,id'],
    ];

    const MEETING_CREATE_MESSAGES = [
        'title.required' => 'Meeting title is required',
        'title.min' => 'Meeting title must be at least 3 characters',
        'title.max' => 'Meeting title cannot exceed 255 characters',
        'description.max' => 'Description cannot exceed 2000 characters',
        'agenda.max' => 'Agenda cannot exceed 2000 characters',
        'start_time.required' => 'Start time is required',
        'start_time.after' => 'Start time must be in the future',
        'start_time.date' => 'Please provide a valid start date and time',
        'end_time.required' => 'End time is required',
        'end_time.after' => 'End time must be after start time',
        'end_time.date' => 'Please provide a valid end date and time',
        'location.max' => 'Location cannot exceed 500 characters',
        'meeting_link.url' => 'Please provide a valid meeting link (must start with http:// or https://)',
        'meeting_link.max' => 'Meeting link cannot exceed 500 characters',
        'meeting_type_id.required' => 'Please select a meeting type',
        'meeting_type_id.exists' => 'The selected meeting type is invalid',
        'status_id.required' => 'Please select a meeting status',
        'status_id.exists' => 'The selected meeting status is invalid',
        'platform_id.exists' => 'The selected platform is invalid',
        'project_id.exists' => 'The selected project is invalid',
        'user_ids.array' => 'Participants must be provided as a list',
        'user_ids.*.exists' => 'One or more selected participants are invalid',
    ];

    const MEETING_UPDATE_RULES = [
        'title' => ['required', 'string', 'min:3', 'max:255'],
        'description' => ['nullable', 'string', 'max:2000'],
        'agenda' => ['nullable', 'string', 'max:2000'],
        'start_time' => ['required', 'date'],
        'end_time' => ['required', 'date', 'after:start_time'],
        'location' => ['nullable', 'string', 'max:500'],
        'meeting_link' => ['nullable', 'url', 'max:500'],
        'platform_id' => ['nullable', 'integer', 'exists:platforms,id'],
        'meeting_type_id' => ['required', 'integer', 'exists:meeting_types,id'],
        'status_id' => ['required', 'integer', 'exists:meeting_statuses,id'],
        'project_id' => ['nullable', 'integer', 'exists:projects,id'],
        'user_ids' => ['nullable', 'array'],
        'user_ids.*' => ['integer', 'exists:users,id'],
    ];

    const MEETING_UPDATE_MESSAGES = [
        'title.required' => 'Meeting title is required',
        'title.min' => 'Meeting title must be at least 3 characters',
        'title.max' => 'Meeting title cannot exceed 255 characters',
        'description.max' => 'Description cannot exceed 2000 characters',
        'agenda.max' => 'Agenda cannot exceed 2000 characters',
        'start_time.required' => 'Start time is required',
        'start_time.date' => 'Please provide a valid start date and time',
        'end_time.required' => 'End time is required',
        'end_time.after' => 'End time must be after start time',
        'end_time.date' => 'Please provide a valid end date and time',
        'location.max' => 'Location cannot exceed 500 characters',
        'meeting_link.url' => 'Please provide a valid meeting link (must start with http:// or https://)',
        'meeting_link.max' => 'Meeting link cannot exceed 500 characters',
        'meeting_type_id.required' => 'Please select a meeting type',
        'meeting_type_id.exists' => 'The selected meeting type is invalid',
        'status_id.required' => 'Please select a meeting status',
        'status_id.exists' => 'The selected meeting status is invalid',
        'platform_id.exists' => 'The selected platform is invalid',
        'project_id.exists' => 'The selected project is invalid',
        'user_ids.array' => 'Participants must be provided as a list',
        'user_ids.*.exists' => 'One or more selected participants are invalid',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'meeting_user', 'meeting_id', 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function meetingType()
    {
        return $this->belongsTo(MeetingType::class, 'meeting_type_id');
    }

    public function meetingStatus()
    {
        return $this->belongsTo(MeetingStatus::class, 'status_id');
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    // Accessor for backward compatibility
    public function getStatusAttribute()
    {
        return $this->meetingStatus?->name ?? 'pending';
    }

    // Accessor for participants count
    public function getParticipantsCountAttribute()
    {
        return $this->users()->count();
    }
}
