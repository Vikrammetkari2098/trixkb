@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <!-- Administrative Settings SVG Icon -->
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Administrative Settings</h1>
            </div>

            <p class="text-gray-600 text-lg">Manage ministries, filter by status, and view all records.</p>
        </div>
    </div>
    <!-- Content Card -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6 relative">
        <!-- Loading Overlay -->
        <div wire:loading class="absolute inset-0 flex items-center justify-center bg-white/70 z-50">
            <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>

        <!-- Administrative Settings Livewire Component -->
        <livewire:organisation.ministries-list :team="$team" />
    </div>
</div>
@endsection
