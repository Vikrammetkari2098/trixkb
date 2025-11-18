@extends('layouts.app')

@section('content')
<div>
    <x-modal id="modal-create-role" center
        x-on:open-modal-create-role.window="$modalOpen('modal-create-role')"
        x-on:close-modal-create-role.window="$modalClose('modal-create-role')">
        <h2 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Create a new Role</h2>
        <p class="text-base text-gray-500 mb-4">Define a role and assign users and permissions.</p>
        <livewire:roles.role-create />
    </x-modal>

    <!-- Edit Role -->
    <x-modal id="modal-edit-role" center
        x-on:open-modal-edit-role.window="$modalOpen('modal-edit-role')"
        x-on:close-modal-edit-role.window="$modalClose('modal-edit-role')">
        <h2 class="text-xl font-semibold text-gray-700 capitalize dark:text-white">Edit Role</h2>
        <p class="text-base text-gray-500 mb-4">Update the role details, assign users, and manage permissions.</p>
        <livewire:roles.role-edit />
    </x-modal>

    <!-- Create Member -->
    <x-modal id="modal-create-member" center
        x-on:open-modal-create-member.window="$modalOpen('modal-create-member')"
        x-on:close-modal-create-member.window="$modalClose('modal-create-member')">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Create a new Member</h2>
        <p class="text-sm text-gray-500 mb-4">Fill in the member details to add a new user.</p>
        <livewire:members.member-create />
    </x-modal>

    <!-- Edit Member -->
    <x-modal id="modal-edit-member" center
        x-on:open-modal-edit-member.window="$modalOpen('modal-edit-member')"
        x-on:close-modal-edit-member.window="$modalClose('modal-edit-member')">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Member</h2>
        <p class="text-sm text-gray-500 mb-4">Update the member details below.</p>
        <livewire:members.member-edit wire:key="member-edit-component" />
    </x-modal>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <!-- Roles Icon (shield) -->
                    <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 2l9 4v6c0 5.25-3.75 10-9 12-5.25-2-9-6.75-9-12V6l9-4z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Roles & Members Management</h1>
            </div>
            <p class="text-gray-600 text-lg">Manage roles, assign permissions, and handle your members efficiently.</p>
        </div>

        <div class="flex items-center space-x-3">
            <x-badge text="{{ $totalRoles }} Roles" color="indigo" />
            <x-button color="green" x-on:click="$modalOpen('modal-create-role')" class="font-medium">
                <!-- Role Plus Icon -->
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Role
            </x-button>
        </div>
    </div>

    <!-- Tabs for Members, Roles, Permissions -->
    <x-tab selected="Roles">
        <!-- Members Tab -->
        <x-tab.items tab="Members">
            {{--  <div class="flex justify-end mb-3">
                <x-button color="green" x-on:click="$modalOpen('modal-create-member')">
                     <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                    Add New Member
                </x-button>
            </div>--}}
            <livewire:members.members-list />
        </x-tab.items>

        <!-- Roles Tab -->
        <x-tab.items tab="Roles">
            <livewire:roles.role-list />
            <livewire:roles.role-delete />
        </x-tab.items>

        <!-- Permissions Tab -->
        <x-tab.items tab="Permissions">
            <livewire:roles.permissions-list />
        </x-tab.items>
    </x-tab>
</div>
@endsection
