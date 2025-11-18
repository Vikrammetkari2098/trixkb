<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users, projects, and tasks
        $users = User::all();
        $projects = Project::all();
        $tasks = Task::all();

        if ($users->isEmpty() || $projects->isEmpty()) {
            $this->command->info('No users or projects found. Please seed users and projects first.');
            return;
        }

        // Sample activities
        $activities = [
            [
                'user_id' => $users->first()->id,
                'project_id' => $projects->first()->id,
                'task_id' => $tasks->first()->id ?? null,
                'action' => 'completed_task',
                'description' => 'Completed task: "' . ($tasks->first()->title ?? 'Sample Task') . '"',
                'type' => 'task',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'user_id' => $users->count() > 1 ? $users->skip(1)->first()->id : $users->first()->id,
                'project_id' => $projects->first()->id,
                'action' => 'created_task',
                'description' => 'Created a new task in project: "' . $projects->first()->title . '"',
                'type' => 'task',
                'created_at' => Carbon::now()->subHours(4),
            ],
            [
                'user_id' => $users->first()->id,
                'project_id' => $projects->count() > 1 ? $projects->skip(1)->first()->id : $projects->first()->id,
                'action' => 'updated_project',
                'description' => 'Updated project details and timeline',
                'type' => 'project',
                'created_at' => Carbon::now()->subHours(6),
            ],
            [
                'user_id' => $users->count() > 1 ? $users->skip(1)->first()->id : $users->first()->id,
                'action' => 'joined_team',
                'description' => 'Joined the development team',
                'type' => 'team',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => $users->first()->id,
                'project_id' => $projects->first()->id,
                'task_id' => $tasks->count() > 1 ? $tasks->skip(1)->first()->id : null,
                'action' => 'commented_task',
                'description' => 'Added comment to task discussion',
                'type' => 'comment',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }

        $this->command->info('Activities seeded successfully!');
    }
}
