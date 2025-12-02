@extends('layouts.app')

@section('content')

@php
    // Get viewMode from URL query parameter, defaulting to 'articles'
    $viewMode = request()->get('viewMode', 'articles');
@endphp


<div class="p-6 bg-white min-h-screen">


    @if ($viewMode === 'articles')
        
        {{-- Articles Page UI --}}
        
        <div class="flex items-center gap-2 mb-6">
            <h1 class="text-2xl font-semibold">Article</h1>

            <a href="#" class="flex items-center gap-1 text-sm text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                <b> Docs</b>
            </a>
        </div>

<div x-data="{ tab: 'feedback' }" class="w-full">

    <!-- Tabs -->
    <div class="flex gap-6 border-b pb-2">

        <!-- Feedback Tab -->
        <button @click="tab = 'feedback'"
           class="relative pb-2 font-medium"
           :class="tab === 'feedback'
                ? 'border-b-2 border-purple-600 text-purple-700'
                : 'text-gray-600'">
            Feedback
            <span class="ml-2 bg-red-600 text-white text-xs px-2 rounded-full">0</span>
        </button>

        <!-- Unanswered Queries Tab -->
        <button @click="tab = 'unanswered'"
           class="relative pb-2 font-medium"
           :class="tab === 'unanswered'
                ? 'border-b-2 border-purple-600 text-purple-700'
                : 'text-gray-600'">
            Unanswered queries
            <span class="ml-2 bg-red-600 text-white text-xs px-2 rounded-full">0</span>
        </button>

    </div>

        {{-- ... rest of Articles UI ... --}}
        
        <div class="flex justify-end mt-6 mb-10 gap-3">
            <div class="relative">
                <input type="text" placeholder="Search" 
           class="px-4 py-2 border border border-gray-300 rounded-md w-64 pl-10 bg-gray-100 focus:bg-white focus:outline-none">

                <svg class="w-4 h-4 absolute left-3 top-3 opacity-60" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>

            <button class="p-2 border border border-gray-300 rounded-md hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
            </button>

            <button class="p-2 border border border-gray-300 rounded-md hover:bg-gray-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
                &nbsp;<b>Filter</b>
            </button>
        </div>

        <div class="flex flex-col items-center justify-center mt-20">
            <img src="{{ asset('image/empty.png') }}" class="w-52 mb-4 opacity-95"> 
            <h3 class="text-xl font-medium text-gray-600">No feedback yet.</h3>
        </div>


    @else 
        
        {{-- Eddy AI Search Page UI --}}
        
        <div class="flex items-center gap-2 mb-6">
            <h1 class="text-2xl font-semibold">Eddy AI search</h1>

            <a href="#" class="flex items-center gap-1 text-sm text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                <b> Docs</b>
            </a>
        </div>

        <div x-data="{ qaTab: 'unanswered' }">

    <div class="flex gap-6 border-b pb-2">

        <!-- Answered Queries -->
        <button 
            @click="qaTab = 'answered'"
            class="relative pb-2"
            :class="qaTab === 'answered' 
                    ? 'border-b-2 border-purple-600 text-purple-700 font-medium' 
                    : 'text-gray-600 hover:text-black'">
            Answered queries
            <span class="ml-2 bg-red-600 text-white text-xs px-2 rounded-full">0</span>
        </button>

        <!-- Unanswered Queries -->
        <button 
            @click="qaTab = 'unanswered'"
            class="relative pb-2"
            :class="qaTab === 'unanswered' 
                    ? 'border-b-2 border-purple-600 text-purple-700 font-medium' 
                    : 'text-gray-600 hover:text-black'">
            Unanswered queries
            <span class="ml-2 bg-red-600 text-white text-xs px-2 rounded-full">0</span>
        </button>

    </div>



        {{-- ... rest of Eddy AI UI ... --}}

        <div class="flex justify-end mt-6 mb-10 gap-3">
            <div class="relative">
                <input type="text" placeholder="Search" 
           class="px-4 py-2 border border border-gray-300 rounded-md w-64 pl-10 bg-gray-100 focus:bg-white focus:outline-none">

                <svg class="w-4 h-4 absolute left-3 top-3 opacity-60" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>

            <button class="p-2 border border border-gray-300 rounded-md hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
            </button>

            <button class="p-2 border border border-gray-300 rounded-md hover:bg-gray-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
                &nbsp;<b>Filter</b>
            </button>
        </div>

        <div class="flex flex-col items-center justify-center mt-20">
            <img src="{{ asset('image/empty.png') }}" class="w-52 mb-4 opacity-95"> 
            <h3 class="text-xl font-medium text-gray-600">No feedback yet.</h3>
        </div>

    @endif

</div>
@endsection