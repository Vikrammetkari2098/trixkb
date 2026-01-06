@extends('layouts.app')

@section('content')
<div class="flex h-screen" x-data="{ 
    myDriveOpen: false, 
    uploadModal: false, 
    newFolderModal: false 
}">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'primary-purple': '#6d28d9',
                    'active-bg': '#f3e8ff',
                    'border-light': '#e5e7eb',
                    'user-initial-bg': '#fcd34d',
                    'icon-blue': '#2563eb',
                }
            }
        }
    }
</script>

<!-- Sidebar -->
<div class="w-82 bg-white border-r h-screen p-4 border-gray-200" x-data="{ myDriveOpen: false }">
    <div class="flex flex-nowrap gap-2 mb-6">
        <button @click="uploadModal = true"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 whitespace-nowrap flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            Upload files
        </button>
        
        <button @click="newFolderModal = true"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 whitespace-nowrap flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            New folder
        </button>
    </div>

    <!-- Navigation -->
    <ul class="space-y-1 text-sm mb-8">
        <li class="flex items-center gap-2 px-3 py-2.5 rounded-lg cursor-pointer bg-active-bg text-primary-purple font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            All files
        </li>
        <li class="flex items-center gap-2 px-3 py-2.5 hover:bg-gray-100 rounded-lg cursor-pointer text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Recent
        </li>
        <li class="flex items-center gap-2 px-3 py-2.5 hover:bg-gray-100 rounded-lg cursor-pointer text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            Starred
        </li>
        <li class="flex items-center gap-2 px-3 py-2.5 hover:bg-gray-100 rounded-lg cursor-pointer text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Recycle bin
        </li>
    </ul>

    <div x-data="{ myDriveOpen: true, imagesOpen: false }" class="mt-4">
        <div x-data="{ 
            myDriveOpen: true, 
            imagesOpen: false,
            imagesDropdownOpen: false 
        }" class="mt-4">
            <!-- My Drive Toggle Button -->
            <button @click="myDriveOpen = !myDriveOpen"
                    :class="myDriveOpen ? 'bg-purple-100 text-purple-700' : 'text-gray-700'"
                    class="flex items-center gap-2 px-3 py-2.5 rounded-lg font-medium w-full hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                My drive
                <svg :class="{'rotate-90': myDriveOpen}" class="ml-auto w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- My Drive Content -->
            <ul x-show="myDriveOpen" x-transition class="mt-2 ml-8 space-y-1 text-sm">
                <!-- Images Item with Submenu -->
                <li class="relative">
                    <!-- Images Toggle Button -->
                    <button @click="imagesDropdownOpen = !imagesDropdownOpen"
                            :class="imagesDropdownOpen ? 'bg-gray-100' : ' text-purple-700'"
                            class="flex items-center gap-2 px-2 py-2 hover:bg-purple-100 rounded-md cursor-pointer w-full text-left text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Images
                        <!-- Dropdown Indicator -->
                        <svg :class="{'rotate-90': imagesDropdownOpen}" class="ml-auto w-3 h-3 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Images Dropdown Items -->
                    <ul x-show="imagesDropdownOpen" x-transition class="mt-1 ml-6 space-y-1 text-sm">
                        <li class="flex items-center gap-2 px-2 py-1.5 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            All Images
                        </li>
                        
                        <li class="flex items-center gap-2 px-2 py-1.5 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Documentation
                        </li>
                        
                        <li class="flex items-center gap-2 px-2 py-1.5 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </li>
                        
                        <li class="flex items-center gap-2 px-2 py-1.5 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Home page builder
                        </li>
                        
                        <li class="flex items-center gap-2 px-2 py-1.5 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Glossary
                        </li>
                    </ul>
                </li>

                <!-- Other Items -->
                <li class="flex items-center gap-2 px-2 py-2 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF
                </li>
                <li class="flex items-center gap-2 px-2 py-2 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Presentation
                </li>
                <li class="flex items-center gap-2 px-2 py-2 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Word-documents
                </li>
                <li class="flex items-center gap-2 px-2 py-2 hover:bg-gray-100 rounded-md cursor-pointer text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    Zip
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="flex-1 p-6 bg-white">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-2 text-gray-700 font-semibold text-xl">
                <span>Drive</span>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#3b82f6"
                        stroke-width="1.5"
                        class="w-5 h-5 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            fill="#3b82f6"
                            d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                    </svg>
                    <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#3b82f6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.966 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
            
            <!-- Storage Info -->
            <div class="flex items-center text-sm text-gray-600 space-x-6">
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 bg-blue-500 rounded-full"></div>
                    <span>0 Bytes / <span class="font-semibold">1 GB PDF storage used</span></span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 bg-green-500 rounded-full"></div>
                    <span>0 Bytes / <span class="font-semibold">500 GB storage used</span></span>
                </div>
                <a href="#" class="text-indigo-600 font-bold hover:text-indigo-800 hover:underline">Upgrade</a>

                <!-- Filter Buttons -->
                <div class="flex space-x-2">
                    <button class="p-2 border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-100">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button class="p-2 border border-gray-300 rounded-lg text-gray-500 hover:bg-gray-100">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                    </button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-100 font-medium">
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="relative w-64 mb-4">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                   placeholder="Search file name" 
                   class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
        </div>
    </div>

    <!-- Files Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dependencies
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Size
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Updated on
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Updated by
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tags
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Images -->
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Images</div>
                                <div class="text-sm text-gray-500">4 files</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">4 Files</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nov 27, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <span class="text-xs font-bold text-yellow-800">JW</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900">Justin Wan</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                </tr>
                
                <!-- PDF -->
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-red-50 rounded-lg flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">PDF</div>
                                <div class="text-sm text-gray-500">0 files</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">0 Files</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nov 27, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <span class="text-xs font-bold text-yellow-800">JW</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900">Justin Wan</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                </tr>
                
                <!-- Presentation -->
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-green-50 rounded-lg flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Presentation</div>
                                <div class="text-sm text-gray-500">0 files</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">0 Files</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nov 27, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <span class="text-xs font-bold text-yellow-800">JW</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900">Justin Wan</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                </tr>
                
                <!-- Word-documents -->
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Word-documents</div>
                                <div class="text-sm text-gray-500">0 files</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">0 Files</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nov 27, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <span class="text-xs font-bold text-yellow-800">JW</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900">Justin Wan</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                </tr>
                
                <!-- Zip -->
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Zip</div>
                                <div class="text-sm text-gray-500">0 files</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">0 Files</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nov 27, 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <span class="text-xs font-bold text-yellow-800">JW</span>
                            </div>
                            <div class="text-sm font-medium text-gray-900">Justin Wan</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="text-sm text-gray-600 text-right">
                1 - 5 of 5 items
            </div>
        </div>
    </div>
