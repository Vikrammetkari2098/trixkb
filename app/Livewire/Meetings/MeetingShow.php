<?php

namespace App\Livewire\Meetings;

use App\Models\Meeting;
use App\Models\MeetingStatus;
use App\Models\MeetingType;
use App\Models\User;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class MeetingShow extends Component
{
    use WithPagination;

    public $isReady = false;
    public ?string $search = null;
    public ?int $quantity = 10;
    public string $tab = 'current';
    public array $sort = [
        'column' => 'start_time',
        'direction' => 'asc',
    ];
    
    // Statistics properties
    public $meetingStats = [];

    public function loadData()
    {
        $this->loadMeetingStats();
        $this->isReady = true;
    }

    #[On('loadData-meetings')]
    public function refreshData()
    {
        // Clear caches and reload data like projects
        $userId = auth()->id();
        Cache::forget("meetings_this_week_{$userId}");
        Cache::forget("meetings_this_month_{$userId}");
        Cache::forget("meetings_future_{$userId}");
        
        $this->loadMeetingStats();
        $this->resetPage(); // Reset pagination if needed
    }

    #[On('edit-meeting')]
    public function editMeeting($id)
    {
        $this->dispatch('loadData-edit-meeting', meetingId: $id);
        $this->dispatch('open-modal-edit');
    }

    public function mount($tab = 'current')
    {
        $this->tab = $tab;
        // Don't load data immediately to show skeleton
    }

    public function getThisWeekMeetings()
    {
        if (!$this->isReady) return collect();

        return Cache::remember("meetings_this_week_" . auth()->id(), 300, function () {
            return Meeting::with(['organizer', 'creator', 'users', 'project', 'meetingType', 'meetingStatus', 'platform'])
                ->withCount('users as participants_count')
                ->whereBetween('start_time', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])
                ->where('start_time', '>=', Carbon::now())
                ->orderBy('start_time', 'asc')
                ->get()
                ->map(function ($meeting) {
                    return $this->formatMeeting($meeting);
                });
        });
    }

    public function getThisMonthMeetings()
    {
        if (!$this->isReady) return collect();

        return Cache::remember("meetings_this_month_" . auth()->id(), 300, function () {
            return Meeting::with(['organizer', 'creator', 'users', 'project', 'meetingType', 'meetingStatus', 'platform'])
                ->withCount('users as participants_count')
                ->whereBetween('start_time', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])
                ->where('start_time', '>', Carbon::now()->endOfWeek())
                ->orderBy('start_time', 'asc')
                ->get()
                ->map(function ($meeting) {
                    return $this->formatMeeting($meeting);
                });
        });
    }

    public function getFutureMeetings()
    {
        if (!$this->isReady) return collect();

        return Cache::remember("meetings_future_" . auth()->id(), 300, function () {
            return Meeting::with(['organizer', 'creator', 'users', 'project', 'meetingType', 'meetingStatus', 'platform'])
                ->withCount('users as participants_count')
                ->where('start_time', '>', Carbon::now()->endOfMonth())
                ->orderBy('start_time', 'asc')
                ->get()
                ->map(function ($meeting) {
                    return $this->formatMeeting($meeting);
                });
        });
    }

    public function getPastMeetings()
    {
        if (!$this->isReady) return collect();

        return Meeting::with(['organizer', 'creator', 'users', 'project', 'meetingType', 'meetingStatus', 'platform'])
            ->withCount('users as participants_count')
            ->where('end_time', '<', Carbon::now())
            ->orderBy('start_time', 'desc')
            ->paginate($this->quantity, ['*'], 'past')
            ->through(function ($meeting) {
                return $this->formatMeeting($meeting);
            });
    }

    private function formatMeeting($meeting)
    {
        $meeting->start_time_formatted = $meeting->start_time 
            ? $meeting->start_time->format('M j, Y - g:i A') 
            : '-';
        $meeting->end_time_formatted = $meeting->end_time 
            ? $meeting->end_time->format('g:i A') 
            : '-';
        $meeting->duration = $meeting->start_time && $meeting->end_time 
            ? $meeting->start_time->format('g:i A') . ' - ' . $meeting->end_time->format('g:i A')
            : '-';
        $meeting->type_name = optional($meeting->meetingType)->name ?? 'General';
        $meeting->platform_name = $meeting->platform_name ?? $meeting->location ?? 'Video Conference';
        $meeting->is_past = $meeting->end_time ? $meeting->end_time->isPast() : false;
        $meeting->is_active = $meeting->start_time && $meeting->end_time 
            ? Carbon::now()->between($meeting->start_time, $meeting->end_time)
            : false;
        
        return $meeting;
    }

    private function loadMeetingStats()
    {
        $userId = auth()->id();
        
        // Today's meetings
        $todaysMeetings = Meeting::whereDate('start_time', Carbon::today())
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
            
        // This week's meetings
        $thisWeekMeetings = Meeting::whereBetween('start_time', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
        ->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->count();
        
        // Upcoming meetings (next 7 days)
        $upcomingMeetings = Meeting::whereBetween('start_time', [
            Carbon::now(),
            Carbon::now()->addDays(7)
        ])
        ->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->count();
        
        // Total meetings this month
        $thisMonthMeetings = Meeting::whereBetween('start_time', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])
        ->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->count();
        
        $this->meetingStats = [
            'todays_meetings' => $todaysMeetings,
            'this_week_meetings' => $thisWeekMeetings,
            'upcoming_meetings' => $upcomingMeetings,
            'this_month_meetings' => $thisMonthMeetings,
        ];
    }

    public function getPlatformIcon($platform)
    {
        if (!$platform) return 'mdi--monitor';
        
        $platform = strtolower($platform);
        if (str_contains($platform, 'zoom')) return 'simple-icons--zoom';
        if (str_contains($platform, 'teams') || str_contains($platform, 'microsoft')) return 'simple-icons--microsoftteams';
        if (str_contains($platform, 'meet') || str_contains($platform, 'google')) return 'simple-icons--googlemeet';
        if (str_contains($platform, 'skype')) return 'simple-icons--skype';
        if (str_contains($platform, 'webex')) return 'simple-icons--webex';
        if (str_contains($platform, 'discord')) return 'simple-icons--discord';
        if (str_contains($platform, 'slack')) return 'simple-icons--slack';
        return 'mdi--monitor';
    }

    public function getMeetingStatuses()
    {
        return Cache::remember('meeting_statuses', 3600, function () {
            return MeetingStatus::orderBy('name')->get();
        });
    }

    public function getMeetingTypes()
    {
        return Cache::remember('meeting_types', 3600, function () {
            return MeetingType::orderBy('name')->get();
        });
    }

    public function getUsers()
    {
        return Cache::remember('users_for_meetings', 300, function () {
            return User::select('id', 'name', 'email')
                ->orderBy('name')
                ->get();
        });
    }

    public function getProjects()
    {
        return Cache::remember('projects_for_meetings', 300, function () {
            return Project::select('id', 'title')
                ->orderBy('title')
                ->get();
        });
    }

    public function with(): array
    {
        if ($this->tab === 'stats') {
            return [
                'meetingStats' => $this->meetingStats,
                'tab' => $this->tab,
            ];
        }
        
        if ($this->tab === 'past') {
            return [
                'pastMeetings' => $this->getPastMeetings(),
                'tab' => $this->tab,
                'meetingStatuses' => $this->getMeetingStatuses(),
                'meetingTypes' => $this->getMeetingTypes(),
                'users' => $this->getUsers(),
                'projects' => $this->getProjects(),
            ];
        }

        return [
            'thisWeekMeetings' => $this->getThisWeekMeetings(),
            'thisMonthMeetings' => $this->getThisMonthMeetings(),
            'futureMeetings' => $this->getFutureMeetings(),
            'tab' => $this->tab,
            'meetingStatuses' => $this->getMeetingStatuses(),
            'meetingTypes' => $this->getMeetingTypes(),
            'users' => $this->getUsers(),
            'projects' => $this->getProjects(),
        ];
    }

    public function render()
    {
        return view('livewire.meetings.meeting-show', $this->with());
    }
}
