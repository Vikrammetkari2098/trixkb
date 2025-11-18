<div wire:init="loadData" class="space-y-6">
    <!-- Welcome Header -->
    <div class="card">
        <div class="card-body">
            <!-- Loading skeleton for header -->
            <div wire:loading>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="skeleton skeleton-animated h-8 w-64 mb-2 bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-4 w-80 bg-gray-200"></div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="skeleton skeleton-animated h-6 w-16 rounded bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-6 w-20 rounded bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-8 w-20 rounded bg-gray-200"></div>
                    </div>
                </div>
            </div>
            
            <!-- Actual header content -->
            <div wire:loading.remove>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="card-title text-3xl mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="text-lg text-gray-600">Here's what's happening with your projects today</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-badge text="Online" color="green" sm />
                        @if(($teamStats['total_members'] ?? 0) > 0)
                            <x-badge text="{{ $teamStats['total_members'] }} Team{{ $teamStats['total_members'] > 1 ? 's' : '' }}" color="blue" sm />
                        @endif
                        <x-button color="gray" outline sm wire:click="refreshDashboard" class="ml-2">
                            <span class="icon-[tabler--refresh] w-4 h-4 mr-1"></span>
                            Refresh
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Loading skeletons for stats cards -->
        @for ($i = 0; $i < 4; $i++)
            <div wire:loading>
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="skeleton skeleton-animated h-12 w-12 rounded-lg bg-gray-200"></div>
                            </div>
                            <div class="ml-4">
                                <div class="skeleton skeleton-animated h-4 w-20 mb-2 bg-gray-200"></div>
                                <div class="skeleton skeleton-animated h-8 w-12 mb-2 bg-gray-200"></div>
                                <div class="skeleton skeleton-animated h-4 w-24 bg-gray-200"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor

        <!-- Actual stats cards -->
        <div wire:loading.remove>
            <!-- Tasks Completed -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <span class="icon-[tabler--check] text-green-600 w-6 h-6"></span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-medium text-gray-600">Completed</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $userStats['completed_tasks'] ?? 0 }}</p>
                            <p class="text-base text-green-600">{{ $userStats['completion_rate'] ?? 0 }}% completion rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading.remove>
            <!-- In Progress -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <span class="icon-[tabler--clock] text-blue-600 w-6 h-6"></span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-medium text-gray-600">In Progress</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $userStats['in_progress_tasks'] ?? 0 }}</p>
                            <p class="text-base text-blue-600">{{ $userStats['tasks_due_this_week'] ?? 0 }} due this week</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading.remove>
            <!-- Team Members -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <span class="icon-[tabler--users] text-purple-600 w-6 h-6"></span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-medium text-gray-600">Team Members</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $teamStats['total_members'] ?? 0 }}</p>
                            <p class="text-base text-purple-600">{{ $teamStats['online_members'] ?? 0 }} online now</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading.remove>
            <!-- Projects -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <span class="icon-[tabler--folder] text-orange-600 w-6 h-6"></span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-medium text-gray-600">Active Projects</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $projectStats['active_projects'] ?? 0 }}</p>
                            <p class="text-base text-orange-600">{{ $projectStats['ending_soon'] ?? 0 }} ending soon</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Project Progress Loading Skeleton -->
        <div wire:loading class="lg:col-span-2">
            <div class="card">
                <div class="card-body">
                    <div class="skeleton skeleton-animated h-6 w-32 mb-4 bg-gray-200"></div>
                    <div class="space-y-4">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <div class="skeleton skeleton-animated h-5 w-48 mb-2 bg-gray-200"></div>
                                        <div class="skeleton skeleton-animated h-4 w-24 bg-gray-200"></div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="skeleton skeleton-animated h-5 w-20 rounded bg-gray-200"></div>
                                        <div class="skeleton skeleton-animated h-4 w-8 bg-gray-200"></div>
                                    </div>
                                </div>
                                <div class="skeleton skeleton-animated h-2 w-full mb-3 rounded-full bg-gray-200"></div>
                                <div class="flex items-center justify-between">
                                    <div class="skeleton skeleton-animated h-4 w-32 bg-gray-200"></div>
                                    <div class="flex -space-x-2">
                                        @for ($j = 0; $j < 3; $j++)
                                            <div class="skeleton skeleton-animated w-6 h-6 rounded-full bg-gray-200"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Loading Skeletons -->
        <div wire:loading class="space-y-6">
            <!-- Quick Actions Skeleton -->
            <div class="card">
                <div class="card-body">
                    <div class="skeleton skeleton-animated h-6 w-24 mb-4 bg-gray-200"></div>
                    <div class="space-y-3">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="skeleton skeleton-animated h-10 w-full rounded bg-gray-200"></div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Today's Schedule Skeleton -->
            <div class="card">
                <div class="card-body">
                    <div class="skeleton skeleton-animated h-6 w-32 mb-4 bg-gray-200"></div>
                    <div class="space-y-3">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                <div class="skeleton skeleton-animated w-2 h-2 rounded-full bg-gray-200"></div>
                                <div class="flex-1">
                                    <div class="skeleton skeleton-animated h-4 w-32 mb-1 bg-gray-200"></div>
                                    <div class="skeleton skeleton-animated h-3 w-24 bg-gray-200"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Project Progress -->
        <div wire:loading.remove class="card lg:col-span-2">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Active Projects</h2>
                <div class="space-y-4">
                    @forelse($activeProjects as $project)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $project['title'] }}</h3>
                                    <p class="text-base text-gray-600">Due: {{ $project['due_date'] }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @php
                                        $priorityColor = match(strtolower($project['priority'])) {
                                            'high' => 'red',
                                            'medium' => 'yellow',
                                            'low' => 'gray',
                                            default => 'blue'
                                        };
                                    @endphp
                                    <x-badge text="{{ $project['priority'] }} Priority" color="{{ $priorityColor }}" sm />
                                    <span class="text-base font-medium text-gray-700">{{ $project['progress'] }}%</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                @php
                                    $progressColor = $project['progress'] >= 80 ? 'bg-green-500' : ($project['progress'] >= 50 ? 'bg-blue-500' : 'bg-yellow-500');
                                @endphp
                                <div class="{{ $progressColor }} rounded-full h-2" style="width: {{ $project['progress'] }}%"></div>
                            </div>
                            <div class="flex items-center justify-between text-base text-gray-600">
                                <span>{{ $project['completed_tasks'] }}/{{ $project['total_tasks'] }} tasks completed</span>
                                <div class="flex -space-x-2">
                                    @foreach($project['team_members'] as $member)
                                        <div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center text-white text-xs" title="{{ $member['name'] }}">
                                            {{ $member['initials'] }}
                                        </div>
                                    @endforeach
                                    @if($project['team_count'] > 3)
                                        <div class="w-6 h-6 bg-gray-500 rounded-full border-2 border-white flex items-center justify-center text-white text-xs">
                                            +{{ $project['team_count'] - 3 }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <span class="icon-[tabler--folder-x] w-12 h-12 text-gray-400 mx-auto mb-3"></span>
                            <p class="text-gray-500">No active projects found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Actual Quick Actions & Today's Schedule -->
        <div wire:loading.remove class="space-y-6">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <x-button color="blue" class="w-full">
                            <span class="icon-[tabler--plus] w-4 h-4 mr-2"></span>
                            Create New Task
                        </x-button>
                        <x-button color="green" outline class="w-full">
                            <span class="icon-[tabler--calendar-plus] w-4 h-4 mr-2"></span>
                            Schedule Meeting
                        </x-button>
                        <x-button color="purple" outline class="w-full">
                            <span class="icon-[tabler--folder-plus] w-4 h-4 mr-2"></span>
                            New Project
                        </x-button>
                        <x-button color="orange" outline class="w-full">
                            <span class="icon-[tabler--user-plus] w-4 h-4 mr-2"></span>
                            Invite Team Member
                        </x-button>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Today's Schedule</h2>
                    <div class="space-y-3">
                        @forelse($todaysMeetings as $meeting)
                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="font-medium text-base">{{ $meeting['title'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $meeting['start_time'] }} - {{ $meeting['end_time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <span class="icon-[tabler--calendar-x] w-8 h-8 text-gray-400 mx-auto mb-2"></span>
                                <p class="text-gray-500 text-sm">No meetings scheduled for today</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Task Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity Loading Skeleton -->
        <div wire:loading>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <div class="skeleton skeleton-animated h-6 w-32 bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-8 w-16 rounded bg-gray-200"></div>
                    </div>
                    <div class="space-y-4">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="flex items-start space-x-3">
                                <div class="skeleton skeleton-animated w-8 h-8 rounded-full bg-gray-200"></div>
                                <div class="flex-1">
                                    <div class="skeleton skeleton-animated h-4 w-48 mb-1 bg-gray-200"></div>
                                    <div class="skeleton skeleton-animated h-3 w-32 bg-gray-200"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Analytics Loading Skeleton -->
        <div wire:loading>
            <div class="card">
                <div class="card-body">
                    <div class="skeleton skeleton-animated h-6 w-32 mb-4 bg-gray-200"></div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        @for ($i = 0; $i < 2; $i++)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="skeleton skeleton-animated h-8 w-12 mx-auto mb-2 bg-gray-200"></div>
                                <div class="skeleton skeleton-animated h-3 w-20 mx-auto bg-gray-200"></div>
                            </div>
                        @endfor
                    </div>
                    <div class="space-y-3">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="flex items-center justify-between">
                                <div class="skeleton skeleton-animated h-3 w-20 bg-gray-200"></div>
                                <div class="flex items-center space-x-2">
                                    <div class="skeleton skeleton-animated h-2 w-20 rounded-full bg-gray-200"></div>
                                    <div class="skeleton skeleton-animated h-3 w-4 bg-gray-200"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Recent Activity -->
        <div wire:loading.remove>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="card-title text-xl">Recent Activity</h2>
                        <x-button color="gray" outline sm>View All</x-button>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentActivities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="icon-[tabler--check] text-green-600 w-4 h-4"></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-base font-medium">{{ $activity['description'] }}</p>
                                    <p class="text-sm text-gray-600">by {{ $activity['user_name'] }} • {{ $activity['created_at'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <span class="icon-[tabler--activity] w-8 h-8 text-gray-400 mx-auto mb-2"></span>
                                <p class="text-gray-500 text-sm">No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Task Analytics -->
        <div wire:loading.remove>
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Task Analytics</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ $userStats['completion_rate'] ?? 0 }}%</p>
                            <p class="text-sm text-gray-600">Completion Rate</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $userStats['total_tasks'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Total Tasks</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @php
                            $highPriorityTasks = collect($upcomingDeadlines)->where('urgency', 'high')->count();
                            $mediumPriorityTasks = collect($upcomingDeadlines)->where('urgency', 'medium')->count();
                            $lowPriorityTasks = collect($upcomingDeadlines)->where('urgency', 'low')->count();
                            $totalUpcoming = $highPriorityTasks + $mediumPriorityTasks + $lowPriorityTasks;
                        @endphp
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">High Priority</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-500 rounded-full h-2" style="width: {{ $totalUpcoming > 0 ? ($highPriorityTasks / $totalUpcoming) * 100 : 0 }}%"></div>
                                </div>
                                <span class="text-sm font-medium">{{ $highPriorityTasks }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Medium Priority</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 rounded-full h-2" style="width: {{ $totalUpcoming > 0 ? ($mediumPriorityTasks / $totalUpcoming) * 100 : 0 }}%"></div>
                                </div>
                                <span class="text-sm font-medium">{{ $mediumPriorityTasks }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Low Priority</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 rounded-full h-2" style="width: {{ $totalUpcoming > 0 ? ($lowPriorityTasks / $totalUpcoming) * 100 : 0 }}%"></div>
                                </div>
                                <span class="text-sm font-medium">{{ $lowPriorityTasks }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Deadlines & Team Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Deadlines Loading Skeleton -->
        <div wire:loading>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <div class="skeleton skeleton-animated h-6 w-40 bg-gray-200"></div>
                        <div class="skeleton skeleton-animated h-6 w-20 rounded bg-gray-200"></div>
                    </div>
                    <div class="space-y-3">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div>
                                    <div class="skeleton skeleton-animated h-4 w-32 mb-1 bg-gray-200"></div>
                                    <div class="skeleton skeleton-animated h-3 w-24 bg-gray-200"></div>
                                </div>
                                <div class="text-right">
                                    <div class="skeleton skeleton-animated h-4 w-16 mb-1 bg-gray-200"></div>
                                    <div class="skeleton skeleton-animated h-3 w-12 bg-gray-200"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Performance Loading Skeleton -->
        <div wire:loading>
            <div class="card">
                <div class="card-body">
                    <div class="skeleton skeleton-animated h-6 w-32 mb-4 bg-gray-200"></div>
                    <div class="space-y-4">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="skeleton skeleton-animated w-10 h-10 rounded-full bg-gray-200"></div>
                                    <div>
                                        <div class="skeleton skeleton-animated h-4 w-24 mb-1 bg-gray-200"></div>
                                        <div class="skeleton skeleton-animated h-3 w-32 bg-gray-200"></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="skeleton skeleton-animated h-4 w-16 mb-1 bg-gray-200"></div>
                                    <div class="skeleton skeleton-animated h-1.5 w-16 rounded-full bg-gray-200"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Upcoming Deadlines -->
        <div wire:loading.remove>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="card-title text-xl">Upcoming Deadlines</h2>
                        <x-badge text="{{ count($upcomingDeadlines) }} This Week" color="red" sm />
                    </div>
                    <div class="space-y-3">
                        @forelse($upcomingDeadlines as $deadline)
                            @php
                                $urgencyColors = [
                                    'high' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-600'],
                                    'medium' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-600'],
                                    'low' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-600']
                                ];
                                $colors = $urgencyColors[$deadline['urgency']] ?? $urgencyColors['low'];
                            @endphp
                            <div class="flex items-center justify-between p-3 {{ $colors['bg'] }} rounded-lg border {{ $colors['border'] }}">
                                <div>
                                    <p class="font-medium text-base">{{ $deadline['title'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $deadline['project_name'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-base font-medium {{ $colors['text'] }}">
                                        @if($deadline['days_until'] == 0)
                                            Today
                                        @elseif($deadline['days_until'] == 1)
                                            Tomorrow
                                        @else
                                            {{ $deadline['due_date'] }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $deadline['due_time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <span class="icon-[tabler--calendar-check] w-8 h-8 text-gray-400 mx-auto mb-2"></span>
                                <p class="text-gray-500 text-sm">No upcoming deadlines</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Team Performance -->
        <div wire:loading.remove>
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-4">Team Performance</h2>
                    <div class="space-y-4">
                        @forelse($teamMembers as $member)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium">
                                        {{ $member['initials'] }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-base">{{ $member['name'] }}</p>
                                        <p class="text-sm text-gray-600">Last active {{ $member['last_active'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-base font-medium">{{ $member['active_tasks'] }} tasks</p>
                                    <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-green-500 rounded-full h-1.5" style="width: {{ $member['performance'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <span class="icon-[tabler--users-group] w-8 h-8 text-gray-400 mx-auto mb-2"></span>
                                <p class="text-gray-500 text-sm">No team members found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
