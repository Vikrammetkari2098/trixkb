@extends('layouts.app')
@section('content')
    <!-- Meeting Creation Modal - Using separate component like tasks -->
    <x-modal id="modal-create" center size="4xl" scrollable x-on:open-modal-create.window="$modalOpen('modal-create')">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Create New Meeting</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Schedule a new meeting with team members and set all the necessary details.</p>
        <livewire:meetings.meeting-create />
    </x-modal>

    <!-- Meeting Edit Modal - Using separate component like tasks -->
    <x-modal id="modal-edit" center size="4xl" scrollable 
         x-show="show" x-on:open-modal-edit.window="show = true"
         x-on:close-modal-edit.window="show = false">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Edit Meeting</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Update the meeting details and save your changes.</p>
        <livewire:meetings.meeting-edit />
    </x-modal>

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between py-6 mb-6">
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meetings</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Manage your meetings, schedule new ones, and keep track of upcoming events.
            </p>
        </div>
        <div class="mt-4 lg:mt-0 lg:ml-6">
            <x-button color="green" size="lg" x-on:click="$modalOpen('modal-create')" class="w-full lg:w-auto">
                <span class="icon-[mdi--plus] size-5 mr-2"></span>
                New Meeting
            </x-button>
        </div>
    </div>

    <!-- Meeting Statistics Dashboard -->
    <div class="mb-8">
        <livewire:meetings.meeting-show tab="stats" key="meeting-stats" />
    </div>

    <!-- Meeting Tabs -->
    <div class="w-full">
        <x-tab selected="Current" full-width>
            <x-tab.items tab="Current">
                <livewire:meetings.meeting-show tab="current"/>
            </x-tab.items>
            <x-tab.items tab="Past">
                <livewire:meetings.meeting-show tab="past"/>
            </x-tab.items>
        </x-tab>
    </div>
@endsection
