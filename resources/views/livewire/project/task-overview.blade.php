<div x-init="$wire.dispatch('loadData-task-overview')" class="space-y-6 relative">
    <!-- Dashboard Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">
                    @if($context === 'project')
                        Project Task Dashboard
                    @else
                        My Task Dashboard
                    @endif
                </h2>
                <p class="text-blue-100 mt-1">Overview of task performance and progress</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">{{ $totalTasks }}</div>
                <div class="text-blue-100 text-sm">Total Tasks</div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    @if ($context === 'project')
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filters</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- TEAM FILTER --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Team</label>
                    <div class="filter">
                        <input class="btn filter-reset" type="radio" name="team-filter" aria-label="All Teams"
                            @click="$wire.set('selectedTeam', '')" :checked="$wire.selectedTeam === ''" />
                        @foreach($teams as $team)
                            <input type="radio" class="btn" name="team-filter" aria-label="{{ $team['name'] }}"
                                @click="$wire.set('selectedTeam', '{{ $team['id'] }}')"
                                :checked="$wire.selectedTeam === {{ $team['id'] }}" />
                        @endforeach
                    </div>
                </div>

                {{-- USER FILTER --}}
                <div>
                    <x-select.styled label="Filter by User" 
                        :options="array_merge([['name' => 'All Users', 'id' => '']], collect($users)->map(fn($user) => ['name' => $user['name'], 'id' => $user['id']])->toArray())" 
                        select="label:name|value:id"
                        wire:model.live="selectedUser" 
                        id="user" 
                        placeholder="Select user..." />
                </div>
            </div>
        </div>
    @endif

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Completed Tasks -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed Tasks</p>
                    <p class="text-3xl font-bold text-green-600">{{ $completedTasks }}</p>
                    <p class="text-sm text-gray-500">{{ $completionRate }}% completion rate</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">In Progress</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $progressTasks }}</p>
                    <p class="text-sm text-gray-500">Active work items</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Review</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $reviewTasks }}</p>
                    <p class="text-sm text-gray-500">Awaiting approval</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Overdue Tasks -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Overdue Tasks</p>
                    <p class="text-3xl font-bold text-red-600">{{ $overdueTasks }}</p>
                    <p class="text-sm text-gray-500">Need attention</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Insights Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- High Priority Tasks -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">High Priority</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $highPriorityTasks }}</p>
                </div>
                <div class="bg-orange-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Due Today -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Due Today</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $tasksDueToday }}</p>
                </div>
                <div class="bg-purple-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Avg Completion Time -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avg Completion</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $avgCompletionTime }} days</p>
                </div>
                <div class="bg-indigo-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                <span class="text-sm text-gray-500">Last 7 days</span>
            </div>
            
            @if($recentActivities->count() > 0)
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($activity['type'] == 1)
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    @elseif($activity['type'] == 2)
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 010 2h-1v12a3 3 0 01-3 3H8a3 3 0 01-3-3V6H4a1 1 0 010-2h3z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['title'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['assignee'] }} • {{ $activity['project'] }}</p>
                                </div>
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $activity['updated_at']->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-gray-500">No recent activities</p>
                </div>
            @endif
        </div>

        <!-- Upcoming Deadlines -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Upcoming Deadlines</h3>
                <span class="text-sm text-gray-500">Next 7 days</span>
            </div>
            
            @if($upcomingDeadlines->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingDeadlines as $deadline)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($deadline['days_left'] <= 1)
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                    @elseif($deadline['days_left'] <= 3)
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $deadline['title'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $deadline['assignee'] }} • {{ $deadline['project'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-medium 
                                    @if($deadline['days_left'] <= 1) text-red-600 
                                    @elseif($deadline['days_left'] <= 3) text-yellow-600 
                                    @else text-green-600 @endif">
                                    {{ $deadline['days_left'] == 0 ? 'Today' : $deadline['days_left'] . ' days' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $deadline['end_time']->format('M j') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">No upcoming deadlines</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Task Type Breakdown -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Task Type Breakdown</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tasks -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-blue-900">Tasks</h4>
                    <div class="bg-blue-200 p-2 rounded-full">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-blue-700">Completed</span>
                        <span class="font-semibold text-blue-900">{{ $completedTask }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-blue-700">In Progress</span>
                        <span class="font-semibold text-blue-900">{{ $progressTask }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-blue-700">Review</span>
                        <span class="font-semibold text-blue-900">{{ $reviewTask }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-blue-700">Overdue</span>
                        <span class="font-semibold text-red-600">{{ $overdueTask }}</span>
                    </div>
                </div>
            </div>

            <!-- Issues -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-red-900">Issues</h4>
                    <div class="bg-red-200 p-2 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-red-700">Completed</span>
                        <span class="font-semibold text-red-900">{{ $completedIssue }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-red-700">In Progress</span>
                        <span class="font-semibold text-red-900">{{ $progressIssue }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-red-700">Review</span>
                        <span class="font-semibold text-red-900">{{ $reviewIssue }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-red-700">Overdue</span>
                        <span class="font-semibold text-red-600">{{ $overdueIssue }}</span>
                    </div>
                </div>
            </div>

            <!-- Designs -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-purple-900">Designs</h4>
                    <div class="bg-purple-200 p-2 rounded-full">
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 010 2h-1v12a3 3 0 01-3 3H8a3 3 0 01-3-3V6H4a1 1 0 010-2h3z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-purple-700">Completed</span>
                        <span class="font-semibold text-purple-900">{{ $completedDesign }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-purple-700">In Progress</span>
                        <span class="font-semibold text-purple-900">{{ $progressDesign }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-purple-700">Review</span>
                        <span class="font-semibold text-purple-900">{{ $reviewDesign }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-purple-700">Overdue</span>
                        <span class="font-semibold text-red-600">{{ $overdueDesign }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Performance Table (Project Context Only) -->
    @if ($context === 'project')
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Team Performance</h3>
                    <p class="text-sm text-gray-500">Track task assignments and member workloads</p>
                </div>
            </div>
            <x-table :headers="$memberHeaders" :rows="$teamPerformance" striped filter paginate
                class="min-w-full" loading>
                @interact('column_action', $row)
                <x-button.circle icon="eye" color="indigo" size="sm"
                    wire:click="$dispatch('view-member-tasks', { userId: '{{ $row['id'] }}' })" />
                @endinteract
            </x-table>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div wire:loading class="bg-white/50 absolute inset-0 z-10 flex items-center justify-center">
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center space-x-3">
                <span class="loading loading-spinner loading-md text-blue-600"></span>
                <span class="text-gray-600">Loading dashboard...</span>
            </div>
        </div>
    </div>
</div>