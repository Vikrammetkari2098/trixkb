@extends('layouts.app')
@section('content')
    <!-- Modals -->
    <x-modal id="modal-create" center>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Add New Team Member</h2>
        <p class="text-base text-gray-600 mb-6">Invite a new member to join your team and collaborate on projects.</p>
        <livewire:teams.team-create />
    </x-modal>

    <x-modal id="modal-edit" center x-show="show" x-on:open-modal-edit.window="show = true" x-on:close-modal-edit.window="show = false">
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Edit Team Member</h2>
        <p class="text-base text-gray-600 mb-6">Update team member details and permissions.</p>
        <livewire:teams.team-edit />
    </x-modal>

    <div class="w-full px-6 max-w-none">
        <!-- Enhanced Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-1m-2-3a3 3 0 11-6 0m3 7H9a3 3 0 00-3 3v2h5.5"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Team Management</h1>
                    </div>
                    <p class="text-gray-600 text-lg">Manage team members, roles, and permissions across your organization</p>
                </div>

                <div class="flex items-center space-x-3">
                    <x-button color="blue" x-on:click="$modalOpen('modal-create')" class="font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Member
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Team Overview Section -->
        <div class="mb-8">
            <livewire:teams.team-overview />
        </div>

        <!-- Team Management Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <x-tab selected="Members" class="border-b border-gray-200">
                <x-tab.items tab="Members">
                    <div class="p-6">
                        <livewire:teams.team-role-view />
                    </div>
                </x-tab.items>
                <x-tab.items tab="Teams Overview">
                    <div class="p-6">
                        <livewire:teams.team-list-view />
                    </div>
                </x-tab.items>
            </x-tab>
        </div>

        <!-- Hidden Delete Component -->
        <livewire:teams.team-delete />
    </div>
@endsection
