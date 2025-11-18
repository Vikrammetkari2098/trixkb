<div x-init="$wire.dispatch('loadData-task-list')" class="space-y-6 relative">
    <!-- List Content -->
    <div class="space-y-6">
        <!-- Filters Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- PROJECT FILTER --}}
            @if ($context === 'global')
                <div class="md:col-span-2 lg:col-span-2">
                    <h4 class="text-base font-medium text-gray-700 mb-2">Filter by Project</h4>
                    <div class="filter">
                        <input class="btn filter-reset" type="radio" name="project-filter" aria-label="All Projects"
                            @click="$wire.set('selectedProject', '')" :checked="$wire.selectedProject === ''" />
                        @foreach($projects as $project)
                            <input type="radio" class="btn" name="project-filter" aria-label="{{ $project['title'] }}"
                                @click="$wire.set('selectedProject', '{{ $project['id'] }}')"
                                :checked="$wire.selectedProject === '{{ $project['id'] }}'" />
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- TEAM FILTER (First Column) --}}
            @if ($context === 'project')
                <div>
                    <h4 class="text-base font-medium text-gray-700 mb-2">Filter by Team</h4>
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
            @endif

            {{-- STATUS FILTER --}}
            <div class="{{ $context === 'global' ? 'md:col-span-2 lg:col-span-1' : '' }}">
                <h4 class="text-base font-medium text-gray-700 mb-2">Filter by Status</h4>
                <div class="filter">
                    <input class="btn filter-reset" type="radio" name="task-status" aria-label="All Tasks"
                        wire:click="$set('status', 'all')" :checked="$wire.status === 'all'" />
                    <input class="btn" type="radio" name="task-status" aria-label="To Do"
                        wire:click="$set('status', 'todo')" :checked="$wire.status === 'todo'" />
                    <input class="btn" type="radio" name="task-status" aria-label="In Progress"
                        wire:click="$set('status', 'progress')" :checked="$wire.status === 'progress'" />
                    <input class="btn" type="radio" name="task-status" aria-label="In Review"
                        wire:click="$set('status', 'review')" :checked="$wire.status === 'review'" />
                    <input class="btn" type="radio" name="task-status" aria-label="Completed"
                        wire:click="$set('status', 'completed')" :checked="$wire.status === 'completed'" />
                </div>
            </div>

            {{-- USER FILTER (Third Column) --}}
            @if ($context === 'project')
                <div>
                    <x-select.styled label="Filter by User" 
                        :options="array_merge([['name' => 'All Users', 'id' => '']], collect($users)->map(fn($user) => ['name' => $user['name'], 'id' => $user['id']])->toArray())" 
                        select="label:name|value:id"
                        wire:model.live="selectedUser" 
                        id="user" 
                        placeholder="Select user..." />
                </div>
            @endif
        </div>

        <!-- Single Dynamic Table -->
        <div>
            <x-table :headers="$headers" :rows="$tasks" :sort="$sort" striped filter paginate class="min-w-full">
                @interact('column_action', $row)
                <x-button.circle icon="pencil"
                    wire:click.prevent="$dispatch('loadTask', { taskId: {{ $row['id'] }}, context: '{{ $this->context }}' })" />
                <x-button.circle color="red" icon="trash"
                    wire:click="$dispatch('delete-task', { taskId: '{{ $row['id'] }}' })" />
                @endinteract
            </x-table>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading class="bg-base-100/50 absolute start-0 top-0 size-full"></div>
    <div wire:loading class="absolute start-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform">
        <span class="loading loading-spinner loading-lg text-primary"></span>
    </div>
</div>