@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <!-- Header + Badge -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
            <div class="flex items-center space-x-3 mb-4 lg:mb-0">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <!-- Chatbot Icon SVG -->
                    <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 0a2 2 0 002-2V8a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2h2l2 2 2-2h2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Upload Chatbot</h1>
                    <p class="text-gray-600 text-lg">Upload your chatbot files, manage existing uploads, and keep your team’s chatbot data up to date.</p>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0 lg:ml-6">
            <x-badge text="{{ $chatbotCount ?? 0 }} Total" color="blue" />
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6 relative">
        <div class="mt-6">
            <livewire:users.upload-chatbot :team="$team" :user="$user" />
        </div>
    </div>
@endsection
