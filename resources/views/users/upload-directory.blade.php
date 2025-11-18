@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <!-- Directory Icon SVG -->
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Upload Directory</h1>
            </div>
            <p class="text-gray-600 text-lg">Upload files to your directory, manage existing files, and keep your team’s data organized.</p>
        </div>

        <div class="flex-shrink-0 lg:ml-6">
            <!-- Badge showing total directories -->
            <x-badge text="{{ $directoryCount ?? 0 }} Total" color="blue" />
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6 relative">
        <div class="mt-6">
            <livewire:users.upload-directory :team="$team" :user="$user" />
        </div>
    </div>

@endsection
