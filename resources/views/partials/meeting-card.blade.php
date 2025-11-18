@php
    $isPastProp = $isPast ?? false;
    $isActive = $meeting->is_active ?? false;
    $meetingPast = $meeting->is_past ?? false;
    $showPastButton = $isPastProp || $meetingPast;
    
    // Status configuration with TallStackUI colors
    $statusConfig = [
        1 => ['name' => 'Confirmed', 'color' => 'green', 'icon' => 'tabler--check-circle'],
        2 => ['name' => 'Pending', 'color' => 'amber', 'icon' => 'tabler--clock'],
        3 => ['name' => 'Cancelled', 'color' => 'red', 'icon' => 'tabler--x-circle']
    ];
    
    $statusId = $meeting->status_id ?? ($meeting->status === 'confirmed' ? 1 : ($meeting->status === 'cancelled' ? 3 : 2));
    $currentStatus = $statusConfig[$statusId] ?? $statusConfig[2];
    
    // Meeting type configuration with modern styling
    $typeConfig = [
        1 => ['name' => 'In Person', 'icon' => 'tabler--users', 'color' => 'text-blue-600', 'bgColor' => 'bg-blue-50'],
        2 => ['name' => 'Online', 'icon' => 'tabler--device-desktop', 'color' => 'text-purple-600', 'bgColor' => 'bg-purple-50'],
        3 => ['name' => 'Hybrid', 'icon' => 'tabler--device-tablet', 'color' => 'text-indigo-600', 'bgColor' => 'bg-indigo-50']
    ];
    $currentType = $typeConfig[$meeting->meeting_type_id] ?? $typeConfig[2];
    
    // Platform configuration with brand colors
    $platformConfig = [
        'Zoom' => ['icon' => 'simple-icons--zoom', 'color' => 'text-blue-500', 'bgColor' => 'bg-blue-50'],
        'Microsoft Teams' => ['icon' => 'simple-icons--microsoftteams', 'color' => 'text-blue-600', 'bgColor' => 'bg-blue-50'],
        'Google Meet' => ['icon' => 'simple-icons--googlemeet', 'color' => 'text-green-600', 'bgColor' => 'bg-green-50'],
        'Skype' => ['icon' => 'simple-icons--skype', 'color' => 'text-blue-400', 'bgColor' => 'bg-blue-50'],
        'Other' => ['icon' => 'tabler--device-desktop', 'color' => 'text-gray-600', 'bgColor' => 'bg-gray-50']
    ];
    
    $platformName = $meeting->platform?->name ?? 'Other';
    $platform = $platformConfig[$platformName] ?? $platformConfig['Other'];
    
    // Time calculations
    $now = now();
    $startTime = $meeting->start_time;
    $endTime = $meeting->end_time;
    $isUpcoming = $startTime->isAfter($now);
    $isLive = $startTime->isPast() && $endTime->isFuture();
    $isPast = $endTime->isPast();
    
    // Time remaining or elapsed
    $timeText = '';
    if ($isUpcoming) {
        $timeText = 'Starts ' . $startTime->diffForHumans();
    } elseif ($isLive) {
        $timeText = 'Live now • Ends ' . $endTime->diffForHumans();
    } else {
        $timeText = 'Ended ' . $endTime->diffForHumans();
    }
@endphp

