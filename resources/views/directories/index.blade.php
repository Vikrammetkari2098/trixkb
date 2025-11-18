@extends('layouts.app')

@section('content')
    <x-modal id="modal-create" size="7xl" center>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Add New Team Member</h2>
            <p class="text-base text-gray-600 mb-6">Invite a new member to join your team and collaborate on projects.</p>
            <livewire:directories.directory-create :team="$team" />
    </x-modal>
    <div>
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <!-- Directory SVG Icon -->
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Directory List</h1>
                </div>
                <p class="text-gray-600 text-lg">Browse all directories and view their details.</p>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Total Directory Badge -->
                <x-badge text="{{ $totalDirectories ?? 0 }} Total" color="blue" />
                <x-button color="green" size="lg" x-on:click="$modalOpen('modal-create')" class="w-full lg:w-auto flex items-center">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Directory
                </x-button>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6 relative">
            <!-- Loader Overlay -->
            <div wire:loading class="absolute inset-0 flex items-center justify-center bg-white/70 z-50">
                <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>


            <!-- Livewire Directory Table -->
            <livewire:directories.directory-table />
        </div>
    </div>
@endsection
