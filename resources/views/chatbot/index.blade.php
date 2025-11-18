@extends('layouts.app')

@section('content')
<div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <!-- Chatbot Icon (Chat Bubbles) -->
                    <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h6m-6 4h4m-2 6a10 10 0 100-20 10 10 0 000 20z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Chatbot List</h1>
            </div>

            <p class="text-gray-600 text-lg">Browse all chatbots and manage their details.</p>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Example: Total Chatbots Badge -->
            <x-badge text="{{ $chatbotCount ?? 0 }} Total" color="blue" />

            <!-- Add New Chat Button -->
            <x-button color="green" x-on:click="$modalOpen('modal-create-chat')" class="font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                New Chat
            </x-button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6 relative">
        <div wire:loading class="absolute inset-0 flex items-center justify-center bg-white/70 z-50">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>

        <livewire:users.chatbot-table :team="$team" />
    </div>

    <!-- Create Chat Modal -->
    <x-modal id="modal-create-chat" center>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Start New Chat</h2>
        <p class="text-base text-gray-600 mb-6">Create a new chatbot conversation.</p>
        <livewire:users.create-chatbot :team="$team" />
    </x-modal>
</div>
@endsection
