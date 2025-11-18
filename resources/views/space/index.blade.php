@extends('layouts.app')
@section('content')
<div>
    <x-modal id="modal-create-space" center
        x-on:open-modal-create-space.window="$modalOpen('modal-create-space')"
        x-on:close-modal-create-space.window="$modalClose('modal-create-space')">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Create a new Space</h2>
        <p class="text-sm text-gray-500 mb-4">Fill in the space details to add a new space.</p>
        <livewire:spaces.space-create />
    </x-modal>
   <x-modal id="modal-edit-space" center
        x-on:open-modal-edit-space.window="$modalOpen('modal-edit-space')"
        x-on:close-modal-edit-space.window="$modalClose('modal-edit-space')">
        <h2 class="text-lg font-semibold text-gray-700">Edit Space</h2>
        <p class="text-sm text-gray-500 mb-4">Update the details of this space.</p>
        <livewire:spaces.space-edit wire:key="space-edit-component" />
    </x-modal>

        {{--  <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
         <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <!-- Left section -->
            <div class="mb-6 lg:mb-0">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Spaces Management</h1>
                </div>
                <p class="text-gray-600 text-lg">Organize and manage spaces within your teams effectively</p>
            </div>

            <!-- Right section -->
            <div class="flex items-center space-x-3">
                <x-badge text="{{ $spacesCount }} Spaces" color="indigo" />
                <x-button color="green" x-on:click="$modalOpen('modal-create-space')" class="font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add New Space
                </x-button>
            </div>
        </div>
    </div>--}}
  <livewire:spaces.space-list :teamId="$team->id" />
  <livewire:spaces.space-delete />
</div>
@endsection
