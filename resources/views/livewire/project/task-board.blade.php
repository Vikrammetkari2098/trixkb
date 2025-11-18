<div x-init="$wire.dispatch('loadData-task-board')" class="space-y-6 relative">
    <!-- Board Content -->
    <div class="space-y-6">
        <!-- Filters Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- PROJECT FILTER --}}
            @if ($context === 'global')
                <div class="md:col-span-2">
                    <h4 class="text-base font-medium text-gray-700 mb-2">Filter by Project</h4>
                    <div class="filter">
                        <input class="btn filter-reset" type="radio" name="project-filter" aria-label="All Projects"
                            @click="$wire.set('selectedProject', '')" :checked="$wire.selectedProject === ''" />
                        @foreach($projects as $project)
                            <input
                                type="radio"
                                class="btn"
                                name="project-filter"
                                aria-label="{{ $project['title'] }}"
                                @click="$wire.set('selectedProject', '{{ $project['id'] }}')"
                                :checked="$wire.selectedProject === '{{ $project['id'] }}'"
                            />
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
                            <input
                                type="radio"
                                class="btn"
                                name="team-filter"
                                aria-label="{{ $team['name'] }}"
                                @click="$wire.set('selectedTeam', '{{ $team['id'] }}')"
                                :checked="$wire.selectedTeam === {{ $team['id'] }}"
                            />
                        @endforeach
                    </div>
                </div>
                
                {{-- USER FILTER (Second Column) --}}
                <div>
                    <x-select.styled
                        label="Filter by User"
                        :options="array_merge([['name' => 'All Users', 'id' => '']], collect($users)->map(fn($user) => ['name' => $user['name'], 'id' => $user['id']])->toArray())"
                        select="label:name|value:id"
                        wire:model.live="selectedUser"
                        id="user"
                        placeholder="Select user..."
                    />
                </div>
            @endif
        </div>
        <div class="pr-3 pl-3 pb-3">
            <div class="p-3">
                <div class="gap-4 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4">
                    <!-- To-do Column -->
                    <div class="bg-gray-100 p-3 rounded-xl" wire:loading.remove>
                        <div class="gap-4 grid grid-cols-1">
                            <div class="bg-white p-3 rounded-lg shadow-md">
                                <div class="gap-4 grid grid-cols-2">
                                    <div>
                                        <span>
                                            <p class="font-semibold inline">To-do</p>
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="bg-gray-300 inline px-2 rounded-2xl">
                                            <span>
                                                <p class="font-extrabold inline text-gray-700">{{ $todoCount }}</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-2 border-gray-200 border-dashed p-3 rounded-lg cursor-pointer">
                                <div class="grid grid-cols-1">
                                    <p class="font-medium text-center text-gray-400"
                                        x-on:click="$wire.dispatch('open-modal-create')">+ Add new task</p>
                                </div>
                            </div>

                            <div class="pb-4 rounded-lg">
                                <div id="todo-tasks" class="grid grid-cols-1 min-h-[100px]">
                                    @foreach ($todoTasks as $task)
                                        <div data-task-id="{{ $task->id }}" data-can-move="{{ $task->can_move ? '1' : '0' }}"
                                            wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })"
                                            class="cursor-move bg-white p-3 pb-4 rounded-lg shadow-md mb-4 hover:shadow-lg transition duration-200">
                                            <div class="grid grid-cols-1">
                                                <div class="mt-3">
                                                    <div class="grid grid-cols-[4fr_1fr]">
                                                        <div>
                                                            <p class="font-bold inline">{{ Str::limit($task->title, 20) }}</p>
                                                        </div>
                                                        <div class="justify-self-end flex items-center" @click.stop>
                                                            <x-dropdown icon="ellipsis-vertical" static>
                                                                @if($task->can_edit)
                                                                    <x-dropdown.items text="Edit" icon="pencil-square"
                                                                        wire:click.stop.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })" />
                                                                @else
                                                                    <x-dropdown.items text="View" icon="eye"
                                                                        wire:click.stop.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })" />
                                                                @endif
                                                                @if($task->can_delete)
                                                                    <x-dropdown.items text="Delete" icon="trash"
                                                                        wire:click.stop="$dispatch('delete-task', { taskId: {{ $task->id }} })" />
                                                                @endif
                                                            </x-dropdown>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="gap-2 grid grid-cols-1">
                                                    <div>
                                                        <p class="font-semibold inline text-gray-400 text-sm">
                                                            {{ Str::limit($task->description ?? 'No description', 30) }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <img class="h-6 inline object-cover rounded-full w-6"
                                                            src="https://ui-avatars.com/api/?name={{ urlencode($task->assigned_to_name) }}"
                                                            alt="{{ $task->assigned_to_name }}">
                                                        <p class="inline text-sm">{{ $task->assigned_to_name ?? '—' }}</p>
                                                    </div>
                                                    @if ($task->start_time && $task->end_time)
                                                        <div class="flex items-center text-sm text-gray-500 space-x-2">
                                                            <span class="icon-[fluent-mdl2--date-time] text-base size-6 text-warning"></span>
                                                            <span>
                                                                {{ date('d M Y g:i A', strtotime($task->start_time)) }} - {{ date('d M Y g:i A', strtotime($task->end_time)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <x-badge text="{{ ucfirst($task->priority->name ?? 'N/A') }}"
                                                            color="{{ $this->getPriorityColor($task->priority->name ?? 'unknown') }}"
                                                            light />
                                                        <x-badge text="{{ $task->task_type_label }}"
                                                            color="{{ $this->getTaskTypeColor($task->task_type_label) }}" />
                                                    </div>
                                                </div>

                                                <hr class="border-gray-300 my-3">

                                                <div class="gap-4 grid grid-cols-1">
                                                    <div>
                                                        <div class="inline mr-2 p-1 rounded-md shadow-md">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                fill="currentColor" class="bi bi-paperclip inline mr-1"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                                            </svg>
                                                            <p class="font-semibold inline text-sm"> {{ $task->docs_count }}</p>
                                                        </div>
                                                        <div class="inline p-1 rounded-md shadow-md">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                fill="currentColor" class="bi bi-chat-text inline mr-1"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                                                <path
                                                                    d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                                            </svg>
                                                            <p class="font-semibold inline text-sm">{{ $task->comments_count }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In Progress Column -->
                    <div class="bg-gray-100 p-3 rounded-xl" wire:loading.remove>
                        <div class="gap-4 grid grid-cols-1">
                            <div class="bg-white p-3 rounded-lg shadow-md">
                                <div class="gap-4 grid grid-cols-2">
                                    <div>
                                        <span>
                                            <p class="font-semibold inline">In Progress</p>
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="bg-gray-300 inline px-2 rounded-2xl">
                                            <span>
                                                <p class="font-extrabold inline text-gray-600">{{ $progressCount }}</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-2 border-gray-200 border-dashed p-3 rounded-lg cursor-pointer">
                                <div class="grid grid-cols-1">
                                    <p class="font-medium text-center text-gray-400"
                                        x-on:click="$wire.dispatch('open-modal-create')">+ Add new task</p>
                                </div>
                            </div>
                            <div class="pb-4 rounded-lg ">
                                <div id="progress-tasks" class="grid grid-cols-1 min-h-[100px]">
                                    @foreach ($progressTasks as $task)
                                        <div data-task-id="{{ $task->id }}" data-can-move="{{ $task->can_move ? '1' : '0' }}"
                                            wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })"
                                            class="cursor-move bg-white p-3 pb-4 rounded-lg shadow-md mb-4 hover:shadow-lg transition duration-200">
                                            <div class="grid grid-cols-1">
                                                <div class="mt-3">
                                                    <div class="grid grid-cols-[4fr_1fr]">
                                                        <div>
                                                            <p class="font-bold inline">{{ Str::limit($task->title, 20) }}</p>
                                                        </div>
                                                        <div class="align-self-center justify-self-end" @click.stop>
                                                            <x-dropdown icon="ellipsis-vertical" static>
                                                                @if($task->can_edit)
                                                                    <x-dropdown.items text="Edit" icon="pencil-square"
                                                                        wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })" />
                                                                @else
                                                                    <x-dropdown.items text="View" icon="eye"
                                                                        wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })" />
                                                                @endif
                                                                @if($task->can_delete)
                                                                    <x-dropdown.items text="Delete" icon="trash"
                                                                        wire:click="$dispatch('delete-task', { taskId: {{ $task->id }} })" />
                                                                @endif
                                                            </x-dropdown>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="gap-2 grid grid-cols-1">
                                                        <div>
                                                            <p class="font-semibold inline text-gray-400 text-sm">
                                                                {{ Str::limit($task->description ?? 'No description', 30) }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <img class="h-6 inline object-cover rounded-full w-6"
                                                                src="https://ui-avatars.com/api/?name={{ urlencode($task->assigned_to_name) }}"
                                                                alt="{{ $task->assigned_to_name }}">
                                                            <p class="inline text-sm">{{ $task->assigned_to_name ?? '—' }}</p>
                                                        </div>
                                                        @if ($task->start_time && $task->end_time)
                                                            <div class="flex items-center text-sm text-gray-500 space-x-2">
                                                                <span class="icon-[fluent-mdl2--date-time] text-base size-6 text-warning"></span>
                                                                <span>
                                                                    {{ date('d M Y g:i A', strtotime($task->start_time)) }} - {{ date('d M Y g:i A', strtotime($task->end_time)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <x-badge text="{{ ucfirst($task->priority->name ?? 'N/A') }}"
                                                                color="{{ $this->getPriorityColor($task->priority->name ?? 'unknown') }}"
                                                                light />
                                                            <x-badge text="{{ $task->task_type_label }}"
                                                                color="{{ $this->getTaskTypeColor($task->task_type_label) }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="border-gray-300 my-3">

                                                <div>
                                                    <div class="gap-4 grid grid-cols-1">
                                                        <div>
                                                            <div class="inline mr-2 p-1 rounded-md shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                    fill="currentColor" class="bi bi-paperclip inline mr-1"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                                                </svg>
                                                                <p class="font-semibold inline text-sm">{{ $task->docs_count }}</p>
                                                            </div>
                                                            <div class="inline p-1 rounded-md shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                    fill="currentColor" class="bi bi-chat-text inline mr-1"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                                                    <path
                                                                        d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                                                </svg>
                                                                <p class="font-semibold inline text-sm">{{ $task->comments_count }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In Review Column -->
                    <div class="bg-gray-100 p-3 rounded-xl" wire:loading.remove>
                        <div class="gap-4 grid grid-cols-1">
                            <div class="bg-white p-3 rounded-lg shadow-md">
                                <div class="gap-4 grid grid-cols-2">
                                    <div>
                                        <span>
                                            <p class="font-semibold inline">In Review</p>
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="bg-gray-300 inline px-2 rounded-2xl">
                                            <span>
                                                <p class="font-extrabold inline text-gray-600">{{ $reviewCount }}</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-2 border-gray-200 border-dashed p-3 rounded-lg cursor-pointer">
                                <div class="grid grid-cols-1">
                                    <p class="font-medium text-center text-gray-400"
                                        x-on:click="$wire.dispatch('open-modal-create')">+ Add new task</p>
                                </div>
                            </div>
                            <div class="pb-4 rounded-lg ">
                                <div id="review-tasks" class="grid grid-cols-1 min-h-[100px]">
                                    @foreach ($reviewTasks as $task)
                                        <div data-task-id="{{ $task->id }}" data-can-move="{{ $task->can_move ? '1' : '0' }}"
                                            wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })"
                                            class="cursor-move bg-white p-3 pb-4 rounded-lg shadow-md mb-4 hover:shadow-lg transition duration-200">
                                            <div class="grid grid-cols-1">
                                                <div class="mt-3">
                                                    <div class="grid grid-cols-[4fr_1fr]">
                                                        <div>
                                                            <p class="font-bold inline">{{ Str::limit($task->title, 20) }}</p>
                                                        </div>
                                                        <div class="align-self-center justify-self-end" @click.stop>
                                                            <x-dropdown icon="ellipsis-vertical" static>
                                                                <x-dropdown.items text="Edit" icon="pencil-square"
                                                                    wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }} })" />
                                                                <x-dropdown.items text="Delete" icon="trash"
                                                                    wire:click="$dispatch('delete-task', { taskId: {{ $task->id }} })" />
                                                            </x-dropdown>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="gap-2 grid grid-cols-1">
                                                        <div>
                                                            <p class="font-semibold inline text-gray-400 text-sm">
                                                                {{ Str::limit($task->description ?? 'No description', 30) }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <img class="h-6 inline object-cover rounded-full w-6"
                                                                src="https://ui-avatars.com/api/?name={{ urlencode($task->assigned_to_name) }}"
                                                                alt="{{ $task->assigned_to_name }}">
                                                            <p class="inline text-sm">{{ $task->assigned_to_name ?? '—' }}</p>
                                                        </div>
                                                        @if ($task->start_time && $task->end_time)
                                                            <div class="flex items-center text-sm text-gray-500 space-x-2">
                                                                <span class="icon-[fluent-mdl2--date-time] text-base size-6 text-warning"></span>
                                                                <span>
                                                                    {{ date('d M Y g:i A', strtotime($task->start_time)) }} - {{ date('d M Y g:i A', strtotime($task->end_time)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <x-badge text="{{ ucfirst($task->priority->name ?? 'N/A') }}"
                                                                color="{{ $this->getPriorityColor($task->priority->name ?? 'unknown') }}"
                                                                light />
                                                            <x-badge text="{{ $task->task_type_label }}"
                                                                color="{{ $this->getTaskTypeColor($task->task_type_label) }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="border-gray-300 my-3">

                                                <div>
                                                    <div class="gap-4 grid grid-cols-1">
                                                        <div>
                                                            <div class="inline mr-2 p-1 rounded-md shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                    fill="currentColor" class="bi bi-paperclip inline mr-1"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                                                </svg>
                                                                <p class="font-semibold inline text-sm">{{ $task->docs_count }}</p>
                                                            </div>
                                                            <div class="inline p-1 rounded-md shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                    fill="currentColor" class="bi bi-chat-text inline mr-1"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                                                    <path
                                                                        d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                                                </svg>
                                                                <p class="font-semibold inline text-sm">{{ $task->comments_count }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Column -->
                    <div class="bg-gray-100 p-3 rounded-xl" wire:loading.remove>
                        <div class="gap-4 grid grid-cols-1">
                            <div class="bg-white p-3 rounded-lg shadow-md">
                                <div class="gap-4 grid grid-cols-2">
                                    <div>
                                        <span>
                                            <p class="font-semibold inline">Completed</p>
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="bg-gray-300 inline px-2 rounded-2xl">
                                            <span>
                                                <p class="font-extrabold inline text-gray-600">{{ $doneCount }}</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-2 border-gray-200 border-dashed p-3 rounded-lg cursor-pointer">
                                <div class="grid grid-cols-1">
                                    <p class="font-medium text-center text-gray-400"
                                        x-on:click="$wire.dispatch('open-modal-create')">+ Add new task</p>
                                </div>
                            </div>
                            <div class="pb-4 rounded-lg ">
                                <div id="completed-tasks" class="grid grid-cols-1 min-h-[100px]">
                                    @foreach ($completedTasks as $task)
                                        <div data-task-id="{{ $task->id }}" data-can-move="{{ $task->can_move ? '1' : '0' }}"
                                            wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }}, context: '{{ $this->context }}' })"
                                            class="cursor-move bg-white p-3 pb-4 rounded-lg shadow-md mb-4 hover:shadow-lg transition duration-200">
                                            <div class="grid grid-cols-1">
                                                <div class="mt-3">
                                                    <div class="grid grid-cols-[4fr_1fr]">
                                                        <div>
                                                            <p class="font-bold inline">{{ Str::limit($task->title, 20) }}</p>
                                                        </div>
                                                        <div class="align-self-center justify-self-end" @click.stop>
                                                            <x-dropdown icon="ellipsis-vertical" static>
                                                                <x-dropdown.items text="Edit" icon="pencil-square"
                                                                    wire:click.prevent="$dispatch('loadTask', { taskId: {{ $task->id }} })" />
                                                                <x-dropdown.items text="Delete" icon="trash"
                                                                    wire:click="$dispatch('delete-task', { taskId: {{ $task->id }} })" />
                                                            </x-dropdown>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="gap-2 grid grid-cols-1">
                                                        <div>
                                                            <p class="font-semibold inline text-gray-400 text-sm">
                                                                {{ Str::limit($task->description ?? 'No description', 30) }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <img class="h-6 inline object-cover rounded-full w-6"
                                                                src="https://ui-avatars.com/api/?name={{ urlencode($task->assigned_to_name) }}"
                                                                alt="{{ $task->assigned_to_name }}">
                                                            <p class="inline text-sm">{{ $task->assigned_to_name ?? '—' }}</p>
                                                        </div>
                                                    @if ($task->start_time && $task->end_time)
                                                            <div class="flex items-center text-sm text-gray-500 space-x-2">
                                                                <span class="icon-[fluent-mdl2--date-time] text-base size-6 text-warning"></span>
                                                                <span>
                                                                    {{ date('d M Y g:i A', strtotime($task->start_time)) }} - {{ date('d M Y g:i A', strtotime($task->end_time)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <x-badge text="{{ ucfirst($task->priority->name ?? 'N/A') }}"
                                                                color="{{ $this->getPriorityColor($task->priority->name ?? 'unknown') }}"
                                                                light />
                                                            <x-badge text="{{ $task->task_type_label }}"
                                                                color="{{ $this->getTaskTypeColor($task->task_type_label) }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="border-gray-300 my-3">

                                                <div>
                                                    <div class="gap-4 grid grid-cols-1">
                                                        <div>
                                                            <div class="inline mr-2 p-1 rounded-md shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                    fill="currentColor" class="bi bi-paperclip inline mr-1"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                                                </svg>
                                                                <p class="font-semibold inline text-sm">{{ $task->docs_count }}</p>
                                                            </div>
                                                            <div class="inline p-1 rounded-md shadow-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                                    fill="currentColor" class="bi bi-chat-text inline mr-1"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                                                    <path
                                                                        d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                                                </svg>
                                                                <p class="font-semibold inline text-sm">{{ $task->comments_count }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading class="bg-base-100/50 absolute start-0 top-0 size-full"></div>
    <div wire:loading class="absolute start-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform">
        <span class="loading loading-spinner loading-lg text-primary"></span>
    </div>
</div>

@script
<script>
    window.addEventListener('load', () => {
        // Initialize drag and drop for Kanban board
        const todoTasks = document.querySelector('#todo-tasks');
        const progressTasks = document.querySelector('#progress-tasks');
        const reviewTasks = document.querySelector('#review-tasks');
        const completedTasks = document.querySelector('#completed-tasks');

        // Status mapping
        const statusMap = {
            'todo-tasks': 1,
            'progress-tasks': 2,
            'review-tasks': 3,
            'completed-tasks': 4
        };

        function updateLocalCounts(evt) {
            // Decrease count in source column
            const fromCountElement = evt.from.closest('.bg-gray-100').querySelector('.bg-gray-300 .font-extrabold');
            if (fromCountElement) {
                const currentFromCount = parseInt(fromCountElement.textContent) || 0;
                fromCountElement.textContent = Math.max(0, currentFromCount - 1);
            }
            
            // Increase count in destination column
            const toCountElement = evt.to.closest('.bg-gray-100').querySelector('.bg-gray-300 .font-extrabold');
            if (toCountElement) {
                const currentToCount = parseInt(toCountElement.textContent) || 0;
                toCountElement.textContent = currentToCount + 1;
            }
        }

        function revertLocalCounts(evt) {
            // Increase count back in source column
            const fromCountElement = evt.from.closest('.bg-gray-100').querySelector('.bg-gray-300 .font-extrabold');
            if (fromCountElement) {
                const currentFromCount = parseInt(fromCountElement.textContent) || 0;
                fromCountElement.textContent = currentFromCount + 1;
            }
            
            // Decrease count back in destination column
            const toCountElement = evt.to.closest('.bg-gray-100').querySelector('.bg-gray-300 .font-extrabold');
            if (toCountElement) {
                const currentToCount = parseInt(toCountElement.textContent) || 0;
                toCountElement.textContent = Math.max(0, currentToCount - 1);
            }
        }

        function createSortable(element) {
            if (element) {
                return Sortable.create(element, {
                    animation: 150,
                    group: 'kanban',
                    dragClass: '!border-0',
                    ghostClass: 'opacity-50',
                    chosenClass: 'shadow-2xl',
                    onChoose: function (evt) {
                        // Check if user can move this task
                        const taskElement = evt.item;
                        const canMove = taskElement.getAttribute('data-can-move') === '1';
                        
                        if (!canMove) {
                            // Prevent drag if user doesn't have permission
                            evt.preventDefault();
                            return false;
                        }
                    },
                    onEnd: function (evt) {
                        const taskId = evt.item.getAttribute('data-task-id');
                        const canMove = evt.item.getAttribute('data-can-move') === '1';
                        const newStatus = statusMap[evt.to.id];

                        // Double-check permissions before making the API call
                        if (!canMove) {
                            // Revert the move immediately
                            evt.from.appendChild(evt.item);
                            return;
                        }

                        if (taskId && newStatus) {
                            // Update counts locally first for immediate feedback
                            updateLocalCounts(evt);
                            
                            // Use Livewire's native loading states and toast system
                            $wire.call('updateTaskStatus', taskId, newStatus).then(() => {
                                // Don't refresh the board - counts are already updated locally
                                // Just dispatch to other components
                                console.log('Task status updated successfully');
                            }).catch(() => {
                                // On error, revert local changes and move task back
                                revertLocalCounts(evt);
                                evt.from.appendChild(evt.item);
                            });
                        }
                    }
                });
            }
        }

        // Initialize all sortable areas
        createSortable(todoTasks);
        createSortable(progressTasks);
        createSortable(reviewTasks);
        createSortable(completedTasks);
    });
</script>
@endscript
