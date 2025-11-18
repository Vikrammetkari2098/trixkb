<?php

namespace App\Livewire\Meetings;

use App\Models\Meeting;
use App\Models\MeetingStatus;
use App\Models\MeetingType;
use App\Models\Platform;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class MeetingCreate extends Component
{
    use Interactions;

    // Form properties - clean and simple like TaskCreate
    public $title = '';
    public $description = '';
    public $agenda = '';
    public $start_time = '';
    public $end_time = '';
    public $location = '';
    public $meeting_link = '';
    public $platform_id = null;
    public $meeting_type_id = null;
    public $status_id = null;
    public $project_id = null;
    public $user_ids = [];

    // Validation rules from model - clean and consistent
    protected $rules = Meeting::MEETING_CREATE_RULES;
    protected $messages = Meeting::MEETING_CREATE_MESSAGES;

    public function mount()
    {
        // Set defaults for new meeting
        $this->status_id = 2; // Pending by default
        $this->start_time = now()->addHour()->format('Y-m-d\TH:i');
        $this->end_time = now()->addHours(2)->format('Y-m-d\TH:i');
    }

    // Real-time validation like TaskCreate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        $data = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?: null,
            'agenda' => $validatedData['agenda'] ?: null,
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'location' => $validatedData['location'] ?: null,
            'meeting_link' => $validatedData['meeting_link'] ?: null,
            'platform_id' => $validatedData['platform_id'] ?: null,
            'meeting_type_id' => $validatedData['meeting_type_id'],
            'status_id' => $validatedData['status_id'],
            'project_id' => $validatedData['project_id'] ?: null,
            'created_by' => auth()->id(),
        ];

        $meeting = Meeting::create($data);

        // Sync participants
        $userIds = is_array($validatedData['user_ids']) ? $validatedData['user_ids'] : [];
        if (!empty($userIds)) {
            $meeting->users()->sync($userIds);
        }

        // Clear cache and refresh like TaskCreate
        $this->clearMeetingCache();
        $this->dispatch('close-modal-create');
        $this->dispatch('meeting-created'); // Notify about meeting creation
        $this->dispatch('refresh-other-components'); // Notify other components
        $this->dispatch('loadData-meetings'); // Refresh meeting data
        $this->toast()->success('Success', 'Meeting created successfully')->send();
    }

    private function clearMeetingCache()
    {
        $userId = auth()->id();
        Cache::forget("meetings_this_week_{$userId}");
        Cache::forget("meetings_this_month_{$userId}");
        Cache::forget("meetings_future_{$userId}");
        Cache::forget('meeting_statuses');
        Cache::forget('meeting_types');
        Cache::forget('users_for_meetings');
        Cache::forget('projects_for_meetings');
    }

    public function getMeetingStatuses()
    {
        $statuses = Cache::remember('meeting_statuses', 3600, function () {
            return MeetingStatus::orderBy('name')->get();
        });
        
        return collect($statuses);
    }

    public function getMeetingTypes()
    {
        $types = Cache::remember('meeting_types', 3600, function () {
            return MeetingType::orderBy('name')->get();
        });
        
        return collect($types);
    }

    public function getPlatforms()
    {
        $platforms = Cache::remember('platforms', 3600, function () {
            return Platform::active()->orderBy('name')->get();
        });
        
        return collect($platforms);
    }

    public function getUsers()
    {
        $users = Cache::remember('users_for_meetings', 300, function () {
            return User::select('id', 'name', 'email')
                ->orderBy('name')
                ->get();
        });
        
        return collect($users);
    }

    public function getProjects()
    {
        $projects = Cache::remember('projects_for_meetings', 300, function () {
            return Project::select('id', 'title', 'description')
                ->orderBy('title')
                ->get();
        });
        
        return collect($projects);
    }

    public function render()
    {
        return view('livewire.meetings.meeting-create', [
            'meetingStatuses' => $this->getMeetingStatuses(),
            'meetingTypes' => $this->getMeetingTypes(),
            'platforms' => $this->getPlatforms(),
            'users' => $this->getUsers(),
            'projects' => $this->getProjects(),
        ]);
    }
}
