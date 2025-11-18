<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meeting;
use App\Models\User;
use App\Models\Project;
use App\Models\MeetingType;
use App\Models\MeetingStatus;
use App\Models\Platform;
use Carbon\Carbon;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $users = User::all();
        $projects = Project::all();
        
        // Get existing meeting types, statuses, and platforms
        $meetingTypes = MeetingType::all();
        $meetingStatuses = MeetingStatus::all();
        $platforms = Platform::all();
        
        // Sample meeting data
        $meetingData = [
            [
                'title' => 'Project Kickoff Meeting',
                'description' => 'Initial project planning and team introductions',
                'agenda' => 'Introduction • Project Overview • Team Roles • Timeline Discussion • Q&A',
                'days_offset' => 1,
                'duration_hours' => 2,
                'max_participants' => 10,
            ],
            [
                'title' => 'Weekly Standup',
                'description' => 'Team synchronization and progress updates',
                'agenda' => 'Yesterday\'s Progress • Today\'s Goals • Blockers Discussion',
                'days_offset' => 2,
                'duration_hours' => 1,
                'max_participants' => 8,
            ],
            [
                'title' => 'Sprint Planning Session',
                'description' => 'Planning the next development sprint',
                'agenda' => 'Sprint Goals • Backlog Review • Story Estimation • Task Assignment',
                'days_offset' => 3,
                'duration_hours' => 3,
                'max_participants' => 6,
            ],
            [
                'title' => 'Client Presentation',
                'description' => 'Presenting project progress to stakeholders',
                'agenda' => 'Project Update • Demo • Feedback Session • Next Steps',
                'days_offset' => 5,
                'duration_hours' => 1.5,
                'max_participants' => 12,
                'requires_approval' => true,
            ],
            [
                'title' => 'Design Review Meeting',
                'description' => 'Reviewing UI/UX designs and gathering feedback',
                'agenda' => 'Design Presentation • Feedback Collection • Revision Planning',
                'days_offset' => 7,
                'duration_hours' => 2,
                'max_participants' => 8,
            ],
            [
                'title' => 'Code Review Session',
                'description' => 'Peer review of recent code changes',
                'agenda' => 'Code Walkthrough • Best Practices Discussion • Action Items',
                'days_offset' => 8,
                'duration_hours' => 1,
                'max_participants' => 5,
            ],
            [
                'title' => 'Product Demo',
                'description' => 'Demonstrating new features to the team',
                'agenda' => 'Feature Demo • Testing Results • User Feedback • Release Planning',
                'days_offset' => 10,
                'duration_hours' => 1,
                'max_participants' => 15,
            ],
            [
                'title' => 'Architecture Discussion',
                'description' => 'Technical architecture planning and decisions',
                'agenda' => 'Current Architecture • Proposed Changes • Performance Impact • Migration Plan',
                'days_offset' => 12,
                'duration_hours' => 2.5,
                'max_participants' => 6,
            ],
            [
                'title' => 'Customer Feedback Session',
                'description' => 'Analyzing user feedback and planning improvements',
                'agenda' => 'Feedback Analysis • Priority Setting • Implementation Planning',
                'days_offset' => 15,
                'duration_hours' => 1.5,
                'max_participants' => 8,
            ],
            [
                'title' => 'Team Retrospective',
                'description' => 'Reflecting on team performance and processes',
                'agenda' => 'What Went Well • What Could Improve • Action Items • Team Building',
                'days_offset' => 20,
                'duration_hours' => 1.5,
                'max_participants' => 10,
            ],
            // Past meetings
            [
                'title' => 'Q4 Planning Meeting',
                'description' => 'Strategic planning for the fourth quarter',
                'agenda' => 'Q3 Review • Q4 Goals • Resource Planning • Timeline Setting',
                'days_offset' => -5,
                'duration_hours' => 3,
                'max_participants' => 12,
                'notes' => 'Successful planning session. All quarterly goals defined and assigned.',
            ],
            [
                'title' => 'Security Audit Review',
                'description' => 'Reviewing security audit findings',
                'agenda' => 'Audit Results • Vulnerability Assessment • Remediation Plan • Timeline',
                'days_offset' => -10,
                'duration_hours' => 2,
                'max_participants' => 8,
                'notes' => 'All critical issues addressed. Medium priority items scheduled for next sprint.',
            ],
            [
                'title' => 'Budget Review Meeting',
                'description' => 'Quarterly budget review and adjustments',
                'agenda' => 'Budget Analysis • Variance Review • Adjustment Proposals • Approval Process',
                'days_offset' => -15,
                'duration_hours' => 2,
                'max_participants' => 6,
                'notes' => 'Budget approved with minor adjustments. Additional resources allocated for Q4.',
            ],
        ];
        
        foreach ($meetingData as $index => $data) {
            $startTime = Carbon::now()->addDays($data['days_offset'])->setHour(rand(9, 16))->setMinute(rand(0, 3) * 15);
            $endTime = $startTime->copy()->addHours($data['duration_hours']);
            
            $meeting = Meeting::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'agenda' => $data['agenda'] ?? null,
                'notes' => $data['notes'] ?? null,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'timezone' => 'UTC',
                'location' => $index % 3 === 0 ? 'Conference Room A' : null,
                'meeting_link' => $index % 3 !== 0 ? 'https://zoom.us/j/'.rand(1000000000, 9999999999) : null,
                'meeting_type_id' => $meetingTypes->random()->id,
                'status_id' => $meetingStatuses->random()->id,
                'platform_id' => $platforms->random()->id,
                'created_by' => $users->random()->id,
                'project_id' => $projects->random()->id,
                'max_participants' => $data['max_participants'] ?? rand(5, 15),
                'is_recurring' => false,
                'requires_approval' => $data['requires_approval'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Attach random users to the meeting
            $participantCount = rand(2, min(6, $users->count()));
            $participants = $users->random($participantCount);
            $meeting->users()->attach($participants->pluck('id'));
        }
        
        $this->command->info('Meeting seeder completed successfully!');
    }
}
