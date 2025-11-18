@extends('layouts.app')
@section('content')
    <x-modal id="modal-create" center x-on:open-modal-create.window="$modalOpen('modal-create')">
        <h2 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Create a new task</h2>
        <p class="text-base text-gray-500 mb-4">Assign tasks and prioritize your work.</p>
        <livewire:project.task-create context="global"/>
    </x-modal>
    <x-modal id="modal-edit" center size="5xl" scrollable
         x-show="show" x-on:open-modal-edit.window="show = true"
         x-on:close-modal-edit.window="show = false">
        <h2 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Edit Task</h2>
        <p class="text-base text-gray-500 mb-4">Edit your Task details here.</p>
        <livewire:project.task-edit />
    </x-modal>

    <div class="flex items-center justify-between py-6 mb-6">
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tasks</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                Organize your personal tasks and assignments. Track your individual work progress and stay on top of your responsibilities.
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

    <div>
        <x-tab selected="Overview">
            <x-tab.items tab="Overview">
                <livewire:project.task-overview context="global" />
            </x-tab.items>
            <x-tab.items tab="Board">
                <livewire:project.task-board context="global" />
            </x-tab.items>
            <x-tab.items tab="List">
                <div class="p-3">
                    <livewire:project.task-delete />
                    <livewire:project.task-list context="global" />
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
