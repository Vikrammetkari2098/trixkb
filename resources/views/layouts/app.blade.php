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

        <div x-data="{ activePage: window.location.pathname, sidebarOpen: false }" x-init="
                activePage = window.location.pathname;
                document.addEventListener('livewire:navigated', () => { activePage = window.location.pathname; });
            " class="flex flex-col min-h-screen">

            {{-- Top Navbar --}}
            @include('layouts.navbar')

            {{-- Sidebar + Main Container --}}
            <div class="flex flex-1 min-h-[calc(100vh-40px)]">
                <aside id="with-navbar-sidebar"
                    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'"
                    class="flex flex-col items-center py-4 space-y-2 bg-white shadow-lg w-16 transition-transform duration-300 sm:translate-x-0 min-h-screen z-20">
                    <ul class="menu p-0 space-y-2" x-data="{ activePath: window.location.pathname }">

                        {{-- Dashboard --}}
                       <li class="relative group">
                            <a href="{{ route('dashboard') }}"
                                :class="activePath === '/' || activePath === '/dashboard'
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all relative">
                                <i class="fas fa-home text-lg"></i>
                                <span
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        {{-- Docs --}}
                        <li class="relative group">
                            <a href="{{ route('docs') }}"
                                :class="activePath.includes('/docs')
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all relative">
                                <i class="fas fa-book text-lg"></i>
                                <!-- Tooltip -->
                                <span
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Docs
                                </span>
                            </a>
                        </li>

                        <!-- Roles -->
                        <li class="relative group">
                            <a href="{{ route('roles') }}"
                                :class="activePath.includes('/roles')
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all relative">
                                <i class="fas fa-users text-lg"></i>
                                <!-- Tooltip -->
                                <span
                                    class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Roles
                                </span>
                            </a>
                        </li>

                        {{-- Members with Dropdown --}}
                        <li x-data="{ open: false, timeout: null }"
                            @mouseover.away="timeout = setTimeout(() => { open = false }, 150)" class="relative z-50">

                            <button
                                @mouseenter="clearTimeout(timeout); open = true"
                                @click="activePath = '/members'; window.location.href = '{{ route('members') }}';"
                                :class="open || activePath.includes('/members') ? 'bg-[#09325d] text-white shadow-lg' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'"
                                class="sidebar-item transition-all w-12 h-12 flex items-center justify-center rounded-xl cursor-pointer relative focus:outline-none group"
                                aria-expanded="open ? 'true' : 'false'" aria-controls="members-popup">
                                <i class="fas fa-user text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Members</span>
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
                        <li>
                            <a href="{{ route('projects.show') }}"
                                :class="activePath.includes('/projects') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-briefcase text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Projects</span>
                            </a>
                        </li>

                        {{-- Meetings --}}
                        <li>
                            <a href="{{ route('meetings') }}"
                                :class="activePath.includes('/meetings') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-calendar-alt text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Meetings</span>
                            </a>
                        </li>

                        {{-- My Tasks --}}
                        <li>
                            <a href="{{ route('tasks') }}"
                                :class="activePath.includes('/tasks') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-clipboard-list text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">My Tasks</span>
                            </a>
                        </li>

                        {{-- Teams --}}
                        <li>
                            <a href="{{ route('teams') }}"
                                :class="activePath.includes('/teams') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-users-cog text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Teams</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('spaces.index') }}"
                                :class="activePath.includes('/spaces') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-th text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Spaces</span>
                            </a>
                        </li>

                        {{-- Matrix --}}
                        <li>
                            <a href="{{ route('users.matrix') }}"
                                :class="activePath.includes('/organisation/matrix') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-table text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Matrix</span>
                            </a>
                        </li>

                        {{-- All Article (Wikies) --}}
                        <li>
                            <a href="{{ route('users.wikies', ['team' => $team->slug, 'user' => Auth::user()->slug]) }}"
                                :class="activePath.includes('/wikies') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-book-open text-lg"></i> {{-- Changed icon for distinction from Docs --}}
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All Article</span>
                            </a>
                        </li>


                        {{-- All Directory --}}
                        <li>
                            <a href="{{ route('users.directory', ['team' => $team->slug, 'user' => Auth::user()->slug]) }}"
                                :class="activePath.includes('/directory') && !activePath.includes('/directoryUpload') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-folder-open text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All Directory</span>
                            </a>
                        </li>

                        {{-- All Resolution (Tickets) --}}
                        <li>
                            <a href="{{ route('users.tickets', ['team' => $team->slug, 'user' => Auth::user()->slug]) }}"
                                :class="activePath.includes('/tickets') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-check-circle text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All Resolution</span>
                            </a>
                        </li>


                        {{-- All ChatBot --}}
                        <li>
                            <a href="{{ route('users.chatbot', [$team->slug, Auth::user()->slug]) }}"
                                :class="activePath.includes('/chatbot') && !activePath.includes('/chatbotUpload') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-robot text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">All ChatBot</span>
                            </a>
                        </li>

                        {{-- Nota PKP --}}
                        <li>
                            <a href="{{ route('users.notaPKP', [$team->slug, Auth::user()->slug]) }}"
                                :class="activePath.includes('/notaPKP') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-sticky-note text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Nota PKP</span>
                            </a>
                        </li>

                        {{-- Directory Upload --}}
                        <li>
                            <a href="{{ route('users.directoryUpload', [$team->slug, Auth::user()->slug]) }}"
                                :class="(activePath.includes('/directoryUpload') || activePath.includes('/upload'))
                                    ? 'bg-[#09325d] text-white shadow-md'
                                    : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-folder text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">
                                    Directory Upload
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.chatbotUpload', [$team->slug, Auth::user()->slug]) }}"
                                :class="activePath.includes('/chatbotUpload') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-robot text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Chatbot Upload</span>
                            </a>
                        </li>

                        {{-- Reporting (role check) --}}
                        @if (auth()->user()->current_role_id != App\Helpers\GeneralHelper::userInternalPKPAgent() && auth()->user()->current_role_id != App\Helpers\GeneralHelper::userExternalPKPAgent())
                            <li>
                                <a href="{{ route('reports.reportings', [$team->slug, Auth::user()->slug]) }}"
                                    :class="activePath.includes('/reportings') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                    class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                    <i class="fas fa-file-alt text-lg"></i>
                                    <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Reporting</span>
                                </a>
                            </li>
                        @endif

                        {{-- Administrative --}}
                        <li>
                            <a href="{{ route('ministry.index', $team->slug) }}"
                                :class="activePath.includes('/ministry') ? 'bg-[#09325d] text-white shadow-md' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100'"
                                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all group relative">
                                <i class="fas fa-sitemap text-lg"></i>
                                <span class="absolute left-full ml-2 px-2 py-1 text-xs bg-[#09325d] text-white rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible whitespace-nowrap transition-all duration-200 z-50 top-1/2 -translate-y-1/2">Administrative</span>
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
