<div x-init="$wire.dispatch('loadData-team-role-view')" class="space-y-6">
    <!-- Enhanced Filters Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Members</label>
                    <x-input wire:model.live.debounce.300ms="search" 
                             placeholder="Search by name or email..." 
                             class="w-full" />
                </div>

                <!-- Team Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Team</label>
                    <x-select.styled 
                        wire:model.live="selectedTeam"
                        :options="[
                            ['label' => 'All Teams', 'value' => ''],
                            ...collect($teams)->map(fn($team) => ['label' => $team->name, 'value' => $team->id])->toArray()
                        ]"
                        select="label:label|value:value"
                        placeholder="All Teams" />
                </div>

                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Role</label>
                    <x-select.styled 
                        wire:model.live="selectedRole"
                        :options="[
                            ['label' => 'All Roles', 'value' => ''],
                            ...collect($roles)->map(fn($role) => ['label' => str_replace('_', ' ', ucwords($role->name, '_')), 'value' => $role->id])->toArray(),
                            ['label' => 'No Role Assigned', 'value' => 'none']
                        ]"
                        select="label:label|value:value"
                        placeholder="All Roles" />
                </div>
            </div>

            <!-- Results Info -->
            <div class="text-sm text-gray-500">
                Showing {{ $users->count() }} of {{ $users->total() }} members
            </div>
        </div>
    </div>

    <!-- Enhanced Members Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Team Members</h3>
            <p class="text-sm text-gray-600 mt-1">Manage team members and their roles</p>
        </div>

        @if($users->count() > 0)
            <!-- Table Header -->
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <div class="grid grid-cols-7 gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div>Member</div>
                    <div>Email</div>
                    <div>Team</div>
                    <div>Role</div>
                    <div>Joined</div>
                    <div>Last Active</div>
                    <div>Actions</div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-gray-200">
                @foreach($users as $user)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="grid grid-cols-7 gap-4 items-center">
                            <!-- Member Info -->
                            <div class="flex items-center space-x-3">
                                <x-avatar sm :text="substr($user->name, 0, 2)" 
                                         class="bg-blue-100 text-blue-600 font-medium" />
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>

                            <!-- Team -->
                            <div>
                                @if($user->team)
                                    <x-badge text="{{ $user->team_name }}" color="blue" light />
                                @else
                                    <x-badge text="No Team" color="gray" light />
                                @endif
                            </div>

                            <!-- Role -->
                            <div>
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        @php
                                            $roleColor = match($role->name) {
                                                'admin' => 'purple',
                                                'super_admin' => 'red',
                                                default => 'green'
                                            };
                                            $roleText = str_replace('_', ' ', ucwords($role->name, '_'));
                                        @endphp
                                        <x-badge 
                                            text="{{ $roleText }}"
                                            color="{{ $roleColor }}"
                                            light 
                                            class="mr-1" />
                                    @endforeach
                                @else
                                    <x-badge text="No Role" color="gray" light />
                                @endif
                            </div>

                            <!-- Joined Date -->
                            <div>
                                <p class="text-sm text-gray-600">{{ $user->member_created }}</p>
                            </div>

                            <!-- Last Active -->
                            <div>
                                <p class="text-sm text-gray-600">{{ $user->last_active_at }}</p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <x-button.circle sm color="slate" icon="pencil"
                                    wire:click.prevent="$dispatch('loadUser', { userId: {{ $user->id }} })"
                                    title="Edit Member" />
                                <x-button.circle sm color="red" icon="trash"
                                    wire:click="$dispatch('delete-team', { userId: '{{ $user->id }}' })"
                                    title="Delete Member" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-1m-2-3a3 3 0 11-6 0m3 7H9a3 3 0 00-3 3v2h5.5"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No team members found</h3>
                <p class="text-gray-600 mb-6">
                    @if($search || $selectedTeam || $selectedRole)
                        Try adjusting your filters or search criteria.
                    @else
                        Get started by adding your first team member.
                    @endif
                </p>
                @if(!$search && !$selectedTeam && !$selectedRole)
                    <x-button color="blue" x-on:click="$modalOpen('modal-create')">
                        Add First Member
                    </x-button>
                @endif
            </div>
        @endif
    </div>

    <!-- Simple loading indicator -->
    <div wire:loading.class="opacity-50" wire:target="search,selectedTeam,selectedRole,loadData">
        <!-- Content fades while loading -->
    </div>
</div>