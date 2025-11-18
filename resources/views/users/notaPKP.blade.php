@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
    <div class="mb-6 lg:mb-0">
        <div class="flex items-center space-x-3 mb-3">
            <div class="p-2 bg-green-100 rounded-lg">
                <!-- Nota Icon SVG -->
                <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Nota PKP</h1>
        </div>
        <p class="text-gray-600 text-lg">Manage your Nota PKP entries, create new ones, and keep your records updated.</p>
    </div>

    <div class="flex-shrink-0 lg:ml-6">
        <!-- Total badge -->
        <x-badge text="{{ $notaCount ?? 0 }} Total" color="blue" />
    </div>
</div>
<div class="mt-6">
    <livewire:users.nota-pkp/>
</div>
@endsection
