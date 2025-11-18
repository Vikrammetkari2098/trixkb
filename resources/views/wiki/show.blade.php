@extends('layouts.app')

    @section('content')
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-6 lg:mb-0">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <!-- Article Icon SVG -->
                    <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Wiki Articles</h1>
            </div>
            <p class="text-gray-600 text-lg">Manage your wiki articles, create new ones, and keep your documentation up to date.</p>
        </div>

        <div class="flex-shrink-0 lg:ml-6">
            <!-- Button to open modal -->
             <x-badge text="{{ $wikiCount ?? 0 }} Total" color="blue" />
            <x-button color="green" size="lg" x-on:click="$modalOpen('modal-create')" class="w-full lg:w-auto flex items-center justify-center">
                <span class="icon-[mdi--plus] text-lg mr-2"></span>
                New Article
            </x-button>
        </div>
    </div>

    <!-- Create Wiki Modal -->
    <x-modal id="modal-create" center size="6xl">
        <div class="px-6 py-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">Create New Wiki Article</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Add a new wiki article to your team documentation. Fill out the details below.
            </p>

            <livewire:wiki.wiki-create :team="$team" />
        </div>
    </x-modal>
    <div class="mt-6">
        <livewire:wiki.wiki-show :team="$team" :user="$user" />
    </div>

@endsection
