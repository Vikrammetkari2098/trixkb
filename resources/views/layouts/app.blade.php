<!DOCTYPE html>
<html lang="en" data-theme="light">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>TrixKB</title>

        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-gantt.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
        <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
        <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body id="page-top" class="bg-gray-50">

        <div x-data="{ activePage: window.location.pathname, sidebarOpen: false }"
            x-init=" activePage = window.location.pathname; document.addEventListener('livewire:navigated', () => { activePage = window.location.pathname; }); "
            class="flex flex-col min-h-screen">

            {{-- Top Navbar --}}
            @include('layouts.navbar')

            {{-- Sidebar + Main Container --}}
            <div class="flex flex-1 min-h-[calc(100vh-40px)]">

                <aside id="with-navbar-sidebar"
                    :class="{
                        'translate-x-0 w-64': sidebarOpen,
                        '-translate-x-full sm:translate-x-0 w-24': !sidebarOpen
                    }"
                    class="flex flex-col items-center py-4 space-y-2 bg-white shadow-lg transition-[width,transform] duration-300 min-h-screen z-20">

                    {{-- New: Toggle Button (The "Arrow") --}}
                    <div class="w-full px-2 mb-2">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 w-full flex transition-colors duration-200"
                            :class="{ 'justify-between': sidebarOpen, 'justify-center': !sidebarOpen }">
                            <span x-show="sidebarOpen" x-transition img src="kblogo.png"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#09325d"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
                        </button>
                    </div>
                    {{-- End Toggle Button --}}

                    <ul class="menu p-0 space-y-2 w-full" x-data="{ activePath: window.location.pathname }">

                        {{-- Dashboard --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('dashboard') }}"
                                :class="activePath === '/' || activePath === '/dashboard'
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-home text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath === '/' || activePath === '/dashboard' ? 'text-white' : 'text-gray-700'">
                                    Dashboard
                                </span>
                                {{-- Tooltip (only for collapsed state) --}}
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        {{-- Docs --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('docs') }}"
                                :class="activePath.includes('/docs')
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-book text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/docs') ? 'text-white' : 'text-gray-700'">
                                    Docs
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Docs
                                </span>
                            </a>
                        </li>

                        <li class="relative group w-full px-2">
                            <a href="{{ route('roles') }}"
                                :class="activePath.includes('/roles')
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-users text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/roles') ? 'text-white' : 'text-gray-700'">
                                    Roles
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Roles
                                </span>
                            </a>
                        </li>

                        {{-- Members with Dropdown --}}
                        <li x-data="{ open: false, timeout: null }"
                            @mouseover.away="timeout = setTimeout(() => { open = false }, 150)" class="relative z-50 w-full px-2">

                            <button
                                @mouseenter="clearTimeout(timeout); open = true"
                                @click="activePath = '/members'; window.location.href = '{{ route('members') }}';"
                                :class="open || activePath.includes('/members') ? 'bg-[#09325d] text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'"
                                class="sidebar-item transition-all w-full h-12 flex items-center rounded-xl cursor-pointer relative focus:outline-none group"
                                aria-expanded="open ? 'true' : 'false'" aria-controls="members-popup">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="open || activePath.includes('/members') ? 'text-white' : 'text-gray-700'">
                                    Members
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Members</span>
                            </button>

                            <div x-cloak x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                @mouseenter="clearTimeout(timeout); open = true"
                                id="members-popup"
                                class="absolute left-full top-0 ml-3 w-64 bg-[#09325d] shadow-xl rounded-xl border border-[#062140] z-50 transform origin-top-left">
                                <div class="p-2 space-y-1 text-white w-full h-full bg-[#09325d] rounded-xl">

                                    <a href="{{ route('members') }}"
                                        class="flex items-center w-full text-left px-3 py-2 rounded-md text-sm font-semibold transition-colors hover:bg-[#062140] text-white"
                                        @click="activePath='/members'; open = false">
                                        <i class="fas fa-address-book mr-3 text-lg w-4"></i>
                                        <span>Go to Members Dashboard</span>
                                    </a>

                                    <div class="border-t border-[#062140] my-2"></div>

                                    <h4 class="text-xs font-semibold uppercase text-gray-300 px-3 py-1">Quick Actions</h4>

                                    <div class="space-y-1">
                                        <button
                                            class="flex items-center w-full text-left px-3 py-2 rounded-md text-sm font-medium transition-colors hover:bg-[#062140] text-green-400"
                                            x-on:click="$modalOpen('modal-create-member'); open=false">
                                            <i class="fas fa-plus-circle text-lg w-4 mr-3 text-center"></i>
                                            <span>Create New Member</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>

                        {{-- Projects --}}
                        <li class="w-full px-2">
                            <a href="{{ route('projects.show') }}"
                                :class="activePath.includes('/projects') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-briefcase text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/projects') ? 'text-white' : 'text-gray-700'">
                                    Projects
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Projects</span>
                            </a>
                        </li>

                        {{-- Meetings --}}
                        <li class="w-full px-2">
                            <a href="{{ route('meetings') }}"
                                :class="activePath.includes('/meetings') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/meetings') ? 'text-white' : 'text-gray-700'">
                                    Meetings
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Meetings</span>
                            </a>
                        </li>

                        {{-- My Tasks --}}
                        <li class="w-full px-2">
                            <a href="{{ route('tasks') }}"
                                :class="activePath.includes('/tasks') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-clipboard-list text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/tasks') ? 'text-white' : 'text-gray-700'">
                                    My Tasks
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">My Tasks</span>
                            </a>
                        </li>

                        {{-- Teams --}}
                        <li class="w-full px-2">
                            <a href="{{ route('teams') }}"
                                :class="activePath.includes('/teams') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-users-cog text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/teams') ? 'text-white' : 'text-gray-700'">
                                    Teams
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Teams</span>
                            </a>
                        </li>

                        <li class="w-full px-2">
                            <a href="{{ route('spaces.index') }}"
                                :class="activePath.includes('/spaces') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-th text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/spaces') ? 'text-white' : 'text-gray-700'">
                                    Spaces
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Spaces</span>
                            </a>
                        </li>

                        {{-- Matrix --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.matrix') }}"
                                :class="activePath.includes('/organisation/matrix') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-table text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/organisation/matrix') ? 'text-white' : 'text-gray-700'">
                                    Matrix
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Matrix</span>
                            </a>
                        </li>

                        {{-- All Article (Wikies) --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.wikies', ['team' => $team->slug, 'user' => Auth::user()->slug]) }}"
                                :class="activePath.includes('/wikies') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-book-open text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/wikies') ? 'text-white' : 'text-gray-700'">
                                    All Article
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All Article</span>
                            </a>
                        </li>


                        {{-- All Directory --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.directory', ['team' => $team->slug, 'user' => Auth::user()->slug]) }}"
                                :class="activePath.includes('/directory') && !activePath.includes('/directoryUpload') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-folder-open text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/directory') && !activePath.includes('/directoryUpload') ? 'text-white' : 'text-gray-700'">
                                    All Directory
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All Directory</span>
                            </a>
                        </li>

                        {{-- All Resolution (Tickets) --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.tickets', ['team' => $team->slug, 'user' => Auth::user()->slug]) }}"
                                :class="activePath.includes('/tickets') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/tickets') ? 'text-white' : 'text-gray-700'">
                                    All Resolution
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All Resolution</span>
                            </a>
                        </li>


                        {{-- All ChatBot --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.chatbot', [$team->slug, Auth::user()->slug]) }}"
                                :class="activePath.includes('/chatbot') && !activePath.includes('/chatbotUpload') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-robot text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/chatbot') && !activePath.includes('/chatbotUpload') ? 'text-white' : 'text-gray-700'">
                                    All ChatBot
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All ChatBot</span>
                            </a>
                        </li>

                        {{-- Nota PKP --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.notaPKP', [$team->slug, Auth::user()->slug]) }}"
                                :class="activePath.includes('/notaPKP') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-sticky-note text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/notaPKP') ? 'text-white' : 'text-gray-700'">
                                    Nota PKP
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Nota PKP</span>
                            </a>
                        </li>

                        {{-- Directory Upload --}}
                        <li class="w-full px-2">
                            <a href="{{ route('users.directoryUpload', [$team->slug, Auth::user()->slug]) }}"
                                :class="(activePath.includes('/directoryUpload') || activePath.includes('/upload'))
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-folder text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="(activePath.includes('/directoryUpload') || activePath.includes('/upload')) ? 'text-white' : 'text-gray-700'">
                                    Directory Upload
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Directory Upload
                                </span>
                            </a>
                        </li>
                        <li class="w-full px-2">
                            <a href="{{ route('users.chatbotUpload', [$team->slug, Auth::user()->slug]) }}"
                                :class="activePath.includes('/chatbotUpload') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-robot text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/chatbotUpload') ? 'text-white' : 'text-gray-700'">
                                    Chatbot Upload
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Chatbot Upload</span>
                            </a>
                        </li>

                        {{-- Reporting (role check) --}}
                        @if (auth()->user()->current_role_id != App\Helpers\GeneralHelper::userInternalPKPAgent() && auth()->user()->current_role_id != App\Helpers\GeneralHelper::userExternalPKPAgent())
                            <li class="w-full px-2">
                                <a href="{{ route('reports.reportings', [$team->slug, Auth::user()->slug]) }}"
                                    :class="activePath.includes('/reportings') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                    class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                    <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                        <i class="fas fa-file-alt text-lg"></i>
                                    </div>
                                    <span x-show="sidebarOpen"
                                        x-transition:enter="transition ease-out duration-100 delay-50"
                                        x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                        x-transition:enter-end="opacity-100 translate-x-0"
                                        x-transition:leave="transition ease-in duration-75"
                                        class="ml-2 font-medium whitespace-nowrap"
                                        :class="activePath.includes('/reportings') ? 'text-white' : 'text-gray-700'">
                                        Reporting
                                    </span>
                                    <span x-show="!sidebarOpen"
                                        class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Reporting</span>
                                </a>
                            </li>
                        @endif

                        {{-- Administrative --}}
                        <li class="w-full px-2">
                            <a href="{{ route('ministry.index', $team->slug) }}"
                                :class="activePath.includes('/ministry') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center w-full h-12 rounded-xl transition-all group relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-sitemap text-lg"></i>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/ministry') ? 'text-white' : 'text-gray-700'">
                                    Administrative
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Administrative</span>
                            </a>
                        </li>
                    </ul>
                </aside>
                {{-- Main Content --}}
                <main class="flex-1 p-4 bg-gray-50 min-h-screen overflow-y-auto">
                    <x-dialog />
                    <x-toast />
                    @yield('content')
                </main>
            </div>
        </div>
            @livewire('ai-chat')
    </body>

        @livewireScripts
        {{-- Livewire Reactive Element Handler Script --}}
        <script>
            Livewire.on('close-modal-create', () => {
                $modalClose('modal-create');
            });
            Livewire.on('close-modal-update', () => {
                $modalClose('modal-update');
            });
            Livewire.on('close-modal-delete', () => {
                $modalClose('modal-delete');
            });
            Livewire.on('close-modal-edit-profile', () => {
                $modalClose('modal-edit-profile');
            });
            Livewire.on('close-modal-change-password', () => {
                $modalClose('modal-change-password');
            });
            Livewire.on('close-modal-ai', () => {
                $modalClose('modal-ai');
            });
            Livewire.on('open-modal-ai', () => {
                $modalOpen('modal-ai');
            });
        </script>
        <style>
            /* Tooltip */
            .tooltip {
                position: absolute;
                left: 100%;
                margin-left: 0.5rem;
                background-color: #111827;
                color: white;
                padding: 0.25rem 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.75rem;
                white-space: nowrap;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s;
            }
            .sidebar-item:hover .tooltip {
                opacity: 1;
            }
        </style>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('sidebarData', () => ({
                    activePage: window.location.pathname,
                    $modalOpen(modalId) {
                        console.log('Opening modal:', modalId);
                    }
                }));
            });
        </script>
        <!-- SortableJS for Drag and Drop -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    </body>
</html>
