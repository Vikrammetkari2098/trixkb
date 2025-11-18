<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\RBACService;
use TallStackUi\Traits\Interactions;

class AdminSettings extends Component
{
    use Interactions;
    public $systemSettings = [
        'app_name' => 'TrixFlow',
        'app_version' => '1.0.0',
        'max_users' => 100,
        'max_projects' => 50,
        'storage_limit' => '10GB',
        'maintenance_mode' => false,
        'email_notifications' => true,
        'auto_backup' => true,
        'session_timeout' => 60
    ];

    public $notificationSettings = [
        // Task notifications
        'task_creation_email' => true,
        'task_creation_system' => true,
        'task_status_email' => true,
        'task_status_system' => true,
        
        // Meeting notifications
        'meeting_creation_email' => true,
        'meeting_creation_system' => true,
        'meeting_reminder_email' => true,
        'meeting_reminder_time' => 30,
        
        // Project notifications
        'project_update_email' => true,
        'project_update_system' => true,
        'team_addition_email' => true,
        'team_addition_system' => true,
        
        // System notifications
        'deadline_reminder_email' => true,
        'deadline_reminder_days' => 3,
        'daily_digest_email' => false,
        'daily_digest_time' => '08:00'
    ];

    public $userStats = [
        'total_users' => 0,
        'active_users' => 0,
        'super_admins' => 0,
        'admins' => 0,
        'basic_users' => 0
    ];

    public $projectStats = [
        'total_projects' => 0,
        'active_projects' => 0,
        'completed_projects' => 0,
        'total_tasks' => 0,
        'pending_tasks' => 0,
        'completed_tasks' => 0
    ];

    public $auditStats = [
        'total_activities' => 0,
        'user_actions' => 0,
        'system_events' => 0,
        'security_events' => 0
    ];

    public $auditTrail = [];

    // Filter properties for TallStackUI selects
    public $reminderTime = '30';
    public $reminderDays = '3';
    public $digestTime = '08:00';
    public $auditFilter = 'all';
    public $dateRange = 'week';
    public $userFilter = 'all';
    public $actionFilter = 'all';

    public function mount()
    {
        // Check if user is super admin
        if (!RBACService::isSuperAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $this->loadStats();
    }

    public function loadStats()
    {
        // Load user statistics (hardcoded for now)
        $this->userStats = [
            'total_users' => 25,
            'active_users' => 22,
            'super_admins' => 2,
            'admins' => 3,
            'basic_users' => 20
        ];

        // Load project statistics (hardcoded for now)
        $this->projectStats = [
            'total_projects' => 15,
            'active_projects' => 12,
            'completed_projects' => 3,
            'total_tasks' => 145,
            'pending_tasks' => 89,
            'completed_tasks' => 56
        ];

        // Load audit trail statistics
        $this->auditStats = [
            'total_activities' => 1247,
            'user_actions' => 892,
            'system_events' => 213,
            'security_events' => 12
        ];

        // Load sample audit trail data
        $this->auditTrail = [
            [
                'timestamp' => '2025-08-11 14:30:25',
                'user_name' => 'Ahmed Arabee',
                'user_role' => 'Basic User',
                'user_avatar' => asset('assets/img/avatars/avatar1.jpeg'),
                'action_type' => 'create',
                'resource' => 'Project',
                'details' => 'Created new project "Mobile App Development"',
                'ip_address' => '192.168.1.105',
                'status' => 'success'
            ],
            [
                'timestamp' => '2025-08-11 13:45:12',
                'user_name' => 'Izzat Saifullah',
                'user_role' => 'Super Admin',
                'user_avatar' => asset('assets/img/avatars/avatar2.jpeg'),
                'action_type' => 'update',
                'resource' => 'System Settings',
                'details' => 'Modified system notification settings',
                'ip_address' => '192.168.1.100',
                'status' => 'success'
            ],
            [
                'timestamp' => '2025-08-11 12:20:08',
                'user_name' => 'Unknown User',
                'user_role' => '-',
                'user_avatar' => asset('assets/img/avatars/avatar3.jpeg'),
                'action_type' => 'login',
                'resource' => 'Authentication',
                'details' => 'Failed login attempt for "admin@example.com"',
                'ip_address' => '87.251.74.123',
                'status' => 'failed'
            ],
            [
                'timestamp' => '2025-08-11 11:15:33',
                'user_name' => 'hello world',
                'user_role' => 'Admin',
                'user_avatar' => asset('assets/img/avatars/avatar4.jpeg'),
                'action_type' => 'delete',
                'resource' => 'Task',
                'details' => 'Deleted task "Old legacy code cleanup"',
                'ip_address' => '192.168.1.102',
                'status' => 'success'
            ],
            [
                'timestamp' => '2025-08-11 10:45:18',
                'user_name' => 'Ahmed Arabee',
                'user_role' => 'Basic User',
                'user_avatar' => asset('assets/img/avatars/avatar1.jpeg'),
                'action_type' => 'update',
                'resource' => 'Task',
                'details' => 'Updated task status to "In Progress"',
                'ip_address' => '192.168.1.105',
                'status' => 'success'
            ]
        ];
    }

    public function toggleMaintenanceMode()
    {
        $this->systemSettings['maintenance_mode'] = !$this->systemSettings['maintenance_mode'];
        // In real implementation, this would update the system configuration
    }

    public function toggleEmailNotifications()
    {
        $this->systemSettings['email_notifications'] = !$this->systemSettings['email_notifications'];
        // In real implementation, this would update the system configuration
    }

    public function toggleAutoBackup()
    {
        $this->systemSettings['auto_backup'] = !$this->systemSettings['auto_backup'];
        // In real implementation, this would update the system configuration
    }

    // Notification setting methods
    public function toggleTaskCreationEmail()
    {
        $this->notificationSettings['task_creation_email'] = !$this->notificationSettings['task_creation_email'];
        $this->toast()->info('Updated', 'Task creation email notification setting updated')->send();
    }

    public function toggleTaskCreationSystem()
    {
        $this->notificationSettings['task_creation_system'] = !$this->notificationSettings['task_creation_system'];
        $this->toast()->info('Updated', 'Task creation system notification setting updated')->send();
    }

    public function toggleTaskStatusEmail()
    {
        $this->notificationSettings['task_status_email'] = !$this->notificationSettings['task_status_email'];
        $this->toast()->info('Updated', 'Task status email notification setting updated')->send();
    }

    public function toggleTaskStatusSystem()
    {
        $this->notificationSettings['task_status_system'] = !$this->notificationSettings['task_status_system'];
        $this->toast()->info('Updated', 'Task status system notification setting updated')->send();
    }

    public function toggleMeetingCreationEmail()
    {
        $this->notificationSettings['meeting_creation_email'] = !$this->notificationSettings['meeting_creation_email'];
        $this->toast()->info('Updated', 'Meeting creation email notification setting updated')->send();
    }

    public function toggleMeetingCreationSystem()
    {
        $this->notificationSettings['meeting_creation_system'] = !$this->notificationSettings['meeting_creation_system'];
        $this->toast()->info('Updated', 'Meeting creation system notification setting updated')->send();
    }

    public function toggleMeetingReminderEmail()
    {
        $this->notificationSettings['meeting_reminder_email'] = !$this->notificationSettings['meeting_reminder_email'];
        $this->toast()->info('Updated', 'Meeting reminder email setting updated')->send();
    }

    public function toggleProjectUpdateEmail()
    {
        $this->notificationSettings['project_update_email'] = !$this->notificationSettings['project_update_email'];
        $this->toast()->info('Updated', 'Project update email notification setting updated')->send();
    }

    public function toggleProjectUpdateSystem()
    {
        $this->notificationSettings['project_update_system'] = !$this->notificationSettings['project_update_system'];
        $this->toast()->info('Updated', 'Project update system notification setting updated')->send();
    }

    public function toggleTeamAdditionEmail()
    {
        $this->notificationSettings['team_addition_email'] = !$this->notificationSettings['team_addition_email'];
        $this->toast()->info('Updated', 'Team addition email notification setting updated')->send();
    }

    public function toggleTeamAdditionSystem()
    {
        $this->notificationSettings['team_addition_system'] = !$this->notificationSettings['team_addition_system'];
        $this->toast()->info('Updated', 'Team addition system notification setting updated')->send();
    }

    public function toggleDeadlineReminderEmail()
    {
        $this->notificationSettings['deadline_reminder_email'] = !$this->notificationSettings['deadline_reminder_email'];
        $this->toast()->info('Updated', 'Deadline reminder email setting updated')->send();
    }

    public function toggleDailyDigestEmail()
    {
        $this->notificationSettings['daily_digest_email'] = !$this->notificationSettings['daily_digest_email'];
        $this->toast()->info('Updated', 'Daily digest email setting updated')->send();
    }

    public function enableAllNotifications()
    {
        foreach ($this->notificationSettings as $key => $value) {
            if (is_bool($value)) {
                $this->notificationSettings[$key] = true;
            }
        }
        $this->toast()->success('Success', 'All notifications have been enabled')->send();
    }

    public function disableAllNotifications()
    {
        foreach ($this->notificationSettings as $key => $value) {
            if (is_bool($value)) {
                $this->notificationSettings[$key] = false;
            }
        }
        $this->toast()->warning('Warning', 'All notifications have been disabled')->send();
    }

    public function saveNotificationSettings()
    {
        // In real implementation, this would save settings to database
        $this->toast()->success('Success', 'Notification settings have been saved successfully')->send();
    }

    public function exportAuditTrail()
    {
        // In real implementation, this would generate and download a CSV/Excel file
        // For now, just show a success message
        $this->toast()->success('Success', 'Audit trail export initiated. Download will start shortly.')->send();
    }

    public function resetAuditFilters()
    {
        // In real implementation, this would reset all filter parameters
        $this->toast()->info('Info', 'Audit trail filters have been reset')->send();
    }

    public function render()
    {
        return view('livewire.admin.admin-settings');
    }
}
