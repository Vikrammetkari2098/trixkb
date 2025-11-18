<div wire:init="loadData">
    @if($tab === 'stats')
        <!-- Meeting Statistics Dashboard -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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

            <!-- Actual Statistics -->
            <div wire:loading.remove>
                <!-- Today's Meetings -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <span class="icon-[tabler--calendar-time] text-blue-600 w-6 h-6"></span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-600">Today</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $meetingStats['todays_meetings'] ?? 0 }}</p>
                                <p class="text-base text-blue-600">meetings scheduled</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div wire:loading.remove>
                <!-- This Week -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <span class="icon-[tabler--calendar-week] text-green-600 w-6 h-6"></span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-600">This Week</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $meetingStats['this_week_meetings'] ?? 0 }}</p>
                                <p class="text-base text-green-600">total meetings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div wire:loading.remove>
                <!-- Upcoming (Next 7 Days) -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <span class="icon-[tabler--clock] text-purple-600 w-6 h-6"></span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-600">Upcoming</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $meetingStats['upcoming_meetings'] ?? 0 }}</p>
                                <p class="text-base text-purple-600">next 7 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div wire:loading.remove>
                <!-- This Month -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-orange-100 rounded-lg">
                                    <span class="icon-[tabler--calendar-month] text-orange-600 w-6 h-6"></span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-600">This Month</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $meetingStats['this_month_meetings'] ?? 0 }}</p>
                                <p class="text-base text-orange-600">total meetings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($tab === 'current')
        <!-- Current Meetings Tab -->
        <div class="space-y-8">
            @if($thisWeekMeetings->count() > 0 || !$isReady)
                <!-- This Week Section -->
                <div>
                    <!-- Section Header -->
                    <div wire:loading>
                        <div class="skeleton skeleton-animated h-6 w-32 mb-6 bg-gray-200"></div>
                    </div>
                    <div wire:loading.remove>
                        @if($isReady)
                            <div class="divider divider-dotted text-lg font-semibold text-gray-700 dark:text-gray-300">This Week</div>
                        @endif
                    </div>
                    
                    <div class="grid gap-4 mt-6">
                        <!-- Loading skeleton for meetings -->
                        <div wire:loading class="contents">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="card mb-4">
                                    <div class="card-body p-6">
                                        <div class="flex items-start justify-between gap-6">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="skeleton skeleton-animated h-6 w-48 bg-gray-200"></div>
                                                    <div class="skeleton skeleton-animated h-5 w-20 rounded bg-gray-200"></div>
                                                </div>
                                                <div class="skeleton skeleton-animated h-4 w-full mb-4 bg-gray-200"></div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    @for ($j = 0; $j < 4; $j++)
                                                        <div class="flex items-center gap-3">
                                                            <div class="skeleton skeleton-animated w-5 h-5 rounded bg-gray-200"></div>
                                                            <div class="skeleton skeleton-animated h-4 w-24 bg-gray-200"></div>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="skeleton skeleton-animated h-3 w-64 bg-gray-200"></div>
                                            </div>
                                            <div class="flex flex-col gap-3">
                                                <div class="skeleton skeleton-animated h-8 w-28 rounded bg-gray-200"></div>
                                                <div class="skeleton skeleton-animated h-8 w-20 rounded bg-gray-200"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        
                        <!-- Actual meetings -->
                        <div wire:loading.remove class="contents">
                            @if($isReady)
                                @foreach($thisWeekMeetings as $meeting)
                                    @include('partials.meeting-card', ['meeting' => $meeting])
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($thisMonthMeetings->count() > 0 || !$isReady)
                <!-- This Month Section -->
                <div>
                    <!-- Section Header -->
                    <div wire:loading>
                        <div class="skeleton skeleton-animated h-6 w-32 mb-6 bg-gray-200"></div>
                    </div>
                    <div wire:loading.remove>
                        @if($isReady)
                            <div class="divider divider-dotted text-lg font-semibold text-gray-700 dark:text-gray-300">This Month</div>
                        @endif
                    </div>
                    
                    <div class="grid gap-4 mt-6">
                        <!-- Loading skeleton for meetings -->
                        <div wire:loading class="contents">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="card mb-4">
                                    <div class="card-body p-6">
                                        <div class="flex items-start justify-between gap-6">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="skeleton skeleton-animated h-6 w-48 bg-gray-200"></div>
                                                    <div class="skeleton skeleton-animated h-5 w-20 rounded bg-gray-200"></div>
                                                </div>
                                                <div class="skeleton skeleton-animated h-4 w-full mb-4 bg-gray-200"></div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    @for ($j = 0; $j < 4; $j++)
                                                        <div class="flex items-center gap-3">
                                                            <div class="skeleton skeleton-animated w-5 h-5 rounded bg-gray-200"></div>
                                                            <div class="skeleton skeleton-animated h-4 w-24 bg-gray-200"></div>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="skeleton skeleton-animated h-3 w-64 bg-gray-200"></div>
                                            </div>
                                            <div class="flex flex-col gap-3">
                                                <div class="skeleton skeleton-animated h-8 w-28 rounded bg-gray-200"></div>
                                                <div class="skeleton skeleton-animated h-8 w-20 rounded bg-gray-200"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        
                        <!-- Actual meetings -->
                        <div wire:loading.remove class="contents">
                            @if($isReady)
                                @foreach($thisMonthMeetings as $meeting)
                                    @include('partials.meeting-card', ['meeting' => $meeting])
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($futureMeetings->count() > 0 || !$isReady)
                <!-- Future Meetings Section -->
                <div>
                    <!-- Section Header -->
                    <div wire:loading>
                        <div class="skeleton skeleton-animated h-6 w-40 mb-6 bg-gray-200"></div>
                    </div>
                    <div wire:loading.remove>
                        @if($isReady)
                            <div class="divider divider-dotted text-lg font-semibold text-gray-700 dark:text-gray-300">Beyond This Month</div>
                        @endif
                    </div>
                    
                    <div class="grid gap-4 mt-6">
                        <!-- Loading skeleton for meetings -->
                        <div wire:loading class="contents">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="card mb-4">
                                    <div class="card-body p-6">
                                        <div class="flex items-start justify-between gap-6">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="skeleton skeleton-animated h-6 w-48 bg-gray-200"></div>
                                                    <div class="skeleton skeleton-animated h-5 w-20 rounded bg-gray-200"></div>
                                                </div>
                                                <div class="skeleton skeleton-animated h-4 w-full mb-4 bg-gray-200"></div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    @for ($j = 0; $j < 4; $j++)
                                                        <div class="flex items-center gap-3">
                                                            <div class="skeleton skeleton-animated w-5 h-5 rounded bg-gray-200"></div>
                                                            <div class="skeleton skeleton-animated h-4 w-24 bg-gray-200"></div>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="skeleton skeleton-animated h-3 w-64 bg-gray-200"></div>
                                            </div>
                                            <div class="flex flex-col gap-3">
                                                <div class="skeleton skeleton-animated h-8 w-28 rounded bg-gray-200"></div>
                                                <div class="skeleton skeleton-animated h-8 w-20 rounded bg-gray-200"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        
                        <!-- Actual meetings -->
                        <div wire:loading.remove class="contents">
                            @if($isReady)
                                @foreach($futureMeetings as $meeting)
                                    @include('partials.meeting-card', ['meeting' => $meeting])
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Empty State -->
            <div wire:loading.remove>
                @if($isReady && $thisWeekMeetings->count() === 0 && $thisMonthMeetings->count() === 0 && $futureMeetings->count() === 0)
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No upcoming meetings</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new meeting.</p>
                    </div>
                @endif
            </div>
        </div>

    @else
        <!-- Past Meetings Tab -->
        <div class="space-y-4">
            <!-- Loading skeleton for past meetings -->
            @for ($i = 0; $i < 5; $i++)
                <div wire:loading>
                    <div class="card mb-4">
                        <div class="card-body p-6">
                            <div class="flex items-start justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="skeleton skeleton-animated h-6 w-48 bg-gray-200"></div>
                                        <div class="skeleton skeleton-animated h-5 w-20 rounded bg-gray-200"></div>
                                    </div>
                                    <div class="skeleton skeleton-animated h-4 w-full mb-4 bg-gray-200"></div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        @for ($j = 0; $j < 4; $j++)
                                            <div class="flex items-center gap-3">
                                                <div class="skeleton skeleton-animated w-5 h-5 rounded bg-gray-200"></div>
                                                <div class="skeleton skeleton-animated h-4 w-20 bg-gray-200"></div>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="skeleton skeleton-animated h-3 w-64 bg-gray-200"></div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <div class="skeleton skeleton-animated h-8 w-32 rounded bg-gray-200"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

            <!-- Actual Past Meetings -->
            <div wire:loading.remove class="contents">
                @if($pastMeetings->count() > 0)
                    @foreach($pastMeetings as $meeting)
                        @include('partials.meeting-card', ['meeting' => $meeting, 'isPast' => true])
                    @endforeach
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $pastMeetings->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No past meetings</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Your meeting history will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