</div>

<!-- New Folder Modal -->
<div x-show="newFolderModal"
        x-transition
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/20">
        <div @click.away="newFolderModal = false"
            x-transition
            x-data="{ selectedLocation: 'images' }" 
            class="bg-white rounded-lg shadow-lg w-full max-w-md relative">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">New folder</h2>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Folder name</label>
                    <input type="text" 
                        placeholder="Enter folder name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                
                <div x-data="{ isFolderMenuOpen: false, searchTerm: '' }" class="relative w-full">
                    <button
                        id="folderLocationBtn"
                        class="w-full flex justify-between items-center bg-white border border-gray-300 text-gray-800 py-2.5 px-4 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out text-sm"
                        @click="isFolderMenuOpen = !isFolderMenuOpen"
                        aria-haspopup="true"
                        :aria-expanded="isFolderMenuOpen"
                    >
                        <span x-text="selectedLocation.split('-').map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(' ')">Images</span>
                        <svg
                            class="h-5 w-5 ml-2 -mr-1 transition-transform duration-200"
                            :class="{'rotate-180': isFolderMenuOpen}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <ul
                        id="folderLocationMenu"
                        x-cloak
                        x-show="isFolderMenuOpen"
                        @click.outside="isFolderMenuOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute mt-2 w-full p-2 bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 z-50 origin-top-right max-h-64 overflow-y-auto"
                    >
                        <li class="p-1">
                            <label for="folderSearch" class="block text-xs font-medium text-gray-500 mb-1 sr-only">Search</label>
                            <input
                                type="text"
                                id="folderSearch"
                                placeholder="Search folders..."
                                x-model="searchTerm"
                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2"
                            >
                        </li>

                        <li class="my-2 border-t border-gray-200"></li>

                        <div class="space-y-1" @click="isFolderMenuOpen = false">
                            <li
                                x-show="'images'.includes(searchTerm.toLowerCase()) || 'documentation'.includes(searchTerm.toLowerCase()) || 'settings'.includes(searchTerm.toLowerCase()) || 'glossary'.includes(searchTerm.toLowerCase()) || searchTerm === ''"
                                class="group"
                            >
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md font-semibold cursor-pointer text-sm">
                                    <input
                                        type="radio"
                                        name="location"
                                        value="images"
                                        x-model="$parent.selectedLocation"
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                    >
                                    <span>Images</span>
                                </label>

                                <ul class="ml-6 mt-1 space-y-1 border-l border-gray-200 pl-3">
                                    <li x-show="'documentation'.includes(searchTerm.toLowerCase()) || searchTerm === '' || 'images'.includes(searchTerm.toLowerCase())">
                                        <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                            <input
                                                type="radio"
                                                name="location"
                                                value="images-documentation"
                                                x-model="$parent.selectedLocation"
                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                            >
                                            <span>Documentation</span>
                                        </label>
                                    </li>
                                    <li x-show="'settings'.includes(searchTerm.toLowerCase()) || searchTerm === '' || 'images'.includes(searchTerm.toLowerCase())">
                                        <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                            <input
                                                type="radio"
                                                name="location"
                                                value="images-settings"
                                                x-model="$parent.selectedLocation"
                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                            >
                                            <span>Settings</span>
                                        </label>
                                    </li>
                                    <li x-show="'home page builder'.includes(searchTerm.toLowerCase()) || searchTerm === '' || 'images'.includes(searchTerm.toLowerCase())">
                                        <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                            <input
                                                type="radio"
                                                name="location"
                                                value="images-home page builder"
                                                x-model="$parent.selectedLocation"
                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                            >
                                            <span>Home page builder</span>
                                        </label>
                                    </li><li x-show="'glossary'.includes(searchTerm.toLowerCase()) || searchTerm === '' || 'images'.includes(searchTerm.toLowerCase())">
                                        <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                            <input
                                                type="radio"
                                                name="location"
                                                value="images-glossary"
                                                x-model="$parent.selectedLocation"
                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                            >
                                            <span>Glossary</span>
                                        </label>
                                    </li>
                                    
                                </ul>
                            </li>

                            <li class="my-2 border-t border-gray-200"></li>

                            <li x-show="'pdf'.includes(searchTerm.toLowerCase()) || searchTerm === ''">
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                    <input
                                        type="radio"
                                        name="location"
                                        value="pdf"
                                        x-model="$parent.selectedLocation"
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                    >
                                    <span>PDF</span>
                                </label>
                            </li>

                            <li x-show="'Presentation'.includes(searchTerm.toLowerCase()) || searchTerm === ''">
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                    <input
                                        type="radio"
                                        name="location"
                                        value="Presentation"
                                        x-model="$parent.selectedLocation"
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                    >
                                    <span>Presentation</span>
                                </label>
                            </li>

                            
                            <li x-show="'word-documents'.includes(searchTerm.toLowerCase()) || 'word'.includes(searchTerm.toLowerCase()) || 'documents'.includes(searchTerm.toLowerCase()) || searchTerm === ''">
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                    <input
                                        type="radio"
                                        name="location"
                                        value="word-documents"
                                        x-model="$parent.selectedLocation"
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                    >
                                    <span>Word-documents</span>
                                </label>
                            </li>
                            <li x-show="'Zip'.includes(searchTerm.toLowerCase()) || searchTerm === ''">
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md cursor-pointer text-sm">
                                    <input
                                        type="radio"
                                        name="location"
                                        value="Zip"
                                        x-model="$parent.selectedLocation"
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 radio-input"
                                    >
                                    <span>Zip</span>
                                </label>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button @click="newFolderModal = false"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 text-sm">
                    Cancel
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                    Create
                </button>
            </div>
        </div>
    </div>

