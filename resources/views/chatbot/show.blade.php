@extends('layouts.app')

@section('content')
    <div>
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <!-- Chatbot SVG Icon -->
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 8h10M7 12h4m-2 8a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Chatbot Details</h1>
                </div>
                <p class="text-gray-600 text-lg">View chatbot configuration and manage its settings.</p>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Example Action Button -->
                <x-button color="blue" size="lg" class="w-full lg:w-auto flex items-center">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Edit Chatbot
                </x-button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6 relative">
            <!-- Loader Overlay -->
            <div wire:loading class="absolute inset-0 flex items-center justify-center bg-white/70 z-50">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>

            <!-- Livewire Chatbot Show -->
            <livewire:users.chatbot-show :chatbot="$chatbot" />
        </div>
    </div>
@endsection
