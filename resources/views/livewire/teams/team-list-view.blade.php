<div x-init="$wire.dispatch('loadData-team-list-view')" class="space-y-6">
    <!-- Teams Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($teamStats as $team)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 overflow-hidden">
                <!-- Team Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 {{ $team['color']['bg'] }} rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ substr($team['name'], 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $team['name'] }} Team</h3>
                                <p class="text-sm text-gray-500">Created {{ $team['created_at'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Team Stats -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $team['total_members'] }}</p>
                            <p class="text-xs text-gray-500">Total</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $team['active_members'] }}</p>
                            <p class="text-xs text-gray-500">Active</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-400">{{ $team['inactive_members'] }}</p>
                            <p class="text-xs text-gray-500">Inactive</p>
                        </div>
                    </div>
                </div>

                <!-- Team Members Preview -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-700">Team Members</h4>
                        @if($team['total_members'] > 6)
                            <span class="text-xs text-gray-500">+{{ $team['total_members'] - 6 }} more</span>
                        @endif
                    </div>

                    @if(count($team['preview_members']) > 0)
                        <div class="space-y-3">
                            @foreach($team['preview_members'] as $member)
                                <div class="flex items-center space-x-3">
                                    <x-avatar sm :text="substr($member['name'], 0, 2)" 
                                             class="{{ $team['color']['light'] }} {{ $team['color']['text'] }} font-medium" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $member['name'] }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $member['email'] }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($member['roles']->count() > 0)
                                            @php
                                                $roleColor = match($member['roles']->first()->name) {
                                                    'admin' => 'purple',
                                                    'super_admin' => 'red',
                                                    default => 'blue'
                                                };
                                                $roleText = str_replace('_', ' ', ucwords($member['roles']->first()->name, '_'));
                                            @endphp
                                            <x-badge 
                                                text="{{ $roleText }}"
                                                color="{{ $roleColor }}"
                                                light />
                                        @else
                                            <x-badge text="No Role" color="gray" light />
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="text-sm text-gray-500">No members assigned</p>
                        </div>
                    @endif
                </div>

                <!-- Team Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 {{ $team['color']['bg'] }} rounded-full"></div>
                            <span class="text-xs text-gray-500">{{ $team['name'] }} Team</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <x-button.circle sm color="slate" icon="eye" title="View Team Details" />
                            <x-button.circle sm color="blue" icon="pencil" title="Edit Team" />
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-1m-2-3a3 3 0 11-6 0m3 7H9a3 3 0 00-3 3v2h5.5"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No teams found</h3>
                    <p class="text-gray-600 mb-6">Create your first team to start organizing your members.</p>
                    <x-button color="blue">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create First Team
                    </x-button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Simple loading indicator -->
    <div wire:loading.class="opacity-50" wire:target="loadData">
        <!-- Content fades while loading -->
    </div>
</div>