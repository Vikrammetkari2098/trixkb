<div class="bg-white rounded-xl shadow-soft overflow-hidden mb-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start p-4 md:p-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 flex items-center mb-3 sm:mb-0">
            Tasks
            <x-button
                wire:click="viewAllTasks"
                class="text-blue-600 text-sm font-medium hover:underline ml-3">
                View all
            </x-button>

        </h2>

        <div class="flex flex-wrap gap-2 text-xs font-semibold">
            <span class="badge badge-soft badge-error">This week ({{ $countThisWeek }})</span>
            <span class="badge badge-soft badge-neutral">Today ({{ $countToday }})</span>
            <span class="badge badge-soft badge-error">Overdue ({{ $countOverdue }})</span>
            <span class="badge badge-soft badge-neutral">Snoozed ({{ $countSnoozed }})</span>
        </div>


    </div>

    {{-- Filters --}}
    <div class="p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-4 border-b border-gray-100">

       {{-- Assigned Dropdown --}}
        <div class="dropdown relative inline-flex">
            <button id="assigned-dropdown" type="button"
                class="dropdown-toggle btn btn-primary btn-block text-sm font-medium"
                aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                {{ $assignedFilter === 'assigned_to_me'
                    ? 'Assigned to ' . Auth::user()->name
                    : ($assignedFilter === 'created_by_me'
                        ? 'Created by ' . Auth::user()->name
                        : 'All Tasks') }}
                <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
            </button>

            <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60"
                role="menu" aria-orientation="vertical" aria-labelledby="assigned-dropdown">
                <li>
                    <button class="dropdown-item"
                        wire:click="$set('assignedFilter', 'assigned_to_me')">
                        Assigned to {{ Auth::user()->name }}
                    </button>
                </li>

                <li>
                    <button class="dropdown-item"
                        wire:click="$set('assignedFilter', 'created_by_me')">
                        Created by {{ Auth::user()->name }}
                    </button>
                </li>
            </ul>
        </div>
        {{-- Status Tabs --}}
        <nav class="flex items-center gap-2" role="tablist" aria-orientation="horizontal">
            @foreach([
                'completed' => ['label' => 'Completed', 'color' => 'btn-success'],
                'in-progress' => ['label' => 'In Progress', 'color' => 'btn-primary'],
                'pending-review' => ['label' => 'Pending Review', 'color' => 'btn-warning'],
            ] as $key => $tab)
                <button type="button"
                    wire:click="$set('activeWorkflowTab', '{{ $key }}')"
                    class="btn btn-soft {{ $tab['color'] }} transition-transform duration-200
                        {{ $activeWorkflowTab === $key ? 'font-semibold scale-105' : '' }}">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </nav>
        <div class="relative w-full md:w-64">
            <input type="text"
                wire:model.debounce.500ms="search"
                placeholder="Search..."
                class="input input-bordered input-sm w-full pl-10"
            >
            <span class="icon-[tabler--search] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 size-5"></span>
        </div>
    </div>

    {{-- Task Table --}}
    @if ($tasks->count() > 0)
        <div class="w-full overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th>Priority</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="font-medium">{{ $task->title }}</td>
                            <td>{{ $task->assignee->name ?? '-' }}</td>
                            <td>{{ optional($task->end_time)->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-soft badge-primary text-xs">
                                    {{ $task->priority->name ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-soft badge-success text-xs">
                                    {{ $task->statusInfo->name ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- No Data --}}
        <div class="p-10 text-center">
            <img src="{{ asset('image/task.png') }}" class="mx-auto w-40 mb-6">
            <h3 class="text-lg font-semibold text-gray-600">No tasks found</h3>
            <p class="text-gray-500">Sit back and relax. All tasks are complete or unassigned.</p>
        </div>
    @endif
</div>
