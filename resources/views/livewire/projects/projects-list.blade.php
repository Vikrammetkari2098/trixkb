<div wire:init="loadData">
    <!-- Filters Section -->
    <div class="card mb-6">
        <div class="card-body">
            <!-- Loading state for filters - only show during loadData (initial/CRUD reload) -->
            <div wire:loading wire:target="loadData">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div>
                            <div class="skeleton skeleton-animated h-4 w-24 mb-2 bg-gray-200"></div>
                            <div class="skeleton skeleton-animated h-10 w-full rounded bg-gray-200"></div>
                        </div>
                    @endfor
                </div>
            </div>
            
            <!-- Actual filters content -->
            <div wire:loading.remove wire:target="loadData">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Search Projects</label>
                        <div class="relative">
                            <span class="icon-[tabler--search] absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></span>
                            <input type="text" wire:model="searchTerm" wire:keyup.debounce.300ms="performSearch"
                                   class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base" 
                                   placeholder="Search by title or description...">
                        </div>
                    </div>

                <!-- Priority Filter -->
                <div>
                    <label class="block text-base font-medium text-gray-700 mb-2">Priority</label>
                    <x-select.styled 
                        wire:model="filterPriority"
                        wire:change="performFilter"
                        :options="[
                            ['label' => 'All Priorities', 'value' => ''],
                            ['label' => 'Low Priority', 'value' => '1'],
                            ['label' => 'Medium Priority', 'value' => '2'],
                            ['label' => 'High Priority', 'value' => '3']
                        ]"
                        select="label:label|value:value"
                        placeholder="Select priority" />
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-base font-medium text-gray-700 mb-2">Status</label>
                    <x-select.styled 
                        wire:model="filterStatus"
                        wire:change="performFilter"
                        :options="[
                            ['label' => 'All Status', 'value' => ''],
                            ['label' => 'Active', 'value' => 'active'],
                            ['label' => 'Overdue', 'value' => 'overdue']
                        ]"
                        select="label:label|value:value"
                        placeholder="Select status" />
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <x-button color="gray" outline wire:click="clearFilters" class="w-full">
                        <span class="icon-[tabler--filter-off] w-4 h-4 mr-2"></span>
                        Clear Filters
                    </x-button>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3">
        <!-- Loading skeletons for projects - show during loadData AND search/filter methods -->
        @for ($i = 0; $i < 6; $i++)
            <div wire:loading wire:target="loadData,performSearch,performFilter,clearFilters">
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <div class="skeleton skeleton-animated h-6 w-24 mb-2 bg-gray-200"></div>
                            </div>
                            <div class="justify-self-end flex items-center">
                                <div class="skeleton skeleton-animated h-6 w-6 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="flex gap-2 mb-4">
                            <div class="skeleton skeleton-animated h-5 w-16 rounded bg-gray-200"></div>
                            <div class="skeleton skeleton-animated h-5 w-16 rounded bg-gray-200"></div>
                        </div>
                        <div class="skeleton skeleton-animated h-4 w-full mb-4 bg-gray-200"></div>
                        <div class="mb-2 grid gap-2">
                            <div class="grid grid-cols-1 lg:grid-cols-2 items-center mb-2">
                                <div class="skeleton skeleton-animated h-4 w-20 bg-gray-200"></div>
                                <div class="skeleton skeleton-animated h-4 w-12 lg:justify-self-end bg-gray-200"></div>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 items-center">
                                <div class="skeleton skeleton-animated h-4 w-20 bg-gray-200"></div>
                                <div class="skeleton skeleton-animated h-4 w-16 lg:justify-self-end bg-gray-200"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor

        <!-- Actual projects content -->
        @if ($projects->isEmpty())
            <div wire:loading.remove wire:target="loadData,performSearch,performFilter,clearFilters" class="col-span-full">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col items-center justify-center py-16">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <span class="icon-[tabler--folder-plus] text-gray-400 w-8 h-8"></span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Projects Found</h3>
                            <p class="text-base text-gray-500 mb-6 text-center">You don't have any projects yet. Start by creating a new one!</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @foreach ($projects as $project)
                @php
                    $progress = $this->getProjectProgress($project);
                    $totalTasks = $project->tasks->count();
                    $completedTasks = $project->tasks->where('status', 4)->count();
                    $isOverdue = $project->end_time && $project->end_time < now();
                    $daysLeft = $project->end_time ? (int) ceil($project->end_time->diffInDays(now(), false)) : null;
                @endphp
                <div wire:loading.remove wire:target="loadData,performSearch,performFilter,clearFilters" wire:key="project-{{ $project->id }}">
                    <div class="card {{ $isOverdue ? 'border-l-4 border-l-red-500' : '' }} hover:shadow-lg transition-shadow duration-200">
                        <div class="card-body">
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <div>
                                    <a class="font-bold text-xl mb-1 hover:text-blue-600 transition-colors" href="{{ route('project.index', ['id' => $project->id]) }}">{{ $project->title }}</a>
                                    @if($isOverdue)
                                        <div class="flex items-center mt-1">
                                            <span class="icon-[tabler--alert-triangle] text-red-500 w-4 h-4 mr-1"></span>
                                            <span class="text-base text-red-600 font-medium">
                                                Overdue by {{ abs($daysLeft) }} days
                                            </span>
                                        </div>
                                    @elseif($daysLeft !== null && $daysLeft >= 0)
                                        <div class="flex items-center mt-1">
                                            <span class="icon-[tabler--clock] text-gray-400 w-4 h-4 mr-1"></span>
                                            <span class="text-base text-gray-600">
                                                {{ $daysLeft }} days left
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="justify-self-end flex items-center">
                                    <x-dropdown icon="ellipsis-vertical" static>
                                        <x-dropdown.items icon="pencil-square" text="Edit" x-on:click="$modalOpen('modal-update')" @click="$wire.dispatch('loadData-edit', {projectId: {{ $project->id }}});" />
                                        <x-dropdown.items icon="trash" text="Delete" @click="$wire.dispatch('delete-project', {projectId: {{ $project->id }}});" />
                                    </x-dropdown>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($project->modules->take(3) as $module)
                                        <x-badge text="{{ $module->name }}" color="{{ $module->color }}" sm />
                                    @empty
                                        <x-badge text="No modules" color="gray" sm />
                                    @endforelse
                                    @if($project->modules->count() > 3)
                                        <x-badge text="+{{ $project->modules->count() - 3 }} more" color="gray" sm />
                                    @endif
                                </div>
                            </div>
                            <p class="mb-4 text-base text-gray-600 line-clamp-2">{{ $project->description }}</p>

                            <!-- Progress Section -->
                            @if($totalTasks > 0)
                                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-base font-medium text-gray-700">Task Progress</span>
                                        <span class="text-base text-gray-600">{{ $completedTasks }}/{{ $totalTasks }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                        <div class="bg-blue-500 rounded-full h-2 transition-all duration-300" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $progress }}% complete</div>
                                </div>
                            @else
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-center">
                                        <span class="icon-[tabler--info-circle] text-yellow-600 w-4 h-4 mr-2"></span>
                                        <span class="text-sm text-yellow-800">No tasks assigned yet</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-2 grid gap-2 pt-3 border-t border-gray-200">
                                <div class="grid grid-cols-1 lg:grid-cols-2">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="icon-[tabler--flag] text-primary"></span>
                                        <span class="font-semibold">Priority</span>
                                    </div>
                                    @if ($project->priority_id == 1)
                                        <span class="lg:justify-self-end xl:justify-self-end 2xl:justify-self-end badge badge-success">Low</span>
                                    @elseif ($project->priority_id == 2)
                                        <span class="lg:justify-self-end xl:justify-self-end 2xl:justify-self-end badge badge-warning">Medium</span>
                                    @elseif ($project->priority_id == 3)
                                        <span class="lg:justify-self-end xl:justify-self-end 2xl:justify-self-end badge badge-error">High</span>
                                    @endif
                                </div>
                                @if ($project->start_time && $project->end_time)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <span class="icon-[fluent-mdl2--date-time] text-primary"></span>
                                        <span class="font-medium">
                                            {{ date('d M Y g:i A', strtotime($project->start_time)) }} – {{ date('d M Y g:i A', strtotime($project->end_time)) }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Team Members -->
                                @if($project->users->count() > 0)
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center gap-2">
                                            <span class="icon-[tabler--users] text-primary"></span>
                                            <span class="font-semibold">Team ({{ $project->users->count() }})</span>
                                        </div>
                                        <div class="flex -space-x-1">
                                            @foreach($project->users->take(4) as $user)
                                                <div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center">
                                                    <span class="text-white text-xs font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            @endforeach
                                            @if($project->users->count() > 4)
                                                <div class="w-6 h-6 bg-gray-500 rounded-full border-2 border-white flex items-center justify-center">
                                                    <span class="text-white text-xs">+{{ $project->users->count() - 4 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