<!-- Upload Modal -->
<div x-show="uploadModal"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/20">

    <div x-show="uploadModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="uploadModal = false"
         class="bg-white rounded-lg shadow-lg w-full max-w-5xl h-[60vh] flex flex-col overflow-hidden border border-gray-200">

        <div class="p-6 pb-3 relative">
            <button @click="uploadModal = false"
                    class="absolute right-6 top-6 text-gray-400 hover:text-black text-xl">
                ✕
            </button>

            <h2 class="text-xl font-semibold mb-4">Upload Files</h2>

            <label class="text-sm font-medium text-gray-700">Folder location</label>
            <select class="w-full mt-1 mb-5 border border-gray-200 rounded-lg px-3 py-2">
                <option>Images</option>
                <option>Documents</option>
                <option>Videos</option>
            </select>

            <div class="border border-gray-300 rounded-xl h-[240px] flex flex-col items-center justify-center bg-gray-50">
                <svg width="40" height="40" fill="none" stroke="#444" stroke-width="1.5" class="mb-4 opacity-80">
                    <path d="M20 12v16m0-16l-6 6m6-6l6 6"/>
                    <rect x="6" y="6" width="28" height="28" rx="4"/>
                </svg>

                <div class="flex gap-3">
                    <label class="px-4 py-2  border border-gray-200 rounded-lg text-sm hover:bg-gray-100 cursor-pointer">
                     Upload from my device
                 <input type="file" class="hidden" onchange="handleFileUpload(this.files)">
           </label>
                    <button onclick="startScreenCapture()" class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-100">
                    Screen capture
                  </button>
                </div>

                <p class="mt-3 text-gray-500 text-sm">or drag and drop</p>
            </div>
        </div>

        <div class="bg-white  px-6 py-4 flex justify-between items-center">
            <p class="text-gray-600 text-sm">Supported formats: All</p>
            <p class="text-gray-600 text-sm">Max size: 150 MB</p>
        </div>

        <div class="bg-white px-6 py-4 border-t border-gray-200 flex justify-end gap-3 rounded-b-lg">
            <button @click="uploadModal = false"
                    class="px-4 py-2 border border-gray-200 rounded-lg">
                Cancel
            </button>

            <button class="px-6 py-2 bg-purple-500 text-white rounded-lg">
                Upload
            </button>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection