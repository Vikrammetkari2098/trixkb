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

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    [x-cloak] { display: none !important; } 
</style>
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
               class="flex flex-col items-center py-4 space-y-2 bg-white shadow-lg
           w-24 sticky top-[45px] h-185 overflow-visible z-20">

            <ul class="menu p-0 space-y-2 w-full" x-data="{ activePath: window.location.pathname }">

                {{-- Dashboard --}}
                <li class="relative group w-full px-2"
                    x-data="{ open: false, timeout: null }"
                    @mouseenter="clearTimeout(timeout); open = true"
                    @mouseleave="timeout = setTimeout(() => open = false, 200)">
                                    
                    <a href="{{ route('dashboard') }}"
                       :class="activePath === '/' || activePath === '/dashboard'
                                    ? 'bg-gray-100 text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                :class="activePath === '/' || activePath === '/dashboard'
                                        ? 'text-purple-600' 
                                        : 'text-gray-900 group-hover:text-gray-900'" 
                                class="size-7 text-lg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3103 1.77586C11.6966 1.40805 12.3034 1.40805 12.6897 1.77586L20.6897 9.39491L23.1897 11.7759C23.5896 12.1567 23.605 12.7897 23.2241 13.1897C22.8433 13.5896 22.2103 13.605 21.8103 13.2241L21 12.4524V20C21 21.1046 20.1046 22 19 22H14H10H5C3.89543 22 3 21.1046 3 20V12.4524L2.18966 13.2241C1.78972 13.605 1.15675 13.5896 0.775862 13.1897C0.394976 12.7897 0.410414 12.1567 0.810345 11.7759L3.31034 9.39491L11.3103 1.77586ZM5 10.5476V20H9V15C9 13.3431 10.3431 12 12 12C13.6569 12 15 13.3431 15 15V20H19V10.5476L12 3.88095L5 10.5476ZM13 20V15C13 14.4477 12.5523 14 12 14C11.4477 14 11 14.4477 11 15V20H13Z" fill="currentColor"></path> 
                                </g>
                            </svg>
                        </div>

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath === '/' || activePath === '/dashboard'
                                            ? 'text-white'
                                            : 'text-gray-700'">
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                :class="activePath.includes('/docs')
                                        ? 'text-purple-600' 
                                        : 'text-gray-900 group-hover:text-gray-900'" 
                                class="size-7 text-lg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.1519V19.3095C3.99197 18.8639 5.40415 18.4 7 18.4C8.58915 18.4 9.9999 18.8602 11 19.3094V6.1519C10.7827 6.02653 10.4894 5.8706 10.1366 5.71427C9.31147 5.34869 8.20352 5 7 5C5.26385 5 3.74016 5.72499 3 6.1519ZM13 6.1519V19.3578C13.9977 18.9353 15.41 18.5 17 18.5C18.596 18.5 20.0095 18.9383 21 19.3578V6.1519C20.2598 5.72499 18.7362 5 17 5C15.7965 5 14.6885 5.34869 13.8634 5.71427C13.5106 5.8706 13.2173 6.02653 13 6.1519ZM12 4.41985C11.7302 4.26422 11.3734 4.07477 10.9468 3.88572C9.96631 3.45131 8.57426 3 7 3C4.69187 3 2.76233 3.97065 1.92377 4.46427C1.30779 4.82687 1 5.47706 1 6.11223V20.0239C1 20.6482 1.36945 21.1206 1.79531 21.3588C2.21653 21.5943 2.78587 21.6568 3.30241 21.3855C4.12462 20.9535 5.48348 20.4 7 20.4C8.90549 20.4 10.5523 21.273 11.1848 21.6619C11.6757 21.9637 12.2968 21.9725 12.7959 21.6853C13.4311 21.32 15.0831 20.5 17 20.5C18.5413 20.5 19.9168 21.0305 20.7371 21.4366C21.6885 21.9075 23 21.2807 23 20.0593V6.11223C23 5.47706 22.6922 4.82687 22.0762 4.46427C21.2377 3.97065 19.3081 3 17 3C15.4257 3 14.0337 3.45131 13.0532 3.88572C12.6266 4.07477 12.2698 4.26422 12 4.41985Z" fill="currentColor"></path> 
                                </g>
                            </svg>
                        </div>
                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/docs') ? 'text-white' : 'text-gray-700'">
                            Docs
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded 
                                     opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                     whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                            Documentation
                        </span>
                    </a>
                </li>

                {{-- Decision Tree --}}
                <li class="relative group w-full px-2">
                    <a href="{{ route('decision.tree') }}"
                       :class="activePath.includes('/decision-tree')
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                            <svg fill="currentColor" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" 
                                :class="activePath.includes('/decision-tree')
                                        ? 'text-purple-600' 
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

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/decision-tree')
                                        ? 'text-white'
                                        : 'text-gray-700'">
                            Interactive Decision Tree
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                       <div class="flex justify-center items-center w-12 h-12">
                            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                                :class="activePath.includes('/api-docs')
                                        ? 'text-purple-600' 
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

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/api-docs') ? 'text-white' : 'text-gray-700'">
                            API Documentation
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative group">

                        <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" 
                                :class="activePath.includes('/feedback')
                                        ? 'text-purple-600' 
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    :class="activePath.includes('/analytics')
                                            ? 'text-purple-600' 
                                            : 'text-gray-900 group-hover:text-gray-900'" 
                                    class="size-7 text-sm">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M21 21H4.6C4.03995 21 3.75992 21 3.54601 20.891C3.35785 20.7951 3.20487 20.6422 3.10899 20.454C3 20.2401 3 19.9601 3 19.4V3M20 8L16.0811 12.1827C15.9326 12.3412 15.8584 12.4204 15.7688 12.4614C15.6897 12.4976 15.6026 12.5125 15.516 12.5047C15.4179 12.4958 15.3215 12.4458 15.1287 12.3457L11.8713 10.6543C11.6785 10.5542 11.5821 10.5042 11.484 10.4953C11.3974 10.4875 11.3103 10.5024 11.2312 10.5386C11.1416 10.5796 11.0674 10.6588 10.9189 10.8173L7 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                            </div>

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/analytics') ? 'text-white' : 'text-gray-700'">
                            Analytics
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                :class="activePath.includes('/knowledge-pulse')
                                        ? 'text-purple-600' 
                                        : 'text-gray-900 group-hover:text-gray-900'" 
                                class="size-7 text-lg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                            </svg>
                        </div>

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/knowledge-pulse') ? 'text-white' : 'text-gray-700'">
                            Knowledge Pulse
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    :class="activePath.includes('/widget')
                                            ? 'fill-none stroke-purple-600'
                                            : 'fill-none stroke-gray-900 group-hover:stroke-gray-800'" 
                                    class="size-7 text-lg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M17 14V20M14 17H20M15.6 10H18.4C18.9601 10 19.2401 10 19.454 9.89101C19.6422 9.79513 19.7951 9.64215 19.891 9.45399C20 9.24008 20 8.96005 20 8.4V5.6C20 5.03995 20 4.75992 19.891 4.54601C19.7951 4.35785 19.6422 4.20487 19.454 4.10899C19.2401 4 18.9601 4 18.4 4H15.6C15.0399 4 14.7599 4 14.546 4.10899C14.3578 4.20487 14.2049 4.35785 14.109 4.54601C14 4.75992 14 5.03995 14 5.6V8.4C14 8.96005 14 9.24008 14.109 9.45399C14.2049 9.64215 14.3578 9.79513 14.546 9.89101C14.7599 10 15.0399 10 15.6 10ZM5.6 10H8.4C8.96005 10 9.24008 10 9.45399 9.89101C9.64215 9.79513 9.79513 9.64215 9.89101 9.45399C10 9.24008 10 8.96005 10 8.4V5.6C10 5.03995 10 4.75992 9.89101 4.54601C9.79513 4.35785 9.64215 4.20487 9.45399 4.10899C9.24008 4 8.96005 4 8.4 4H5.6C5.03995 4 4.75992 4 4.54601 4.10899C4.35785 4.20487 4.20487 4.35785 4.10899 4.54601C4 4.75992 4 5.03995 4 5.6V8.4C4 8.96005 4 9.24008 4.10899 9.45399C4.20487 9.64215 4.35785 9.79513 4.54601 9.89101C4.75992 10 5.03995 10 5.6 10ZM5.6 20H8.4C8.96005 20 9.24008 20 9.45399 19.891C9.64215 19.7951 9.79513 19.6422 9.89101 19.454C10 19.2401 10 18.9601 10 18.4V15.6C10 15.0399 10 14.7599 9.89101 14.546C9.79513 14.3578 9.64215 14.2049 9.45399 14.109C10 14 8.96005 14 8.4 14H5.6C5.03995 14 4.75992 14 4.54601 14.109C4.35785 14.2049 4.20487 14.3578 4.10899 14.546C4 14.7599 4 15.0399 4 15.6V18.4C4 18.9601 4 19.2401 4.10899 19.454C4.20487 19.6422 4.35785 19.7951 4.54601 19.891C4.75992 20 5.03995 20 5.6 20Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                            </div>

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/widget') ? 'text-white' : 'text-gray-700'">
                            Widget
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
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
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                        <div class="flex justify-center items-center w-12 h-12 group">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            :class="activePath.includes('/drive')
                                ? 'text-purple-600' 
                                : 'text-gray-900'" 
                            class="size-7 text-lg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <path stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15h14M5 15v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4M5 15V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10m-6 3h3"></path>
                            </g>
                        </svg>
                    </div>

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/drive') ? 'text-white' : 'text-gray-700'">
                            Drive
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                     opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                     z-50 top-1/2 -translate-y-1/2">
                            Drive
                        </span>
                    </a>
                </li>

                {{-- Settings --}}
                <li class="relative group w-full px-2 py-40">
                    <a href="{{ route('settings') }}"
                       :class="activePath.includes('/settings')
                                ? 'bg-gray-100 text-white shadow-md'
                                : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                       class="flex items-center w-full h-12 rounded-xl transition-all relative">

                       <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                :class="activePath.includes('/settings')
                                        ? 'text-purple-600' 
                                        : 'text-gray-900 group-hover:text-gray-900'" 
                                class="size-7 text-lg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8.00002C9.79085 8.00002 7.99999 9.79088 7.99999 12C7.99999 14.2092 9.79085 16 12 16C14.2091 16 16 14.2092 16 12C16 9.79088 14.2091 8.00002 12 8.00002ZM9.99999 12C9.99999 10.8955 10.8954 10 12 10C13.1046 10 14 10.8955 14 12C14 13.1046 13.1046 14 12 14C10.8954 14 9.99999 13.1046 9.99999 12Z" fill="currentColor"></path> 
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8.00002C9.79085 8.00002 7.99999 9.79088 7.99999 12C7.99999 14.2092 9.79085 16 12 16C14.2091 16 16 14.2092 16 12C16 9.79088 14.2091 8.00002 12 8.00002ZM9.99999 12C9.99999 10.8955 10.8954 10 12 10C13.1046 10 14 10.8955 14 12C14 13.1046 13.1046 14 12 14C10.8954 14 9.99999 13.1046 9.99999 12Z" fill="currentColor"></path> 
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7673 1.01709C10.9925 0.999829 11.2454 0.99993 11.4516 1.00001L12.5484 1.00001C12.7546 0.99993 13.0075 0.999829 13.2327 1.01709C13.4989 1.03749 13.8678 1.08936 14.2634 1.26937C14.7635 1.49689 15.1915 1.85736 15.5007 2.31147C15.7454 2.67075 15.8592 3.0255 15.9246 3.2843C15.9799 3.50334 16.0228 3.75249 16.0577 3.9557L16.1993 4.77635L16.2021 4.77788C16.2369 4.79712 16.2715 4.81659 16.306 4.8363L16.3086 4.83774L17.2455 4.49865C17.4356 4.42978 17.6693 4.34509 17.8835 4.28543C18.1371 4.2148 18.4954 4.13889 18.9216 4.17026C19.4614 4.20998 19.9803 4.39497 20.4235 4.70563C20.7734 4.95095 21.0029 5.23636 21.1546 5.4515C21.2829 5.63326 21.4103 5.84671 21.514 6.02029L22.0158 6.86003C22.1256 7.04345 22.2594 7.26713 22.3627 7.47527C22.4843 7.7203 22.6328 8.07474 22.6777 8.52067C22.7341 9.08222 22.6311 9.64831 22.3803 10.1539C22.1811 10.5554 21.9171 10.8347 21.7169 11.0212C21.5469 11.1795 21.3428 11.3417 21.1755 11.4746L20.5 12L21.1755 12.5254C21.3428 12.6584 21.5469 12.8205 21.7169 12.9789C21.9171 13.1653 22.1811 13.4446 22.3802 13.8461C22.631 14.3517 22.7341 14.9178 22.6776 15.4794C22.6328 15.9253 22.4842 16.2797 22.3626 16.5248C22.2593 16.7329 22.1255 16.9566 22.0158 17.14L21.5138 17.9799C21.4102 18.1535 21.2828 18.3668 21.1546 18.5485C21.0028 18.7637 20.7734 19.0491 20.4234 19.2944C19.9803 19.6051 19.4613 19.7901 18.9216 19.8298C18.4954 19.8612 18.1371 19.7852 17.8835 19.7146C17.6692 19.6549 17.4355 19.5703 17.2454 19.5014L16.3085 19.1623L16.306 19.1638C16.2715 19.1835 16.2369 19.2029 16.2021 19.2222L16.1993 19.2237L16.0577 20.0443C16.0228 20.2475 15.9799 20.4967 15.9246 20.7157C15.8592 20.9745 15.7454 21.3293 15.5007 21.6886C15.1915 22.1427 14.7635 22.5032 14.2634 22.7307C13.8678 22.9107 13.4989 22.9626 13.2327 22.983C13.0074 23.0002 12.7546 23.0001 12.5484 23H11.4516C11.2454 23.0001 10.9925 23.0002 10.7673 22.983C10.5011 22.9626 10.1322 22.9107 9.73655 22.7307C9.23648 22.5032 8.80849 22.1427 8.49926 21.6886C8.25461 21.3293 8.14077 20.9745 8.07542 20.7157C8.02011 20.4967 7.97723 20.2475 7.94225 20.0443L7.80068 19.2237L7.79791 19.2222C7.7631 19.2029 7.72845 19.1835 7.69396 19.1637L7.69142 19.1623L6.75458 19.5014C6.5645 19.5702 6.33078 19.6549 6.11651 19.7146C5.86288 19.7852 5.50463 19.8611 5.07841 19.8298C4.53866 19.7901 4.01971 19.6051 3.57654 19.2944C3.2266 19.0491 2.99714 18.7637 2.84539 18.5485C2.71718 18.3668 2.58974 18.1534 2.4861 17.9798L1.98418 17.14C1.87447 16.9566 1.74067 16.7329 1.63737 16.5248C1.51575 16.2797 1.36719 15.9253 1.32235 15.4794C1.26588 14.9178 1.36897 14.3517 1.61976 13.8461C1.81892 13.4446 2.08289 13.1653 2.28308 12.9789C2.45312 12.8205 2.65717 12.6584 2.82449 12.5254L3.47844 12.0054V11.9947L2.82445 11.4746C2.65712 11.3417 2.45308 11.1795 2.28304 11.0212C2.08285 10.8347 1.81888 10.5554 1.61972 10.1539C1.36893 9.64832 1.26584 9.08224 1.3223 8.52069C1.36714 8.07476 1.51571 7.72032 1.63732 7.47528C1.74062 7.26715 1.87443 7.04347 1.98414 6.86005L2.48605 6.02026C2.58969 5.84669 2.71714 5.63326 2.84534 5.45151C2.9971 5.23637 3.22655 4.95096 3.5765 4.70565C4.01966 4.39498 4.53862 4.20999 5.07837 4.17027C5.50458 4.1389 5.86284 4.21481 6.11646 4.28544C6.33072 4.34511 6.56444 4.4298 6.75451 4.49867L7.69141 4.83775L7.69394 4.8363C7.72844 4.8166 7.7631 4.79712 7.79791 4.77788L7.80068 4.77635L7.94225 3.95571C7.97723 3.7525 8.02011 3.50334 8.07542 3.2843C8.14077 3.0255 8.25461 2.67075 8.49926 2.31147C8.80849 1.85736 9.23648 1.49689 9.73655 1.26937C10.1322 1.08936 10.5011 1.03749 10.7673 1.01709ZM14.0938 4.3363C14.011 3.85634 13.9696 3.61637 13.8476 3.43717C13.7445 3.2858 13.6019 3.16564 13.4352 3.0898C13.2378 3.00002 12.9943 3.00002 12.5073 3.00002H11.4927C11.0057 3.00002 10.7621 3.00002 10.5648 3.0898C10.3981 3.16564 10.2555 3.2858 10.1524 3.43717C10.0304 3.61637 9.98895 3.85634 9.90615 4.3363L9.75012 5.24064C9.69445 5.56333 9.66662 5.72467 9.60765 5.84869C9.54975 5.97047 9.50241 6.03703 9.40636 6.13166C9.30853 6.22804 9.12753 6.3281 8.76554 6.52822C8.73884 6.54298 8.71227 6.55791 8.68582 6.57302C8.33956 6.77078 8.16643 6.86966 8.03785 6.90314C7.91158 6.93602 7.83293 6.94279 7.70289 6.93196C7.57049 6.92094 7.42216 6.86726 7.12551 6.7599L6.11194 6.39308C5.66271 6.2305 5.43809 6.14921 5.22515 6.16488C5.04524 6.17811 4.87225 6.23978 4.72453 6.34333C4.5497 6.46589 4.42715 6.67094 4.18206 7.08103L3.72269 7.84965C3.46394 8.2826 3.33456 8.49907 3.31227 8.72078C3.29345 8.90796 3.32781 9.09665 3.41141 9.26519C3.51042 9.4648 3.7078 9.62177 4.10256 9.9357L4.82745 10.5122C5.07927 10.7124 5.20518 10.8126 5.28411 10.9199C5.36944 11.036 5.40583 11.1114 5.44354 11.2504C5.47844 11.379 5.47844 11.586 5.47844 12C5.47844 12.414 5.47844 12.621 5.44354 12.7497C5.40582 12.8887 5.36944 12.9641 5.28413 13.0801C5.20518 13.1875 5.07927 13.2876 4.82743 13.4879L4.10261 14.0643C3.70785 14.3783 3.51047 14.5352 3.41145 14.7349C3.32785 14.9034 3.29349 15.0921 3.31231 15.2793C3.33461 15.501 3.46398 15.7174 3.72273 16.1504L4.1821 16.919C4.4272 17.3291 4.54974 17.5342 4.72457 17.6567C4.8723 17.7603 5.04528 17.8219 5.2252 17.8352C5.43813 17.8508 5.66275 17.7695 6.11199 17.607L7.12553 17.2402C7.42216 17.1328 7.5705 17.0791 7.7029 17.0681C7.83294 17.0573 7.91159 17.064 8.03786 17.0969C8.16644 17.1304 8.33956 17.2293 8.68582 17.427C8.71228 17.4421 8.73885 17.4571 8.76554 17.4718C9.12753 17.6719 9.30853 17.772 9.40635 17.8684C9.50241 17.963 9.54975 18.0296 9.60765 18.1514C9.66662 18.2754 9.69445 18.4367 9.75012 18.7594L9.90615 19.6637C9.98895 20.1437 10.0304 20.3837 10.1524 20.5629C10.2555 20.7142 10.3981 20.8344 10.5648 20.9102C10.7621 21 11.0057 21 11.4927 21H12.5073C12.9943 21 13.2378 21 13.4352 20.9102C13.6019 20.8344 13.7445 20.7142 13.8476 20.5629C13.9696 20.3837 14.011 20.1437 14.0938 19.6637L14.2499 18.7594C14.3055 18.4367 14.3334 18.2754 14.3923 18.1514C14.4502 18.0296 14.4976 17.963 14.5936 17.8684C14.6915 17.772 14.8725 17.6719 15.2344 17.4718C15.2611 17.4571 15.2877 17.4421 15.3141 17.427C15.6604 17.2293 15.8335 17.1304 15.9621 17.0969C16.0884 17.064 16.167 17.0573 16.2971 17.0681C16.4295 17.0791 16.5778 17.1328 16.8744 17.2402L17.888 17.607C18.3372 17.7696 18.5619 17.8509 18.7748 17.8352C18.9547 17.8219 19.1277 17.7603 19.2754 17.6567C19.4502 17.5342 19.5728 17.3291 19.8179 16.919L20.2773 16.1504C20.536 15.7175 20.6654 15.501 20.6877 15.2793C20.7065 15.0921 20.6721 14.9034 20.5885 14.7349C20.4895 14.5353 20.2921 14.3783 19.8974 14.0643L19.1726 13.4879C18.9207 13.2876 18.7948 13.1875 18.7159 13.0801C18.6306 12.9641 18.5942 12.8887 18.5564 12.7497C18.5215 12.6211 18.5215 12.414 18.5215 12C18.5215 11.586 18.5215 11.379 18.5564 11.2504C18.5942 11.1114 18.6306 11.036 18.7159 10.9199C18.7948 10.8126 18.9207 10.7124 19.1725 10.5122L19.8974 9.9357C20.2922 9.62176 20.4896 9.46479 20.5886 9.26517C20.6722 9.09664 20.7065 8.90795 20.6877 8.72076C20.6654 8.49906 20.5361 8.28259 20.2773 7.84964L19.8179 7.08102C19.5728 6.67093 19.4503 6.46588 19.2755 6.34332C19.1277 6.23977 18.9548 6.1781 18.7748 6.16486C18.5619 6.14919 18.3373 6.23048 17.888 6.39307L16.8745 6.75989C16.5778 6.86725 16.4295 6.92093 16.2971 6.93195C16.167 6.94278 16.0884 6.93601 15.9621 6.90313C15.8335 6.86965 15.6604 6.77077 15.3142 6.57302C15.2877 6.55791 15.2611 6.54298 15.2345 6.52822C14.8725 6.3281 14.6915 6.22804 14.5936 6.13166C14.4976 6.03703 14.4502 5.97047 14.3923 5.84869C14.3334 5.72467 14.3055 5.56332 14.2499 5.24064L14.0938 4.3363Z" fill="currentColor"></path> 
                                </g>
                            </svg>
                        </div>

                        <span class="hidden ml-2 font-medium whitespace-nowrap"
                              :class="activePath.includes('/settings') ? 'text-white' : 'text-gray-700'">
                            Settings
                        </span>

                        <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded
                                     opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200
                                     z-50 top-1/2 -translate-y-1/2">
                            Settings
                        </span>
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

</body>
</html>
