<?php

namespace App\Livewire\Meetings;

use App\Models\Meeting;
use App\Models\MeetingStatus;
use App\Models\MeetingType;
use App\Models\Platform;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class CreateEditMeeting extends Component
{
    use Interactions;

    public ?Meeting $meeting = null;
    public bool $isEdit = false;

    // Form properties - clean and simple like ProjectCreate
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

    public function mount(?int $meetingId = null)
    {
        try {
            if ($meetingId) {
                $this->meeting = Meeting::with(['users', 'project', 'meetingType', 'meetingStatus'])->find($meetingId);
                if ($this->meeting) {
                    $this->isEdit = true;
                    $this->fillFromMeeting();
                    // Use update rules for editing
                    $this->rules = Meeting::MEETING_UPDATE_RULES;
                    $this->messages = Meeting::MEETING_UPDATE_MESSAGES;
                } else {
                    throw new \Exception('Meeting not found');
                }
            } else {
                // Set defaults for new meeting
                $this->status_id = 2; // Pending by default
                $this->start_time = now()->addHour()->format('Y-m-d\TH:i');
                $this->end_time = now()->addHours(2)->format('Y-m-d\TH:i');
            }
        } catch (\Exception $e) {
            $this->toast()->error('Error loading meeting: ' . $e->getMessage())->send();
        }
    }

    #[On('loadData-edit-meeting')]
    public function loadMeeting($meetingId)
    {
        $this->meeting = Meeting::with(['users', 'project', 'meetingType', 'meetingStatus'])->findOrFail($meetingId);
        $this->isEdit = true;
        $this->fillFromMeeting();
        // Use update rules for editing
        $this->rules = Meeting::MEETING_UPDATE_RULES;
        $this->messages = Meeting::MEETING_UPDATE_MESSAGES;
    }

    // Real-time validation like ProjectCreate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    private function fillFromMeeting()
    {
        if (!$this->meeting) return;
        
        $this->title = $this->meeting->title ?? '';
        $this->description = $this->meeting->description ?? '';
        $this->agenda = $this->meeting->agenda ?? '';
        $this->start_time = $this->meeting->start_time ? $this->meeting->start_time->format('Y-m-d\TH:i') : '';
        $this->end_time = $this->meeting->end_time ? $this->meeting->end_time->format('Y-m-d\TH:i') : '';
        $this->location = $this->meeting->location ?? '';
        $this->meeting_link = $this->meeting->meeting_link ?? '';
        $this->platform_id = $this->meeting->platform_id ?? null;
        $this->meeting_type_id = $this->meeting->meeting_type_id ?? null;
        $this->status_id = $this->meeting->status_id ?? 2;
        $this->project_id = $this->meeting->project_id ?? null;
        $this->user_ids = $this->meeting->users ? $this->meeting->users->pluck('id')->toArray() : [];
    }

    public function save()
    {
        try {
            // Simple validation like ProjectCreate - clean and effective
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

            if ($this->isEdit && $this->meeting) {
                $this->meeting->update($data);
                $message = 'Meeting updated successfully!';
            } else {
                $this->meeting = Meeting::create($data);
                $message = 'Meeting created successfully!';
            }

            // Sync participants
            $userIds = is_array($validatedData['user_ids']) ? $validatedData['user_ids'] : [];
            if (!empty($userIds)) {
                $this->meeting->users()->sync($userIds);
            } else {
                $this->meeting->users()->detach();
            }

            // Clear cache and refresh
            $this->clearMeetingCache();
            $this->toast()->success($message)->send();
            $this->dispatch('loadData-meetings');
            $this->dispatch('close-modal-create');
            $this->dispatch('close-modal-edit');

            if (!$this->isEdit) {
                $this->resetForm();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->toast()->error('An error occurred: ' . $e->getMessage())->send();
        }
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

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->agenda = '';
        $this->location = '';
        $this->meeting_link = '';
        $this->meeting_type_id = null;
        $this->status_id = 2;
        $this->project_id = null;
        $this->user_ids = [];
        $this->start_time = now()->addHour()->format('Y-m-d\TH:i');
        $this->end_time = now()->addHours(2)->format('Y-m-d\TH:i');
        $this->meeting = null;
        $this->isEdit = false;
        // Reset to create rules
        $this->rules = Meeting::MEETING_CREATE_RULES;
        $this->messages = Meeting::MEETING_CREATE_MESSAGES;
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
        return view('livewire.meetings.create-edit-meeting', [
            'meetingStatuses' => $this->getMeetingStatuses(),
            'meetingTypes' => $this->getMeetingTypes(),
            'platforms' => $this->getPlatforms(),
            'users' => $this->getUsers(),
            'projects' => $this->getProjects(),
        ]);
    }
}
