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
    </head>

    <body id="page-top" class="bg-gray-50">

       <div x-data="{ activePage: window.location.pathname, sidebarOpen: false }"
            x-init=" activePage = window.location.pathname; document.addEventListener('livewire:navigated', () => { activePage = window.location.pathname; }); "
            class="flex flex-col min-h-screen">

            {{-- Top Navbar --}}
            @include('layouts.navbar')

            <div class="flex flex-1 min-h-[calc(100vh-40px)]">
               <aside id="with-navbar-sidebar"
                    class="flex flex-col items-center py-4 space-y-2 bg-white shadow-lg min-h-screen z-20 -translate-x-full sm:translate-x-0 w-24">
                    <ul class="menu p-0 space-y-2 w-full" x-data="{ activePath: window.location.pathname }">

                        <li class="relative group w-full px-2" x-data="{ open: false, timeout: null }"
                            @mouseenter="clearTimeout(timeout); open = true"
                            @mouseleave="timeout = setTimeout(() => open = false, 200)">

                            <a href="{{ route('dashboard') }}"
                            :class="activePath === '/' || activePath === '/dashboard'
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">

                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-home text-lg"
                                    :class="activePath === '/' || activePath === '/dashboard'
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'">
                                    </i>
                                </div>

                                <span style="display: none;" class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath === '/' || activePath === '/dashboard' ? 'text-white' : 'text-gray-700'">
                                    Dashboard
                                </span>
                            </a>

                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2"
                                class="absolute left-full top-0 ml-0 w-40 bg-white rounded-lg z-30 py-2 pointer-events-auto">

                                <div class="w-40 bg-white rounded-lg shadow-xl py-2">
                                    <div class="px-4 py-2 text-xs font-semibold uppercase text-gray-500 border-b">
                                        HOME
                                    </div>
                                    <ul class="space-y-1">
                                        <li class="hover:bg-gray-100">
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <i class="fas fa-th-large mr-3"></i> Overview
                                            </a>
                                        </li>
                                        <li class="hover:bg-gray-100">
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <i class="fas fa-check-square mr-3"></i> Tasks
                                            </a>
                                        </li>
                                        <li class="hover:bg-gray-100">
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <i class="fas fa-clock mr-3"></i> Recent
                                            </a>
                                        </li>
                                    </ul>
                                    <hr class="my-1 border-gray-200">
                                    <ul class="space-y-1">
                                        <li class="hover:bg-gray-100">
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <i class="fas fa-star mr-3"></i> Starred
                                            </a>
                                        </li>
                                        <li class="hover:bg-gray-100">
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700">
                                                <i class="fas fa-trash-alt mr-3"></i> Recycle bin
                                            </a>
                                        </li>
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
                                    <i class="fas fa-book text-lg"
                                    :class="activePath.includes('/docs')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'">
                                    </i>
                                </div>
                                <span style="display: none;"class="ml-2 font-medium whitespace-nowrap" :class="activePath.includes('/docs') ? 'text-white' : 'text-gray-700'"> Docs </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Documentation</span>
                            </a>
                        </li>
                        {{-- Interactive Decision Tree --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('decision.tree') }}"
                            :class="activePath.includes('/decision-tree')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-project-diagram text-lg"
                                    :class="activePath.includes('/decision-tree')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/decision-tree') ? 'text-white' : 'text-gray-700'">
                                    Interactive Decision Tree
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                            group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                            top-1/2 -translate-y-1/2">
                                    Interactive Decision Tree
                                </span>
                            </a>
                        </li>

                        {{-- API Documentation --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('api.docs') }}"
                            :class="activePath.includes('/api-docs')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-code text-lg"
                                    :class="activePath.includes('/api-docs')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/api-docs') ? 'text-white' : 'text-gray-700'">
                                    API Documentation
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">API Documentation</span>
                            </a>
                        </li>

                        {{-- Feedback Manager --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('feedback.manager') }}"
                            :class="activePath.includes('/feedback')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-comment-dots text-lg"
                                    :class="activePath.includes('/feedback')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/feedback') ? 'text-white' : 'text-gray-700'">
                                    Feedback Manager
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">Feedback Manager</span>
                            </a>
                        </li>

                        {{-- Analytics --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('analytics') }}"
                            :class="activePath.includes('/analytics')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-chart-line text-lg"
                                    :class="activePath.includes('/analytics')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/analytics') ? 'text-white' : 'text-gray-700'">
                                    Analytics
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">Analytics</span>
                            </a>
                        </li>

                        {{-- Knowledge Pulse --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('knowledge.pulse') }}"
                            :class="activePath.includes('/knowledge-pulse')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-lightbulb text-lg"
                                    :class="activePath.includes('/knowledge-pulse')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/knowledge-pulse') ? 'text-white' : 'text-gray-700'">
                                    Knowledge Pulse
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">Knowledge Pulse</span>
                            </a>
                        </li>

                        {{-- Widget --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('widget') }}"
                            :class="activePath.includes('/widget')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-cube text-lg"
                                    :class="activePath.includes('/widget')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/widget') ? 'text-white' : 'text-gray-700'">
                                    Widget
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">Widget</span>
                            </a>
                        </li>

                        {{-- Drive --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('drive') }}"
                            :class="activePath.includes('/drive')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-folder-open text-lg"
                                    :class="activePath.includes('/drive')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/drive') ? 'text-white' : 'text-gray-700'">
                                    Drive
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">Drive</span>
                            </a>
                        </li>

                        {{-- Settings --}}
                        <li class="relative group w-full px-2">
                            <a href="{{ route('settings') }}"
                            :class="activePath.includes('/settings')
                                        ? 'bg-gray-100 text-white shadow-md'
                                        : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                            class="flex items-center w-full h-12 rounded-xl transition-all relative">
                                <div class="flex justify-center items-center w-12 h-12 flex-shrink-0">
                                    <i class="fas fa-cog text-lg"
                                    :class="activePath.includes('/settings')
                                                ? 'text-blue-600'
                                                : 'text-gray-500 group-hover:text-gray-800'"></i>
                                </div>
                                <span style="display:none"
                                    class="ml-2 font-medium whitespace-nowrap"
                                    :class="activePath.includes('/settings') ? 'text-white' : 'text-gray-700'">
                                    Settings
                                </span>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0
                                    group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50
                                    top-1/2 -translate-y-1/2">Settings</span>
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
