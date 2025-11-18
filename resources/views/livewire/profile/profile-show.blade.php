<div class="space-y-6" wire:init="loadData">
    @if(!$isReady)
        <div class="space-y-6">
            <!-- Header Skeleton -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center space-x-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full animate-pulse"></div>
                    <div class="flex-1">
                        <div class="h-6 bg-gray-200 rounded w-48 mb-2 animate-pulse"></div>
                        <div class="h-4 bg-gray-200 rounded w-32 mb-2 animate-pulse"></div>
                        <div class="h-4 bg-gray-200 rounded w-40 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- Statistics Skeleton -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="h-8 bg-gray-200 rounded w-16 mb-2 animate-pulse"></div>
                        <div class="h-4 bg-gray-200 rounded w-24 animate-pulse"></div>
                    </div>
                @endfor
            </div>
        </div>
    @else
        @if($user)
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                        <div class="relative">
                            <img src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('assets/img/avatars/avatar5.jpeg') }}"
                                 alt="Profile Photo"
                                 class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold mb-1">{{ $user->name }}</h1>
                            <p class="text-blue-100 mb-2">{{ $user->email }}</p>
                            
                            @php
                                $userRole = $user->roles->first();
                                $roleName = $userRole ? str_replace('_', ' ', ucwords($userRole->name, '_')) : 'No Role';
                            @endphp
                            <div class="flex flex-wrap items-center gap-2">
                                <x-badge text="{{ $roleName }}" color="light" class="bg-white/20 text-white border-white/30" />
                                @if($user->phone)
                                    <span class="text-blue-100 text-sm">📞 {{ $user->phone }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $statistics['completion_rate'] ?? 0 }}%</div>
                            <div class="text-blue-100 text-sm">Completion Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $statistics['projects_count'] ?? 0 }}</div>
                            <div class="text-gray-600 text-sm">Total Projects</div>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <span class="icon-[tabler--folder] text-blue-600 text-xl"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $statistics['tasks_completed'] ?? 0 }}</div>
                            <div class="text-gray-600 text-sm">Tasks Completed</div>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <span class="icon-[tabler--check] text-green-600 text-xl"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $statistics['tasks_assigned'] ?? 0 }}</div>
                            <div class="text-gray-600 text-sm">Tasks Assigned</div>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <span class="icon-[tabler--list-check] text-purple-600 text-xl"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $statistics['teams_count'] ?? 0 }}</div>
                            <div class="text-gray-600 text-sm">Team Memberships</div>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-full">
                            <span class="icon-[tabler--users] text-orange-600 text-xl"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Skill Badges & Teams -->
                <div class="space-y-6">
                    <!-- Skill Badges -->
                    @if(count($skillBadges) > 0)
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="icon-[tabler--award] text-yellow-500 mr-2"></span>
                                Achievements
                            </h3>
                            <div class="space-y-3">
                                @foreach($skillBadges as $badge)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="p-2 bg-{{ $badge['color'] }}-100 rounded-full">
                                            <span class="icon-[{{ $badge['icon'] }}] text-{{ $badge['color'] }}-600"></span>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $badge['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Team Memberships -->
                    @if(count($teamMemberships) > 0)
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="icon-[tabler--users] text-blue-500 mr-2"></span>
                                Team Memberships
                            </h3>
                            <div class="space-y-3">
                                @foreach($teamMemberships as $team)
                                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-medium text-gray-900">{{ $team['name'] }}</h4>
                                            <x-badge text="{{ $team['role'] }}" color="{{ $team['color'] }}" />
                                        </div>
                                        @if($team['description'])
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($team['description'], 60) }}</p>
                                        @endif
                                        <div class="text-xs text-gray-500">
                                            {{ $team['members_count'] }} member{{ $team['members_count'] != 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="icon-[tabler--activity] text-green-500 mr-2"></span>
                            Recent Activity
                        </h3>
                        
                        @if(count($recentActivities) > 0)
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                                        <div class="p-2 bg-{{ $activity['color'] }}-100 rounded-full mt-1">
                                            <span class="icon-[{{ $activity['icon'] }}] text-{{ $activity['color'] }}-600 text-sm"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                                            @if($activity['project_name'])
                                                <p class="text-xs text-gray-600 mt-1">
                                                    Project: <span class="font-medium">{{ $activity['project_name'] }}</span>
                                                </p>
                                            @endif
                                            @if($activity['task_name'])
                                                <p class="text-xs text-gray-600 mt-1">
                                                    Task: <span class="font-medium">{{ $activity['task_name'] }}</span>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 whitespace-nowrap">
                                            {{ $activity['time_ago'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <span class="icon-[tabler--activity] text-gray-300 text-3xl mb-2 block"></span>
                                <p class="text-gray-500">No recent activity found</p>
                                <p class="text-gray-400 text-sm mt-1">Start working on projects to see your activity here</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Performance Chart Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="icon-[tabler--chart-line] text-purple-500 mr-2"></span>
                    Performance Overview
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Task Completion Progress -->
                    <div class="text-center">
                        <div class="relative inline-flex items-center justify-center w-24 h-24 mb-4">
                            <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                <path class="text-green-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $statistics['completion_rate'] ?? 0 }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                            </svg>
                            <span class="absolute text-lg font-bold text-gray-900">{{ $statistics['completion_rate'] ?? 0 }}%</span>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Task Completion</p>
                        <p class="text-xs text-gray-500">Overall performance rate</p>
                    </div>

                    <!-- Active vs Completed Projects -->
                    <div class="text-center">
                        <div class="flex justify-center space-x-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $statistics['active_projects'] ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Active</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ ($statistics['projects_count'] ?? 0) - ($statistics['active_projects'] ?? 0) }}</div>
                                <div class="text-xs text-gray-500">Completed</div>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Projects Status</p>
                        <p class="text-xs text-gray-500">Current workload distribution</p>
                    </div>

                    <!-- Team Collaboration -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">{{ $statistics['teams_count'] ?? 0 }}</div>
                        <p class="text-sm font-medium text-gray-900">Teams Joined</p>
                        <p class="text-xs text-gray-500">Collaboration level</p>
                        @if($statistics['teams_count'] > 0)
                            <div class="mt-2">
                                <x-badge text="Team Player" color="purple" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <span class="icon-[tabler--user-x] text-gray-300 text-4xl mb-4 block"></span>
                <p class="text-gray-500 text-lg">User data not available</p>
                <p class="text-gray-400">Please reload the page or try again</p>
            </div>
        @endif
    @endif
</div>
