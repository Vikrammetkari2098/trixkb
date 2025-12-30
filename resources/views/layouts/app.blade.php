<!DOCTYPE html>
<html lang="en" data-theme="light">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>TrixKB</title>

        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- AnyChart -->
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-gantt.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" rel="stylesheet">
        <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>[x-cloak] { display: none !important; }</style>
    </head>

    <body id="page-top" class="bg-gray-50">

        <div x-data="{ activePage: window.location.pathname, sidebarOpen: false }"
            x-init="
                activePage = window.location.pathname;
                document.addEventListener('livewire:navigated', () => {
                    activePage = window.location.pathname;
                });
            "
            class="flex flex-col min-h-screen">

            {{-- Top Navbar --}}
            @include('layouts.navbar')

            <div class="flex flex-1 min-h-[calc(100vh-40px)]">

                {{-- Sidebar --}}
                <aside id="with-navbar-sidebar"
                :class="{
                        'translate-x-0 w-64': sidebarOpen,
                        '-translate-x-full sm:translate-x-0 w-24': !sidebarOpen
                    }"
                    class="flex flex-col items-center py-4 space-y-2 bg-white shadow-lg
                w-24 sticky top-[45px] h-185 overflow-visible z-20">


                {{-- New: Toggle Button (The "Arrow") --}}
                    <div class="w-full px-2 mb-2">
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="p-2 rounded-lg text-gray-500  w-full flex transition-colors duration-200"
                            :class="{ 'justify-between': sidebarOpen, 'justify-center': !sidebarOpen }">
                            <span x-show="sidebarOpen" x-transition class="ml-3 whitespace-nowrap flex items-center">
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#09325d" :class="{'hidden': sidebarOpen}">
                            <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                            </svg>
                            <i class="fas fa-chevron-left text-xl text-[#09325d] transition-transform" x-show="sidebarOpen" :class="sidebarOpen ? 'rotate-0' : 'rotate-180'"></i>
                      </button>
                  </div>

                    <ul class="menu p-0 space-y-2 w-full" x-data="{ activePath: window.location.pathname }">

                        {{-- Dashboard --}}
                        <li class="relative group w-full px-2"
                            x-data="{ open: false, timeout: null }"
                            @mouseenter="clearTimeout(timeout); open = true"
                            @mouseleave="timeout = setTimeout(() => open = false, 200)">

                            <a href="{{ route('dashboard') }}"
                            :class="activePath === '/' || activePath === '/dashboard'
                                            ? 'bg-[#09325d] text-white shadow-md'
                                            : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"fill="none"
                                        :class="activePath === '/' || activePath === '/dashboard'
                                                ? 'text-white'
                                                : 'text-gray-900 group-hover:text-gray-900'"
                                        class="size-7 text-lg"
                                    >
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M21 18.8739V10.8663C21 9.88216 20.5726 8.95316 19.8418 8.34896L14.4558 3.89571C13.0113 2.70143 10.9887 2.70143 9.54424 3.89571L4.15818 8.34896C3.42742 8.95316 3 9.88216 3 10.8663V18.8739C3 20.0481 3.89543 21 5 21H7C8.10457 21 9 20.1046 9 19V15.6848C9 14.5106 9.89543 13.5587 11 13.5587H13C14.1046 13.5587 15 14.5106 15 15.6848V19C15 20.1046 15.8954 21 17 21H19C20.1046 21 21 20.0481 21 18.8739Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath === '/' || activePath === '/dashboard'
                                                    ? 'text-white'
                                                    : 'text-gray-700'">
                                    Dashboard
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                     Dashboard
                                </span>
                            </a>

                            {{-- Dashboard Hover Menu --}}
                        <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                x-cloak   class="absolute left-full top-0 ml-0 w-40 bg-white rounded-lg z-30 py-2 pointer-events-auto">
                                <div class="w-40 bg-white rounded-lg shadow-xl py-2">
                                    <div class="px-4 py-2 text-xs font-semibold uppercase text-gray-500 border-b">
                                        HOME
                                    </div>

                                    <ul class="space-y-1">
                                        <li><a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-th-large mr-3"></i> Overview
                                        </a></li>

                                        <li><a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-check-square mr-3"></i> Tasks
                                        </a></li>

                                        <li><a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-clock mr-3"></i> Recent
                                        </a></li>
                                    </ul>

                                    <hr class="my-1 border-gray-200">

                                    <ul class="space-y-1">
                                        <li><a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-star mr-3"></i> Starred
                                        </a></li>

                                        <li><a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-trash-alt mr-3"></i> Recycle Bin
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        {{-- Docs --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('docs') }}"
                            :class="activePath.includes('/docs')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        :class="activePath.includes('/docs')
                                                ? 'text-white'
                                                : 'text-gray-900 group-hover:text-gray-900'"
                                        class="size-7 text-lg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.1519V19.3095C3.99197 18.8639 5.40415 18.4 7 18.4C8.58915 18.4 9.9999 18.8602 11 19.3094V6.1519C10.7827 6.02653 10.4894 5.8706 10.1366 5.71427C9.31147 5.34869 8.20352 5 7 5C5.26385 5 3.74016 5.72499 3 6.1519ZM13 6.1519V19.3578C13.9977 18.9353 15.41 18.5 17 18.5C18.596 18.5 20.0095 18.9383 21 19.3578V6.1519C20.2598 5.72499 18.7362 5 17 5C15.7965 5 14.6885 5.34869 13.8634 5.71427C13.5106 5.8706 13.2173 6.02653 13 6.1519ZM12 4.41985C11.7302 4.26422 11.3734 4.07477 10.9468 3.88572C9.96631 3.45131 8.57426 3 7 3C4.69187 3 2.76233 3.97065 1.92377 4.46427C1.30779 4.82687 1 5.47706 1 6.11223V20.0239C1 20.6482 1.36945 21.1206 1.79531 21.3588C2.21653 21.5943 2.78587 21.6568 3.30241 21.3855C4.12462 20.9535 5.48348 20.4 7 20.4C8.90549 20.4 10.5523 21.273 11.1848 21.6619C11.6757 21.9637 12.2968 21.9725 12.7959 21.6853C13.4311 21.32 15.0831 20.5 17 20.5C18.5413 20.5 19.9168 21.0305 20.7371 21.4366C21.6885 21.9075 23 21.2807 23 20.0593V6.11223C23 5.47706 22.6922 4.82687 22.0762 4.46427C21.2377 3.97065 19.3081 3 17 3C15.4257 3 14.0337 3.45131 13.0532 3.88572C12.6266 4.07477 12.2698 4.26422 12 4.41985Z" fill="currentColor"></path>
                                        </g>
                                    </svg>
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
                                    Documentation
                                </span>
                            </a>
                        </li>

                        {{-- Decision Tree --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('decision.tree') }}"
                            :class="activePath.includes('/decision-tree')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        :class="activePath.includes('/decision-tree')
                                                ? 'text-white'
                                                : 'text-gray-900 group-hover:text-gray-900'"
                                        class="size-7 text-lg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>share-nodes</title>
                                            <path d="M26 20.75c-1.594 0.006-3.019 0.726-3.972 1.856l-0.006 0.008-10.91-5.455c0.088-0.348 0.139-0.747 0.139-1.159s-0.050-0.811-0.146-1.193l0.007 0.034 10.911-5.455c0.963 1.109 2.374 1.806 3.949 1.806 2.883 0 5.221-2.338 5.221-5.221s-2.337-5.221-5.221-5.221c-2.883 0-5.221 2.337-5.221 5.221 0 0.010 0 0.020 0 0.031v-0.002c0.003 0.412 0.053 0.811 0.146 1.194l-0.007-0.036-10.911 5.455c-0.969-1.143-2.406-1.864-4.012-1.864-2.9 0-5.25 2.351-5.25 5.25s2.351 5.25 5.25 5.25c1.606 0 3.043-0.721 4.006-1.857l0.006-0.008 10.911 5.455c-0.082 0.347-0.129 0.745-0.129 1.154 0 2.897 2.348 5.245 5.245 5.245s5.245-2.348 5.245-5.245c0-2.897-2.348-5.245-5.245-5.245-0.002 0-0.004 0-0.005 0h0zM26 3.25c1.519 0 2.75 1.231 2.75 2.75s-1.231 2.75-2.75 2.75c-1.519 0-2.75-1.231-2.75-2.75v0c0.002-1.518 1.232-2.748 2.75-2.75h0zM6 18.75c-1.519 0-2.75-1.231-2.75-2.75s1.231-2.75 2.75-2.75c1.519 0 2.75 1.231 2.75 2.75v0c-0.002 1.518-1.232 2.748-2.75 2.75h-0zM26 28.75c-1.519 0-2.75-1.231-2.75-2.75s1.231-2.75 2.75-2.75c1.519 0 2.75 1.231 2.75 2.75v0c-0.002 1.518-1.232 2.748-2.75 2.75h-0z"></path>
                                        </g>
                                    </svg>
                                </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/decision-tree')
                                                ? 'text-white'
                                                : 'text-gray-700'">
                                    Decision Tree
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Interactive Decision Tree
                                </span>
                            </a>
                        </li>

                        {{-- API Docs --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('api.docs') }}"
                            :class="activePath.includes('/api-docs')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                            <div class="flex justify-center items-center w-12 h-12">
                                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        :class="activePath.includes('/api-docs')
                                                ? 'text-white'
                                                : 'text-gray-900 group-hover:text-gray-900'"
                                        class="size-7 text-lg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M16 4C14 4 11 5 11 9C11 13 11 15 11 18C11 21 6 23 6 23C6 23 11 25 11 28C11 31 11 35 11 39C11 43 14 44 16 44" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M32 4C34 4 37 5 37 9C37 13 37 15 37 18C37 21 42 23 42 23C42 23 37 25 37 28C37 31 37 35 37 39C37 43 34 44 32 44" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/api-docs') ? 'text-white' : 'text-gray-700'">
                                    API Documentation
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    API Documentation
                                </span>
                            </a>
                        </li>

                        {{-- Feedback Manager --}}


                        <li class="relative w-full px-2"
                            x-data="{ openFM: false, timeoutId: null }"
                            @mouseenter="clearTimeout(timeoutId); openFM = true"
                            @mouseleave="timeoutId = setTimeout(() => openFM = false, 250)">

                            <a href="{{ route('feedback.index') }}"
                            :class="activePath.includes('/feedback')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative group">

                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        :class="activePath.includes('/feedback')
                                                ? 'text-white'
                                                : 'text-gray-900 group-hover:text-gray-900'"
                                        class="size-7 text-lg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </div>
                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/feedback')
                                                ? 'text-white'
                                                : 'text-gray-700'">
                                    Feedback Manager
                                </span>
                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Feedback Manager
                                </span>
                            </a>

                            {{-- Feedback Dropdown --}}
                            <div x-show.immediate="openFM"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                x-cloak   class="absolute left-full top-0 ml-0 w-40 bg-white rounded-lg z-30 py-2 pointer-events-auto">


                                <div class="w-40 bg-white rounded-lg shadow-xl py-2">
                            <div class="px-4 py-2 text-xs font-semibold uppercase text-gray-500 border-b whitespace-nowrap">
                                    FEEDBACK MANAGER
                            </div>

                                    <ul class="space-y-1">

                                        <li class="rounded-lg hover:bg-white">
                                            <a href="{{ route('feedback.index') }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <i class="fas fa-book mr-3"></i> Articles
                                            </a>
                                        </li>

                                        <li class="rounded-lg hover:bg-white">
                                            <a href="{{ route('feedback.index', ['viewMode' => 'eddy-ai']) }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <img src="{{ asset('image/icon.png') }}" class="w-5 h-5 mr-3">
                                                Eddy AI
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </li>

                        {{-- Analytics --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('analytics') }}"
                            :class="activePath.includes('/analytics')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            :class="activePath.includes('/analytics')
                                                    ? 'text-white'
                                                    : 'text-gray-900 group-hover:text-gray-900'"
                                            class="size-7 text-sm">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M21 21H4.6C4.03995 21 3.75992 21 3.54601 20.891C3.35785 20.7951 3.20487 20.6422 3.10899 20.454C3 20.2401 3 19.9601 3 19.4V3M20 8L16.0811 12.1827C15.9326 12.3412 15.8584 12.4204 15.7688 12.4614C15.6897 12.4976 15.6026 12.5125 15.516 12.5047C15.4179 12.4958 15.3215 12.4458 15.1287 12.3457L11.8713 10.6543C11.6785 10.5542 11.5821 10.5042 11.484 10.4953C11.3974 10.4875 11.3103 10.5024 11.2312 10.5386C11.1416 10.5796 11.0674 10.6588 10.9189 10.8173L7 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/analytics') ? 'text-white' : 'text-gray-700'">
                                    Analytics
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Analytics
                                </span>
                            </a>
                        </li>

                        {{-- Knowledge Pulse --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('knowledge.pulse') }}"
                            :class="activePath.includes('/knowledge-pulse')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        :class="activePath.includes('/knowledge-pulse')
                                                ? 'text-white'
                                                : 'text-gray-900 group-hover:text-gray-900'"
                                        class="size-7 text-lg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                    </svg>
                                </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/knowledge-pulse') ? 'text-white' : 'text-gray-700'">
                                    Knowledge Pulse
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Knowledge Pulse
                                </span>
                            </a>
                        </li>

                        {{-- Widget --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('widget') }}"
                            :class="activePath.includes('/widget')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            :class="activePath.includes('/widget')
                                                    ? 'fill-none stroke-white'
                                                    : 'fill-none stroke-gray-900 group-hover:stroke-gray-800'"
                                            class="size-7 text-lg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M17 14V20M14 17H20M15.6 10H18.4C18.9601 10 19.2401 10 19.454 9.89101C19.6422 9.79513 19.7951 9.64215 19.891 9.45399C20 9.24008 20 8.96005 20 8.4V5.6C20 5.03995 20 4.75992 19.891 4.54601C19.7951 4.35785 19.6422 4.20487 19.454 4.10899C19.2401 4 18.9601 4 18.4 4H15.6C15.0399 4 14.7599 4 14.546 4.10899C14.3578 4.20487 14.2049 4.35785 14.109 4.54601C14 4.75992 14 5.03995 14 5.6V8.4C14 8.96005 14 9.24008 14.109 9.45399C14.2049 9.64215 14.3578 9.79513 14.546 9.89101C14.7599 10 15.0399 10 15.6 10ZM5.6 10H8.4C8.96005 10 9.24008 10 9.45399 9.89101C9.64215 9.79513 9.79513 9.64215 9.89101 9.45399C10 9.24008 10 8.96005 10 8.4V5.6C10 5.03995 10 4.75992 9.89101 4.54601C9.79513 4.35785 9.64215 4.20487 9.45399 4.10899C9.24008 4 8.96005 4 8.4 4H5.6C5.03995 4 4.75992 4 4.54601 4.10899C4.35785 4.20487 4.20487 4.35785 4.10899 4.54601C4 4.75992 4 5.03995 4 5.6V8.4C4 8.96005 4 9.24008 4.10899 9.45399C4.20487 9.64215 4.35785 9.79513 4.54601 9.89101C4.75992 10 5.03995 10 5.6 10ZM5.6 20H8.4C8.96005 20 9.24008 20 9.45399 19.891C9.64215 19.7951 9.79513 19.6422 9.89101 19.454C10 19.2401 10 18.9601 10 18.4V15.6C10 15.0399 10 14.7599 9.89101 14.546C9.79513 14.3578 9.64215 14.2049 9.45399 14.109C10 14 8.96005 14 8.4 14H5.6C5.03995 14 4.75992 14 4.54601 14.109C4.35785 14.2049 4.20487 14.3578 4.10899 14.546C4 14.7599 4 15.0399 4 15.6V18.4C4 18.9601 4 19.2401 4.10899 19.454C4.20487 19.6422 4.35785 19.7951 4.54601 19.891C4.75992 20 5.03995 20 5.6 20Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                    </div>

                               <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/widget') ? 'text-white' : 'text-gray-700'">
                                    Widget
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Widget
                                </span>
                            </a>
                        </li>

                        {{-- Drive --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('drive') }}"
                            :class="activePath.includes('/drive')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12 group">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    :class="activePath.includes('/drive')
                                        ? 'text-white'
                                        : 'text-gray-900'"
                                    class="size-7 text-lg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15h14M5 15v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4M5 15V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10m-6 3h3"></path>
                                    </g>
                                </svg>
                            </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/drive') ? 'text-white' : 'text-gray-700'">
                                    Drive
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Drive
                                </span>
                            </a>
                        </li>

                        {{-- Settings --}}
                        <li class="relative group w-full px-2 py-30">
                            <a href="{{ route('settings') }}"
                            :class="activePath.includes('/settings')
                                        ? 'bg-[#09325d] text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                            <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    :class="activePath.includes('/settings')
                                            ? 'text-white'
                                            : 'text-gray-900 group-hover:text-gray-900'"
                                    class="size-7 text-lg"
                                >
                                    <g id="SVGRepo_iconCarrier">
                                        <g id="style=linear">
                                            <g id="setting">
                                                <path
                                                    id="vector"
                                                    d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                    stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path
                                                    id="vector_2"
                                                    d="M2 12.88V11.12C2 10.08 2.85 9.22 3.9 9.22C5.71 9.22 6.45 7.94 5.54 6.37C5.02 5.47 5.33 4.3 6.24 3.78L7.97 2.79C8.76 2.32 9.78 2.6 10.25 3.39L10.36 3.58C11.26 5.15 12.74 5.15 13.65 3.58L13.76 3.39C14.23 2.6 15.25 2.32 16.04 2.79L17.77 3.78C18.68 4.3 18.99 5.47 18.47 6.37C17.56 7.94 18.3 9.22 20.11 9.22C21.15 9.22 22.01 10.07 22.01 11.12V12.88C22.01 13.92 21.16 14.78 20.11 14.78C18.3 14.78 17.56 16.06 18.47 17.63C18.99 18.54 18.68 19.7 17.77 20.22L16.04 21.21C15.25 21.68 14.23 21.4 13.76 20.61L13.65 20.42C12.75 18.85 11.27 18.85 10.36 20.42L10.25 20.61C9.78 21.4 8.76 21.68 7.97 21.21L6.24 20.22C5.33 19.7 5.02 18.53 5.54 17.63C6.45 16.06 5.71 14.78 3.9 14.78C2.85 14.78 2 13.92 2 12.88Z"
                                                    stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"
                                                />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>

                                <span x-show="sidebarOpen"
                                    x-transition:enter="transition ease-out duration-100 delay-50"
                                    x-transition:enter-start="opacity-0 translate-x-[-10px]"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/settings') ? 'text-white' : 'text-gray-700'">
                                    Settings
                                </span>

                                <span x-show="!sidebarOpen"
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                            opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                            z-50 top-1/2 -translate-y-1/2">
                                    Settings
                                </span>
                            </a>
                        </li>

                    </ul>
                </aside>

                {{-- Main Content --}}
                <main class="flex-1 bg-gray-50 min-h-screen overflow-y-auto">
                    <x-dialog />
                    <x-toast />
                    @yield('content')
                </main>

            </div>
        </div>

        @livewire('ai-chat')

        @livewireScripts

        {{-- Modal Close Handling --}}
        <script>
            Livewire.on('close-modal-create', () => $modalClose('modal-create'));
            Livewire.on('close-modal-update', () => $modalClose('modal-update'));
            Livewire.on('close-modal-delete', () => $modalClose('modal-delete'));
            Livewire.on('close-modal-edit-profile', () => $modalClose('modal-edit-profile'));
            Livewire.on('close-modal-change-password', () => $modalClose('modal-change-password'));
            Livewire.on('close-modal-ai', () => $modalClose('modal-ai'));
            Livewire.on('open-modal-ai', () => $modalOpen('modal-ai'));
        </script>

        <style>
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

        <!-- SortableJS -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
            <div x-data="{ openSide: false }"
            x-on:open-side.window="openSide = true">

            <!-- Overlay -->
            <div
                x-cloak
                x-show="openSide"
                x-transition
                class="fixed inset-0 bg-black/40 z-[999] flex justify-end"
            >
                <!-- SIDE PANEL -->
                <div class="w-full bg-white h-full shadow-xl overflow-y-auto">
                    <livewire:document.partial.doc-open-site />
                </div>
            </div>
        </div>
    </body>
</html>
