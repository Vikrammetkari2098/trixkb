@extends('layouts.app')
@section('content')

    <div class="gap-2 grid grid-cols-2 mb-5">
        <div>
            <p class="font-bold text-4xl">{{ $project->title }}</p>
            <p class="font-medium text-lg text-gray-400">{{ $project->description }}</p>
        </div>
        <div>
            <div class="gap-2 grid grid-cols-1 sm:grid-cols-1 md:grid md:grid-cols-1">
                <div class="text-right">
                    <x-button text="Add Member" color="green" />
                </div>
            </div>
        </div>
    </div>
    <div class="gap-2 grid grid-cols-1 mb-5">
        <div>
            <div class="gap-2 grid grid-cols-[1fr_9fr]">
                <div>
                    <p class="font-bold text-lg text-gray-400">Priority:</p>
                </div>
                <div>
                    @if($project->priority)
                        @php
                            $priorityColors = [
                                'low' => 'green',
                                'medium' => 'yellow',
                                'high' => 'orange',
                                'urgent' => 'red'
                            ];
                            $priorityColor = $priorityColors[strtolower($project->priority->name)] ?? 'gray';
                        @endphp
                        <x-badge text="{{ ucfirst($project->priority->name) }}" color="{{ $priorityColor }}" />
                    @else
                        <x-badge text="Not Set" color="gray" />
                    @endif
                </div>
            </div>
        </div>
        <div>
            <div class="gap-2 grid grid-cols-[1fr_9fr]">
                <div>
                    <p class="font-bold text-gray-400">Modules:</p>
                </div>
                <div>
                    @forelse($project->modules as $module)
                        <x-badge text="{{ $module->name }}" color="{{ $module->color }}" class="mr-1 mb-1" />
                    @empty
                        <x-badge text="No modules assigned" color="gray" />
                    @endforelse
                </div>
            </div>
        </div>
        <div>
            <div class="gap-2 grid grid-cols-[1fr_9fr]">
                <div>
                    <p class="font-bold text-lg text-gray-400">Duration:</p>
                </div>
                <div>
                    <p class="text-base">{{ $project->start_time ? $project->start_time->format('j F Y') : 'No start date set' }} - {{ $project->end_time ? $project->end_time->format('j F Y') : 'No end date set' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Management Section -->
    <div class="mt-8">
        <!-- Modals for task creation and editing -->
        <x-modal id="modal-create" center x-on:open-modal-create.window="$modalOpen('modal-create')">
            <h2 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Create a new task</h2>
            <p class="text-base text-gray-500 mb-4">Assign tasks and prioritize your work for this project.</p>
            <livewire:project.task-create :projectId="$projectId" context="project"/>
        </x-modal>

        <x-modal id="modal-edit" center size="5xl" scrollable
             x-show="show" x-on:open-modal-edit.window="show = true"
             x-on:close-modal-edit.window="show = false">
            <h2 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Edit Task</h2>
            <p class="text-base text-gray-500 mb-4">Edit your Task details here.</p>
            <livewire:project.task-edit />
        </x-modal>

        <!-- Header section -->
        <div class="flex items-center justify-between py-6 mb-6">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Project Tasks</h2>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    Manage and track tasks for this project. Organize work, assign responsibilities, and monitor progress.
                </p>
            </div>

            <div class="ml-6">
                <x-button color="green" x-on:click="$modalOpen('modal-create')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Task
                </x-button>
            </div>
        </div>

        <!-- Task tabs -->
        <div>
            <x-tab selected="Overview">
                <x-tab.items tab="Overview">
                    <livewire:project.task-overview :projectId="$projectId" context="project" />
                </x-tab.items>
                <x-tab.items tab="Board">
                    <livewire:project.task-board :projectId="$projectId" context="project" />
                </x-tab.items>
                <x-tab.items tab="List">
                    <div class="p-3">
                        <livewire:project.task-delete :projectId="$projectId"/>
                        <livewire:project.task-list :projectId="$projectId" context="project" />
                    </div>
                </x-tab.items>
                <x-tab.items tab="Timeline">
                    <div class="p-3">
                        <div class="text-center py-8">
                            <p class="text-base text-gray-500">Timeline view coming soon...</p>
                        </div>
                    </div>
                </x-tab.items>
            </x-tab>
        </div>
    </div>

@endsection
