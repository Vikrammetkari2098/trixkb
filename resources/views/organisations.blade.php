@extends('layouts.app')

@section('content')
<div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <!-- Organisation List SVG Icon -->
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Organisation List</h1>
            </div>

            <p class="text-gray-600 text-lg">Browse all organisations and view their details.</p>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Total Organisations Badge -->
            <x-badge text="{{ $totalOrganisations }} Total" color="blue" />
            {{--  <x-button color="green" x-on:click="window.location='{{ route('organisations.export') }}'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                 Download Excel
            </x-button>--}}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6">
        <div wire:loading class="absolute inset-0 flex items-center justify-center bg-white/70 z-50">
            <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>

        <livewire:organisation.organisation-list />
    </div>
</div>
@endsection
