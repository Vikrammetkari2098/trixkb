@extends('layouts.app')
@section('content')

    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary-purple': '#8b5cf6', // Indigo-500 equivalent
                        'soft-purple': '#f5f3ff',   // Indigo-50 equivalent
                    }
                }
            }
        }
    </script>

<body class="font-sans antialiased bg-gray-50 h-screen overflow-hidden">

    <div class="flex h-full">

        <!-- Sidebar (Left Panel) -->
        <aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col custom-scrollbar overflow-y-auto">
            <div class="px-4 py-3 border-b border-gray-200">
                <h1 class="text-sm font-semibold uppercase tracking-wider text-gray-700">Interactive Decision Trees</h1>
            </div>

            <!-- Navigation Tree -->
            <nav class="flex-grow p-2 space-y-1">
                <!-- Top Level Item -->
                <div class="relative">
                    <button class="flex items-center w-full px-2 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        <span>Interactive Decision Trees</span>
                    </button>
                    <!-- Nested Items (Always visible for demonstration) -->
                    <div class="ml-4 space-y-1 mt-1">
                        <!-- Selected Item -->
                        <a href="#" class="flex items-center px-2 py-2 text-sm font-medium text-primary-purple bg-soft-purple rounded-lg transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span>new kb</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area (Right Panel) -->
        <main class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Header Bar -->
            <header class="flex-shrink-0 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-end h-14 px-4">

                    <!-- Right Action Buttons -->
                    <div class="flex items-center space-x-3">

                        <!-- Publish Button -->
                        <button class="px-4 py-2 text-sm font-medium text-white bg-primary-purple rounded-lg shadow-md hover:bg-indigo-600 transition duration-150 ease-in-out">
                            Publish
                        </button>

                        <!-- More Options Dropdown (Alpine.js) -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = true" class="p-2 text-gray-400 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-purple transition duration-150 ease-in-out">
                                <!-- Three Dots Icon (Menu) -->
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 z-20 origin-top-right">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Share</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">Delete KB</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Panel -->
            <div class="flex-1 overflow-y-auto bg-gray-50 p-6">

                <!-- Inner Header / Status Bar -->
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800">new kb</h2>

                    <!-- Draft Status Pill -->
                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        DRAFT
                    </span>

                    <!-- Preview Link -->
                    <a href="#" class="flex items-center text-sm font-medium text-gray-500 hover:text-primary-purple transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview
                    </a>
                </div>

                <!-- Central Content - Workflow Options -->
                <div class="flex justify-center items-center h-full min-h-[500px] p-4">
                    <div class="text-center space-y-6">

                        <p class="text-sm font-medium text-gray-500">Load from template</p>

                        <!-- Template Buttons -->
                        <div class="flex space-x-4 justify-center">
                            <button class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition duration-150 ease-in-out">
                                Workflow Designer - 2 Step
                            </button>
                            <button class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition duration-150 ease-in-out">
                                Workflow Assignment - 3 Step
                            </button>
                        </div>

                        <!-- Separator -->
                        <div class="flex items-center justify-center pt-2 pb-4">
                            <span class="text-xs text-gray-400">or</span>
                        </div>

                        <p class="text-sm font-medium text-gray-500">Start blank</p>

                        <!-- Primary Action Button -->
                        <button class="inline-flex items-center px-8 py-3 text-lg font-semibold text-white bg-primary-purple rounded-full shadow-lg shadow-indigo-200/50 hover:bg-indigo-600 transition duration-150 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-indigo-300">
                            <!-- Plus Icon -->
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add your first step
                        </button>

                    </div>
                </div>

            </div>

        </main>
    </div>
</body>
@endsection
