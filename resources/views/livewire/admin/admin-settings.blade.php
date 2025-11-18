<div class="space-y-6">
    <!-- Header -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="card-title text-2xl mb-1">Admin Settings</h1>
                    <p class="text-base text-gray-600">Manage system configuration and monitor platform statistics</p>
                </div>
                <div class="flex items-center space-x-2">
                    <x-badge text="System Online" color="green" sm />
                </div>
            </div>
        </div>
    </div>

    <!-- System Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <span class="icon-[tabler--users] text-blue-600 w-6 h-6"></span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $userStats['total_users'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <span class="icon-[tabler--folder] text-green-600 w-6 h-6"></span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-600">Active Projects</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $projectStats['active_projects'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <span class="icon-[tabler--clock] text-yellow-600 w-6 h-6"></span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-600">Pending Tasks</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $projectStats['pending_tasks'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage Used -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <span class="icon-[tabler--database] text-purple-600 w-6 h-6"></span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-base font-medium text-gray-600">Storage Used</p>
                        <p class="text-2xl font-bold text-gray-900">7.2GB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- System Settings -->
        <div class="card lg:col-span-2">
            <div class="card-body">
                <h2 class="card-title mb-2.5">System Settings</h2>
                <p class="text-base text-gray-600 mb-6">Configure system-wide settings and preferences</p>
                <!-- Application Info -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Application Information</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-base">
                        <div>
                            <span class="text-gray-600">App Name:</span>
                            <span class="ml-2 font-medium">{{ $systemSettings['app_name'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Version:</span>
                            <span class="ml-2 font-medium">{{ $systemSettings['app_version'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Max Users:</span>
                            <span class="ml-2 font-medium">{{ $systemSettings['max_users'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Storage Limit:</span>
                            <span class="ml-2 font-medium">{{ $systemSettings['storage_limit'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Toggle Settings -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">System Controls</h3>
                    
                    <!-- Maintenance Mode -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-medium text-gray-900">Maintenance Mode</p>
                            <p class="text-sm text-gray-600">Put the system in maintenance mode</p>
                        </div>
                        <x-toggle md color="green" label="Enabled" />
                    </div>

                    <!-- Email Notifications -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-medium text-gray-900">Email Notifications</p>
                            <p class="text-sm text-gray-600">Send system notifications via email</p>
                        </div>
                        <x-toggle md color="green" label="Enabled" />
                    </div>

                    <!-- Auto Backup -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-medium text-gray-900">Automatic Backup</p>
                            <p class="text-sm text-gray-600">Enable daily automated backups</p>
                        </div>
                        <x-toggle md color="green" label="Enabled" />
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management Overview -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title mb-2.5">User Management</h2>
                <p class="text-base text-gray-600 mb-6">Overview of user roles and permissions</p>
                <!-- User Statistics -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-base text-gray-600">Total Users</span>
                        <span class="text-base font-semibold">{{ $userStats['total_users'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-base text-gray-600">Active Users</span>
                        <span class="text-base font-semibold text-green-600">{{ $userStats['active_users'] }}</span>
                    </div>
                </div>

                <!-- Role Distribution -->
                <div class="space-y-3">
                    <h3 class="text-base font-medium text-gray-900">Role Distribution</h3>
                    
                    <!-- Super Admins -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                            <span class="text-base text-gray-600">Super Admins</span>
                        </div>
                        <span class="text-base font-medium">{{ $userStats['super_admins'] }}</span>
                    </div>

                    <!-- Admins -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="text-base text-gray-600">Admins</span>
                        </div>
                        <span class="text-base font-medium">{{ $userStats['admins'] }}</span>
                    </div>

                    <!-- Basic Users -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-500 rounded-full mr-3"></div>
                            <span class="text-base text-gray-600">Basic Users</span>
                        </div>
                        <span class="text-base font-medium">{{ $userStats['basic_users'] }}</span>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="pt-4 border-t border-gray-200">
                    <h3 class="text-base font-medium text-gray-900 mb-3">Quick Actions</h3>
                    <div class="space-y-2">
                        <x-button color="blue" class="w-full text-base">
                            <span class="icon-[tabler--user-plus] w-4 h-4 mr-2"></span>
                            Add New User
                        </x-button>
                        <x-button color="gray" outline class="w-full text-base">
                            <span class="icon-[tabler--users] w-4 h-4 mr-2"></span>
                            Manage Users
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Settings -->
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-2.5">Notification Settings</h2>
            <p class="text-base text-gray-600 mb-6">Configure email and system notification preferences for various project events</p>
            <!-- Task Related Notifications -->
            <div class="space-y-4">
                <h3 class="text-base font-medium text-gray-900">Task Notifications</h3>
                    
                    <!-- Task Creation Notification -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Task Assignment Notifications</p>
                                <p class="text-sm text-gray-600">Notify assigned users when a new task is created and assigned to them</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Notification</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">System Notification</span>
                                <x-toggle md color="green" label="System" />
                            </div>
                        </div>
                    </div>

                    <!-- Task Status Change Notification -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Task Status Change Notifications</p>
                                <p class="text-sm text-gray-600">Notify assignee and admins when task status is updated (pending, in progress, completed, etc.)</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Notification</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">System Notification</span>
                                <x-toggle md color="green" label="System" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Meeting Related Notifications -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Meeting Notifications</h3>
                    
                    <!-- Meeting Creation Notification -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Meeting Participant Notifications</p>
                                <p class="text-sm text-gray-600">Notify all participants when a new meeting is created or scheduled</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Notification</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">System Notification</span>
                                <x-toggle md color="green" label="System" />
                            </div>
                        </div>
                    </div>

                    <!-- Meeting Reminders -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Meeting Reminders</p>
                                <p class="text-sm text-gray-600">Send reminder notifications before scheduled meetings</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Reminders</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Reminder Time:</span>
                                <x-select.styled 
                                    wire:model="reminderTime"
                                    :options="[
                                        ['label' => '15 minutes', 'value' => '15'],
                                        ['label' => '30 minutes', 'value' => '30'],
                                        ['label' => '1 hour', 'value' => '60'],
                                        ['label' => '1 day', 'value' => '1440']
                                    ]"
                                    select="label:label|value:value"
                                    placeholder="Select time" 
                                    class="w-32" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Related Notifications -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Project Notifications</h3>
                    
                    <!-- Project Updates -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Project Status Updates</p>
                                <p class="text-sm text-gray-600">Notify team members when project status changes or milestones are reached</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Notification</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">System Notification</span>
                                <x-toggle md color="green" label="System" />
                            </div>
                        </div>
                    </div>

                    <!-- Team Member Addition -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Team Member Addition</p>
                                <p class="text-sm text-gray-600">Notify users when they are added to a project or team</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Notification</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">System Notification</span>
                                <x-toggle md color="green" label="System" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Notifications -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">System Notifications</h3>
                    
                    <!-- Deadline Reminders -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Deadline Reminders</p>
                                <p class="text-sm text-gray-600">Notify users about approaching task and project deadlines</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Email Reminders</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Reminder Days:</span>
                                <x-select.styled 
                                    wire:model="reminderDays"
                                    :options="[
                                        ['label' => '1 day before', 'value' => '1'],
                                        ['label' => '3 days before', 'value' => '3'],
                                        ['label' => '1 week before', 'value' => '7']
                                    ]"
                                    select="label:label|value:value"
                                    placeholder="Select days" 
                                    class="w-40" />
                            </div>
                        </div>
                    </div>

                    <!-- Daily Digest -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">Daily Digest</p>
                                <p class="text-sm text-gray-600">Send daily summary of tasks, meetings, and project updates</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Enable Daily Digest</span>
                                <x-toggle md color="green" label="Email" />
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-base text-gray-700">Send Time:</span>
                                <x-select.styled 
                                    wire:model="digestTime"
                                    :options="[
                                        ['label' => '8:00 AM', 'value' => '08:00'],
                                        ['label' => '9:00 AM', 'value' => '09:00'],
                                        ['label' => '5:00 PM', 'value' => '17:00'],
                                        ['label' => '6:00 PM', 'value' => '18:00']
                                    ]"
                                    select="label:label|value:value"
                                    placeholder="Select time" 
                                    class="w-32" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Global Settings -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-base font-medium text-gray-900 mb-4">Global Notification Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-button color="blue" class="text-base" wire:click="enableAllNotifications">
                            <span class="icon-[tabler--bell-check] w-4 h-4 mr-2"></span>
                            Enable All
                        </x-button>
                        <x-button color="gray" outline class="text-base" wire:click="disableAllNotifications">
                            <span class="icon-[tabler--bell-off] w-4 h-4 mr-2"></span>
                            Disable All
                        </x-button>
                        <x-button color="green" class="text-base" wire:click="saveNotificationSettings">
                            <span class="icon-[tabler--device-floppy] w-4 h-4 mr-2"></span>
                            Save Settings
                        </x-button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Project Statistics -->
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-2.5">Project & Task Analytics</h2>
            <p class="text-base text-gray-600 mb-6">Monitor project progress and task completion rates</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <!-- Project Stats -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Projects Overview</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Total Projects</span>
                            <span class="text-base font-semibold">{{ $projectStats['total_projects'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Active Projects</span>
                            <span class="text-base font-semibold text-blue-600">{{ $projectStats['active_projects'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Completed</span>
                            <span class="text-base font-semibold text-green-600">{{ $projectStats['completed_projects'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Task Stats -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Task Overview</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Total Tasks</span>
                            <span class="text-base font-semibold">{{ $projectStats['total_tasks'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Pending</span>
                            <span class="text-base font-semibold text-yellow-600">{{ $projectStats['pending_tasks'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Completed</span>
                            <span class="text-base font-semibold text-green-600">{{ $projectStats['completed_tasks'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- System Resources -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">System Resources</h3>
                    <div class="space-y-3">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-base text-gray-600">Storage Usage</span>
                                <span class="text-base font-semibold">72%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-base text-gray-600">User Capacity</span>
                                <span class="text-base font-semibold">25%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Performance</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Avg Response Time</span>
                            <span class="text-base font-semibold text-green-600">120ms</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Uptime</span>
                            <span class="text-base font-semibold text-blue-600">99.9%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">CPU Usage</span>
                            <span class="text-base font-semibold text-yellow-600">45%</span>
                        </div>
                    </div>
                </div>

                <!-- Security Overview -->
                <div class="space-y-4">
                    <h3 class="text-base font-medium text-gray-900">Security</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Last Backup</span>
                            <span class="text-base font-semibold text-green-600">2 hours ago</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Failed Logins</span>
                            <span class="text-base font-semibold text-red-600">3 today</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base text-gray-600">Security Level</span>
                            <span class="text-base font-semibold text-green-600">High</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Logs Preview -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="card-title mb-2.5">Recent System Activity</h2>
                    <p class="text-base text-gray-600">Latest system events and user activities</p>
                </div>
                <x-button color="gray" outline class="text-base">
                    View All Logs
                </x-button>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <!-- Sample Log Entries -->
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-base text-gray-900">User "Ahmed Arabee" created a new project "Mobile App Development"</p>
                        <p class="text-sm text-gray-500">2 hours ago</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-base text-gray-900">System backup completed successfully</p>
                        <p class="text-sm text-gray-500">6 hours ago</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-base text-gray-900">New user "Sarah Johnson" registered with Basic role</p>
                        <p class="text-sm text-gray-500">1 day ago</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-base text-gray-900">Failed login attempt detected for user "admin@example.com"</p>
                        <p class="text-sm text-gray-500">2 days ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Trail Section -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="card-title mb-2.5">Audit Trail</h2>
                    <p class="text-base text-gray-600">Comprehensive tracking of all system activities and changes</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-select.styled 
                        wire:model="auditFilter"
                        :options="[
                            ['label' => 'All Activities', 'value' => 'all'],
                            ['label' => 'User Actions', 'value' => 'user'],
                            ['label' => 'System Events', 'value' => 'system'],
                            ['label' => 'Security Events', 'value' => 'security'],
                            ['label' => 'Admin Actions', 'value' => 'admin']
                        ]"
                        select="label:label|value:value"
                        placeholder="Filter activities" 
                        class="w-40" />
                    <x-button color="blue" class="text-base" wire:click="exportAuditTrail">
                        <span class="icon-[tabler--download] w-4 h-4 mr-2"></span>
                        Export
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Audit Trail Filters -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="flex items-center space-x-2">
                    <span class="text-base font-medium text-gray-700">Date Range:</span>
                    <x-select.styled 
                        wire:model="dateRange"
                        :options="[
                            ['label' => 'Today', 'value' => 'today'],
                            ['label' => 'Last 7 days', 'value' => 'week'],
                            ['label' => 'Last 30 days', 'value' => 'month'],
                            ['label' => 'Custom Range', 'value' => 'custom']
                        ]"
                        select="label:label|value:value"
                        placeholder="Select range" 
                        class="w-36" />
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-base font-medium text-gray-700">User:</span>
                    <x-select.styled 
                        wire:model="userFilter"
                        :options="[
                            ['label' => 'All Users', 'value' => 'all'],
                            ['label' => 'Izzat Saifullah', 'value' => '1'],
                            ['label' => 'Ahmed Arabee', 'value' => '2'],
                            ['label' => 'hello world', 'value' => '3']
                        ]"
                        select="label:label|value:value"
                        placeholder="Select user" 
                        class="w-40" />
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-base font-medium text-gray-700">Action:</span>
                    <x-select.styled 
                        wire:model="actionFilter"
                        :options="[
                            ['label' => 'All Actions', 'value' => 'all'],
                            ['label' => 'Create', 'value' => 'create'],
                            ['label' => 'Update', 'value' => 'update'],
                            ['label' => 'Delete', 'value' => 'delete'],
                            ['label' => 'Login', 'value' => 'login']
                        ]"
                        select="label:label|value:value"
                        placeholder="Select action" 
                        class="w-32" />
                </div>
                <div class="flex items-center justify-end">
                    <x-button color="gray" outline class="text-base" wire:click="resetAuditFilters">
                        Reset Filters
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Audit Trail Content -->
        <div class="p-6">
            <!-- Audit Trail Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="icon-[tabler--activity] text-blue-600 w-5 h-5 mr-3"></span>
                        <div>
                            <p class="text-base font-semibold text-blue-900">{{ $auditStats['total_activities'] ?? 1247 }}</p>
                            <p class="text-sm text-blue-700">Total Activities</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="icon-[tabler--user-check] text-green-600 w-5 h-5 mr-3"></span>
                        <div>
                            <p class="text-base font-semibold text-green-900">{{ $auditStats['user_actions'] ?? 892 }}</p>
                            <p class="text-sm text-green-700">User Actions</p>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="icon-[tabler--settings] text-yellow-600 w-5 h-5 mr-3"></span>
                        <div>
                            <p class="text-base font-semibold text-yellow-900">{{ $auditStats['system_events'] ?? 213 }}</p>
                            <p class="text-sm text-yellow-700">System Events</p>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="icon-[tabler--shield-exclamation] text-red-600 w-5 h-5 mr-3"></span>
                        <div>
                            <p class="text-base font-semibold text-red-900">{{ $auditStats['security_events'] ?? 12 }}</p>
                            <p class="text-sm text-red-700">Security Events</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audit Trail Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Timestamp
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Resource
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                IP Address
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($auditTrail ?? [] as $audit)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                {{ $audit['timestamp'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="{{ $audit['user_avatar'] }}" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-900">{{ $audit['user_name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $audit['user_role'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionColor = match($audit['action_type']) {
                                        'create' => 'green',
                                        'update' => 'blue',
                                        'delete' => 'red',
                                        'login' => 'purple',
                                        default => 'gray'
                                    };
                                @endphp
                                <x-badge text="{{ ucfirst($audit['action_type']) }}" color="{{ $actionColor }}" sm />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                {{ $audit['resource'] }}
                            </td>
                            <td class="px-6 py-4 text-base text-gray-900">
                                {{ $audit['details'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                {{ $audit['ip_address'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColor = match($audit['status']) {
                                        'success' => 'green',
                                        'failed' => 'red',
                                        default => 'yellow'
                                    };
                                @endphp
                                <x-badge text="{{ ucfirst($audit['status']) }}" color="{{ $statusColor }}" sm />
                            </td>
                        </tr>
                        @empty
                        <!-- Sample Audit Trail Data -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                2025-08-11 14:30:25
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="{{ asset('assets/img/avatars/avatar1.jpeg') }}" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-900">Ahmed Arabee</div>
                                        <div class="text-sm text-gray-500">Basic User</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Create" color="green" sm />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                Project
                            </td>
                            <td class="px-6 py-4 text-base text-gray-900">
                                Created new project "Mobile App Development"
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                192.168.1.105
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Success" color="green" sm />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                2025-08-11 13:45:12
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="{{ asset('assets/img/avatars/avatar2.jpeg') }}" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-900">Izzat Saifullah</div>
                                        <div class="text-sm text-gray-500">Super Admin</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Update" color="blue" sm />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                System Settings
                            </td>
                            <td class="px-6 py-4 text-base text-gray-900">
                                Modified system notification settings
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                192.168.1.100
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Success" color="green" sm />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                2025-08-11 12:20:08
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="{{ asset('assets/img/avatars/avatar3.jpeg') }}" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-900">Unknown User</div>
                                        <div class="text-sm text-gray-500">-</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Login" color="purple" sm />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                Authentication
                            </td>
                            <td class="px-6 py-4 text-base text-gray-900">
                                Failed login attempt for "admin@example.com"
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                87.251.74.123
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Failed" color="red" sm />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                2025-08-11 11:15:33
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="{{ asset('assets/img/avatars/avatar4.jpeg') }}" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-900">hello world</div>
                                        <div class="text-sm text-gray-500">Admin</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Delete" color="red" sm />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                Task
                            </td>
                            <td class="px-6 py-4 text-base text-gray-900">
                                Deleted task "Old legacy code cleanup"
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                192.168.1.102
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge text="Success" color="green" sm />
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="flex items-center text-base text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">247</span> results
                </div>
                <div class="flex items-center space-x-2">
                    <x-button color="gray" outline class="text-base">
                        <span class="icon-[tabler--chevron-left] w-4 h-4 mr-1"></span>
                        Previous
                    </x-button>
                    <div class="flex items-center space-x-1">
                        <button class="px-3 py-2 text-base font-medium text-white bg-blue-600 rounded-md">1</button>
                        <button class="px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">2</button>
                        <button class="px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">3</button>
                        <span class="px-3 py-2 text-base text-gray-500">...</span>
                        <button class="px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">25</button>
                    </div>
                    <x-button color="gray" outline class="text-base">
                        Next
                        <span class="icon-[tabler--chevron-right] w-4 h-4 ml-1"></span>
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>


