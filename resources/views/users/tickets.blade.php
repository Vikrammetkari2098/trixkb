@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <!-- Ticket Icon SVG -->
                    <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v3a2 2 0 002 2zm0 0v5a2 2 0 002 2h2a2 2 0 002-2v-5" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Support Tickets</h1>
            </div>
            <p class="text-gray-600 text-lg">Manage all support tickets, assign them, and track progress easily.</p>
        </div>

        <div class="flex-shrink-0 lg:ml-6">
            <!-- Badge for total tickets -->
            <x-badge text="{{ $ticketCount ?? 0 }} Total" color="indigo" />
            <!-- Button to open modal -->
            <x-button color="green" size="lg" x-on:click="$modalOpen('modal-create-ticket')" class="w-full lg:w-auto flex items-center justify-center">
                <span class="icon-[mdi--plus] text-lg mr-2"></span>
                New Ticket
            </x-button>
        </div>
    </div>
    <div class="mb-4">
        <div wire:loading.remove>
            <livewire:organisation-filters/>
        </div>
    </div>
    <!-- Create Ticket Modal -->
    <x-modal id="modal-create-ticket" center size="5xl">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">Create New Ticket</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Submit a new support ticket. Fill out the details below.
            </p>
        </div>
    </x-modal>

    <!-- Tickets Table -->
    <div class="mt-6">
        <livewire:users.ticket-table/>
    </div>
@endsection
