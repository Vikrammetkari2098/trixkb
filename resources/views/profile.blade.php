@extends('layouts.app')

@section('content')
<div class="w-full px-6 max-w-none">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <p class="mt-2 text-gray-600">Manage your personal information and preferences</p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <x-button
                    type="button"
                    color="gray"
                    class="flex items-center justify-center"
                    x-on:click="$modalOpen('modal-change-password')">
                    <span class="icon-[tabler--lock] mr-2"></span>
                    Change Password
                </x-button>
                <x-button
                    type="button"
                    color="blue"
                    class="flex items-center justify-center"
                    x-on:click="$modalOpen('modal-edit-profile')">
                    <span class="icon-[tabler--edit] mr-2"></span>
                    Edit Profile
                </x-button>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <livewire:profile.profile-show />

    <!-- Edit Profile Modal -->
    <x-modal 
        id="modal-edit-profile" 
        title="Edit Profile"
        size="4xl"
        center
        wire:ignore.self>
        <x-slot name="description">
            Update your personal information and preferences
        </x-slot>
        
        <livewire:profile.profile-edit key="profile-edit-{{ auth()->id() }}" />
    </x-modal>

    <!-- Change Password Modal -->
    <x-modal 
        id="modal-change-password" 
        title="Change Password"
        center
        wire:ignore.self>
        <x-slot name="description">
            Update your account password for security
        </x-slot>
        
        <livewire:profile.change-password key="change-password-{{ auth()->id() }}" />
    </x-modal>
</div>

<!-- Modal functionality is handled by Alpine.js x-show and Livewire events -->

<style>
.icon-\[tabler--check\] {
    @apply w-4 h-4;
}
.icon-\[tabler--folder\] {
    @apply w-4 h-4;
}
.icon-\[tabler--list-check\] {
    @apply w-4 h-4;
}
.icon-\[tabler--users\] {
    @apply w-4 h-4;
}
.icon-\[tabler--activity\] {
    @apply w-4 h-4;
}
.icon-\[tabler--award\] {
    @apply w-4 h-4;
}
.icon-\[tabler--star\] {
    @apply w-4 h-4;
}
.icon-\[tabler--chart-line\] {
    @apply w-4 h-4;
}
.icon-\[tabler--folder-plus\] {
    @apply w-4 h-4;
}
.icon-\[tabler--plus\] {
    @apply w-4 h-4;
}
.icon-\[tabler--edit\] {
    @apply w-4 h-4;
}
.icon-\[tabler--message\] {
    @apply w-4 h-4;
}
.icon-\[tabler--upload\] {
    @apply w-4 h-4;
}
.icon-\[tabler--user-x\] {
    @apply w-4 h-4;
}
.icon-\[tabler--lock\] {
    @apply w-4 h-4;
}
.icon-\[tabler--x\] {
    @apply w-4 h-4;
}
</style>
@endsection
