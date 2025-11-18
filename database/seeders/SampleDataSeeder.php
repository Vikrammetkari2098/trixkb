<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\Role;
use App\Models\Priority;
use App\Models\TaskType;
use App\Models\Module;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional users
        $users = [
            [
                'name' => 'Sarah Chen',
                'email' => 'sarah.chen@example.com',
                'team_id' => 2, // .Net team
                'role' => 'basic'
            ],
            [
                'name' => 'Marcus Johnson',
                'email' => 'marcus.j@example.com',
                'team_id' => 3, // UI/UX team
                'role' => 'basic'
            ],
            [
                'name' => 'Elena Rodriguez',
                'email' => 'elena.r@example.com',
                'team_id' => 4, // QA team
                'role' => 'basic'
            ],
            [
                'name' => 'David Kim',
                'email' => 'david.kim@example.com',
                'team_id' => 1, // PHP team
                'role' => 'admin'
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.t@example.com',
                'team_id' => 5, // Marketing team
                'role' => 'basic'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password123'),
                'team_id' => $userData['team_id'],
                'created_at' => Carbon::now()->subDays(rand(30, 90)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30))
            ]);

            // Assign role
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }

        // Create additional projects
        $projects = [
            [
                'title' => 'MediConnect',
                'description' => 'Healthcare platform connecting patients with doctors through secure video consultations and medical record management.',
                'priority_id' => 3, // high
                'start_time' => Carbon::now()->addDays(5),
                'end_time' => Carbon::now()->addDays(45),
                'modules' => [14, 15, 16, 18] // marketing, livechat, knowledgebase, TrixVoice
            ],
            [
                'title' => 'FinTracker Pro',
                'description' => 'Personal finance management app with budget tracking, expense categorization, and investment portfolio analysis.',
                'priority_id' => 2, // medium
                'start_time' => Carbon::now()->addDays(10),
                'end_time' => Carbon::now()->addDays(60),
                'modules' => [20, 21, 22] // mobile app, reporting, chatbot
            ],
            [
                'title' => 'EduLearn Platform',
                'description' => 'Online learning platform with interactive courses, progress tracking, and certification management for educational institutions.',
                'priority_id' => 1, // low
                'start_time' => Carbon::now()->addDays(15),
                'end_time' => Carbon::now()->addDays(75),
                'modules' => [16, 20, 24] // knowledgebase, mobile app, survey
            ],
            [
                'title' => 'RetailEdge',
                'description' => 'E-commerce solution with inventory management, order processing, and customer analytics for retail businesses.',
                'priority_id' => 3, // high
                'start_time' => Carbon::now()->addDays(3),
                'end_time' => Carbon::now()->addDays(40),
                'modules' => [14, 19, 21, 25] // marketing, TrixIPX, reporting, debt collection
            ]
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                'title' => $projectData['title'],
                'description' => $projectData['description'],
                'priority_id' => $projectData['priority_id'],
                'start_time' => $projectData['start_time'],
                'end_time' => $projectData['end_time'],
                'created_at' => Carbon::now()->subDays(rand(20, 60)),
                'updated_at' => Carbon::now()->subDays(rand(1, 20))
            ]);

            // Attach modules
            $project->modules()->attach($projectData['modules']);

            // Assign users to project (2-4 users per project)
            $userIds = User::inRandomOrder()->limit(rand(2, 4))->pluck('id');
            $project->users()->attach($userIds);
        }

        // Create additional tasks for all projects
        $taskTemplates = [
            // Development tasks
            [
                'title' => 'API Design & Documentation',
                'description' => 'Design RESTful API endpoints and create comprehensive documentation using OpenAPI specifications.',
                'task_type_id' => 1, // task
                'status' => '1', // To-do
                'priority_id' => 2 // medium
            ],
            [
                'title' => 'Database Schema Optimization',
                'description' => 'Optimize database queries and implement proper indexing for better performance.',
                'task_type_id' => 1, // task
                'status' => '2', // In-Progress
                'priority_id' => 3 // high
            ],
            [
                'title' => 'User Interface Wireframes',
                'description' => 'Create detailed wireframes for all major user interface components and user flows.',
                'task_type_id' => 3, // design
                'status' => '3', // In Review
                'priority_id' => 2 // medium
            ],
            [
                'title' => 'Security Audit Implementation',
                'description' => 'Implement security best practices including input validation, CSRF protection, and secure authentication.',
                'task_type_id' => 1, // task
                'status' => '1', // To-do
                'priority_id' => 3 // high
            ],
            [
                'title' => 'Mobile Responsive Design',
                'description' => 'Ensure all components are fully responsive and provide optimal user experience on mobile devices.',
                'task_type_id' => 3, // design
                'status' => '2', // In-Progress
                'priority_id' => 2 // medium
            ],
            
            // Issues
            [
                'title' => 'Performance Issues on Large Datasets',
                'description' => 'Application becomes slow when handling datasets with more than 10,000 records. Need to implement pagination and lazy loading.',
                'task_type_id' => 2, // issue
                'status' => '1', // To-do
                'priority_id' => 3 // high
            ],
            [
                'title' => 'Cross-browser Compatibility Bug',
                'description' => 'Date picker component fails to work properly in Firefox and Safari browsers.',
                'task_type_id' => 2, // issue
                'status' => '2', // In-Progress
                'priority_id' => 2 // medium
            ],
            [
                'title' => 'Memory Leak in Background Tasks',
                'description' => 'Background job processes consuming excessive memory and not releasing resources properly.',
                'task_type_id' => 2, // issue
                'status' => '4', // Completed
                'priority_id' => 3 // high
            ],

            // Additional tasks
            [
                'title' => 'Integration Testing Suite',
                'description' => 'Develop comprehensive integration tests covering all API endpoints and user workflows.',
                'task_type_id' => 1, // task
                'status' => '1', // To-do
                'priority_id' => 2 // medium
            ],
            [
                'title' => 'User Dashboard Analytics',
                'description' => 'Implement analytics dashboard with charts and reports for user activity and system metrics.',
                'task_type_id' => 1, // task
                'status' => '3', // In Review
                'priority_id' => 1 // low
            ],
            [
                'title' => 'Email Notification Templates',
                'description' => 'Design and implement responsive email templates for user notifications and system alerts.',
                'task_type_id' => 3, // design
                'status' => '4', // Completed
                'priority_id' => 1 // low
            ],
            [
                'title' => 'Data Export Functionality',
                'description' => 'Allow users to export their data in multiple formats (CSV, Excel, PDF) with custom filtering options.',
                'task_type_id' => 1, // task
                'status' => '2', // In-Progress
                'priority_id' => 2 // medium
            ]
        ];

        $projects = Project::all();
        $users = User::all();

        foreach ($projects as $project) {
            // Create 4-8 tasks per project
            $numTasks = rand(4, 8);
            $selectedTasks = collect($taskTemplates)->random($numTasks);
            
            foreach ($selectedTasks as $taskData) {
                $assignedUser = $users->random();
                $createdBy = $users->random();
                
                // Set realistic dates
                $startTime = Carbon::now()->subDays(rand(1, 30));
                $endTime = (clone $startTime)->addDays(rand(7, 21));

                Task::create([
                    'project_id' => $project->id,
                    'assigned_to' => $assignedUser->id,
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'priority_id' => $taskData['priority_id'],
                    'task_type_id' => $taskData['task_type_id'],
                    'status' => $taskData['status'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'created_by' => $createdBy->id,
                    'created_at' => $startTime->subDays(rand(1, 5)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 3))
                ]);
            }
        }

        $this->command->info('Sample data has been created successfully!');
        $this->command->info('Created:');
        $this->command->info('- 5 additional users');
        $this->command->info('- 4 additional projects with modules');
        $this->command->info('- Multiple tasks for each project');
        $this->command->info('');
        $this->command->info('You can now see a rich interface with meaningful data.');
    }
}