<div class="group relative overflow-hidden rounded-2xl bg-white border border-gray-200 hover:border-gray-300 hover:shadow-xl transition-all duration-500 ease-out transform hover:-translate-y-1 {{ $isLive ? 'ring-2 ring-emerald-400 shadow-emerald-100' : '' }}">
    
    <!-- Gradient background accent -->
    <div class="absolute inset-0 bg-gradient-to-br from-{{ $currentStatus['color'] }}-50/30 via-transparent to-transparent"></div>
    
    <!-- Live indicator pulse -->
    @if($isLive)
        <div class="absolute top-4 right-4 flex items-center gap-2">
            <div class="relative">
                <div class="w-3 h-3 bg-emerald-500 rounded-full animate-ping absolute"></div>
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
            </div>
            <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2 py-1 rounded-full">LIVE</span>
        </div>
    @endif
    
    <div class="relative p-6">
        <!-- Status Badge -->
        <div class="flex items-start justify-between mb-4">
            <x-badge 
                :text="$currentStatus['name']" 
                :color="$currentStatus['color']" 
                sm 
            />
            
            <!-- Quick actions dropdown -->
            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <x-button.circle size="sm" color="slate" variant="ghost">
                    <span class="icon-[tabler--dots] size-4"></span>
                </x-button.circle>
            </div>
        </div>

        <!-- Meeting Title & Description -->
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors duration-300">
                {{ $meeting->title }}
            </h3>
            @if($meeting->description)
                <p class="text-gray-600 text-sm line-clamp-2 mb-2">{{ $meeting->description }}</p>
            @endif
            @if($meeting->agenda)
                <div class="text-xs text-gray-500 bg-gray-50 rounded-lg p-2 line-clamp-1">
                    <span class="font-medium">Agenda:</span> {{ $meeting->agenda }}
                </div>
            @endif
        </div>

        <!-- Meeting Details Grid -->
        <div class="space-y-4 mb-6">
            <!-- Date & Time Row -->
            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-orange-100">
                        <span class="icon-[tabler--calendar-time] size-5 text-orange-600"></span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">{{ $startTime->format('M j, Y') }}</div>
                        <div class="text-sm text-gray-600">{{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs font-medium {{ $isLive ? 'text-emerald-600' : ($isUpcoming ? 'text-blue-600' : 'text-gray-500') }}">
                        {{ $timeText }}
                    </div>
                </div>
            </div>

            <!-- Platform & Type Row -->
            <div class="grid grid-cols-2 gap-3">
                <!-- Platform -->
                <div class="flex items-center gap-3 p-3 rounded-xl {{ $platform['bgColor'] }} border border-gray-100">
                    <div class="p-2 rounded-lg bg-white/70">
                        <span class="icon-[{{ $platform['icon'] }}] size-4 {{ $platform['color'] }}"></span>
                    </div>
                    <div>
                        <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Platform</div>
                        <div class="font-semibold text-gray-900 text-sm">{{ $platformName }}</div>
                    </div>
                </div>

                <!-- Meeting Type -->
                <div class="flex items-center gap-3 p-3 rounded-xl {{ $currentType['bgColor'] }} border border-gray-100">
                    <div class="p-2 rounded-lg bg-white/70">
                        <span class="icon-[{{ $currentType['icon'] }}] size-4 {{ $currentType['color'] }}"></span>
                    </div>
                    <div>
                        <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Type</div>
                        <div class="font-semibold text-gray-900 text-sm">{{ $currentType['name'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Participants & Project Row -->
            <div class="flex items-center justify-between p-3 rounded-xl bg-blue-50 border border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-blue-100">
                        <span class="icon-[tabler--users-group] size-5 text-blue-600"></span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">
                            {{ $meeting->participants_count ?? 0 }} Participants
                            @if($meeting->max_participants)
                                <span class="text-gray-500">/ {{ $meeting->max_participants }}</span>
                            @endif
                        </div>
                        @if($meeting->project)
                            <div class="text-sm text-gray-600">Project: {{ $meeting->project->title }}</div>
                        @endif
                        @if($meeting->requires_approval)
                            <div class="text-xs text-amber-600 bg-amber-100 px-2 py-1 rounded-full inline-block mt-1">
                                <span class="icon-[tabler--shield-check] size-3 mr-1"></span>
                                Approval Required
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Participant avatars -->
                @if($meeting->users && $meeting->users->count() > 0)
                    <div class="flex -space-x-2">
                        @foreach($meeting->users->take(3) as $user)
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 border-2 border-white flex items-center justify-center text-white text-xs font-semibold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endforeach
                        @if($meeting->users->count() > 3)
                            <div class="w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-gray-600 text-xs font-semibold">
                                +{{ $meeting->users->count() - 3 }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            @if($isPast)
                <x-button disabled color="slate" size="sm" class="flex-1 opacity-60">
                    <span class="icon-[tabler--clock-off] size-4 mr-2"></span>
                    Meeting Ended
                </x-button>
            @else
                @if($meeting->meeting_link)
                    <x-button 
                        color="{{ $isLive ? 'green' : 'blue' }}" 
                        size="sm" 
                        onclick="window.open('{{ $meeting->meeting_link }}', '_blank')"
                        class="flex-1 font-semibold {{ $isLive ? 'animate-pulse' : '' }}">
                        <span class="icon-[tabler--video] size-4 mr-2"></span>
                        @if($isLive) 
                            Join Live Meeting
                        @elseif($isUpcoming)
                            Join Meeting
                        @else
                            Join Now
                        @endif
                    </x-button>
                @endif
            @endif
            
            <x-button 
                color="slate" 
                variant="outline" 
                size="sm"
                x-on:click="$modalOpen('modal-edit')"
                @click="$wire.dispatch('loadData-edit-meeting', {meetingId: {{ $meeting->id }}});"
                class="font-medium">
                <span class="icon-[tabler--edit] size-4"></span>
            </x-button>
        </div>

        <!-- Meeting organizer info -->
        @if($meeting->creator)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span class="icon-[tabler--user-star] size-4"></span>
                    <span>Organized by <strong class="text-gray-900">{{ $meeting->creator->name }}</strong></span>
                </div>
            </div>
        @endif
    </div>
</div>
