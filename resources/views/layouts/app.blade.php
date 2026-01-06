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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body id="page-top" class="bg-gray-50 text-base-content font-sans antialiased overflow-hidden">

    {{-- ✅ Main Layout Wrapper (Full Height, No Body Scroll) --}}
    <div x-data="{
            sidebarOpen: localStorage.getItem('sidebarOpen') === 'true',
            dashboardOpen: false,
            feedbackOpen: false,
            activePath: window.location.pathname,

            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
                // Collapse sub-menus when sidebar closes
                if(!this.sidebarOpen) {
                    this.dashboardOpen = false;
                    this.feedbackOpen = false;
                }
            },


            handleAccordion(menu) {
                if (!this.sidebarOpen) {
                    this.sidebarOpen = true;
                    localStorage.setItem('sidebarOpen', true);
                    // Small delay to allow transition before expanding menu
                    setTimeout(() => { this[menu] = true; }, 150);
                } else {
                    this[menu] = !this[menu];
                }
            }
         }"
         x-init="
            document.addEventListener('livewire:navigated', () => {
                activePath = window.location.pathname;
            });
         "
         class="flex flex-col h-screen">

        {{-- ✅ 1. FIXED TOP NAVBAR (Height 64px/16 unit) --}}
        <div class="h-16 w-full fixed top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
            @include('layouts.navbar')
        </div>

        {{-- ✅ Content Wrapper (Pushed down by 64px) --}}
        <div class="flex flex-1 pt-16 h-full overflow-hidden">

            {{-- ✅ 2. SIDEBAR (Fixed Left, Independent Scroll) --}}
            <aside
                class="h-full bg-white border-r border-gray-200 shadow-lg sidebar-transition flex flex-col z-40 overflow-y-auto no-scrollbar relative"
                :class="sidebarOpen ? 'w-64' : 'w-16'"
            >
                {{-- Toggle Button --}}
                <div class="p-3 flex justify-start sticky top-0 bg-white z-10">
                    <button @click="toggleSidebar()" class=" text-[#000000]">


                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 transition-transform duration-300"
                             :class="sidebarOpen ? 'rotate-180' : 'rotate-0'">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M6 17L11 12L6 7M13 17L18 12L13 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>

                    </button>
                </div>

                {{-- Menu Items --}}
                <ul class="menu p-2 gap-2 text-base-content w-full">

                    {{-- ====================================================
                         ITEM 1: DASHBOARD (ACCORDION)
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="(activePath === '/' || activePath.includes('/dashboard')) ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">

                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 h-6 stroke-current stroke-2">
                                    <path d="M21 18.8739V10.8663C21 9.88216 20.5726 8.95316 19.8418 8.34896L14.4558 3.89571C13.0113 2.70143 10.9887 2.70143 9.54424 3.89571L4.15818 8.34896C3.42742 8.95316 3 9.88216 3 10.8663V18.8739C3 20.0481 3.89543 21 5 21H7C8.10457 21 9 20.1046 9 19V15.6848C9 14.5106 9.89543 13.5587 11 13.5587H13C14.1046 13.5587 15 14.5106 15 15.6848V19C15 20.1046 15.8954 21 17 21H19C20.1046 21 21 20.0481 21 18.8739Z" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Dashboard</span>
                        </a>
                        {{-- Tooltip --}}
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Dashboard</div>
                    </li>

                    {{-- ====================================================
                         ITEM 2: DOCS
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('docs') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/docs') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">

                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.1519V19.3095C3.99197 18.8639 5.40415 18.4 7 18.4C8.58915 18.4 9.9999 18.8602 11 19.3094V6.1519C10.7827 6.02653 10.4894 5.8706 10.1366 5.71427C9.31147 5.34869 8.20352 5 7 5C5.26385 5 3.74016 5.72499 3 6.1519ZM13 6.1519V19.3578C13.9977 18.9353 15.41 18.5 17 18.5C18.596 18.5 20.0095 18.9383 21 19.3578V6.1519C20.2598 5.72499 18.7362 5 17 5C15.7965 5 14.6885 5.34869 13.8634 5.71427C13.5106 5.8706 13.2173 6.02653 13 6.1519ZM12 4.41985C11.7302 4.26422 11.3734 4.07477 10.9468 3.88572C9.96631 3.45131 8.57426 3 7 3C4.69187 3 2.76233 3.97065 1.92377 4.46427C1.30779 4.82687 1 5.47706 1 6.11223V20.0239C1 20.6482 1.36945 21.1206 1.79531 21.3588C2.21653 21.5943 2.78587 21.6568 3.30241 21.3855C4.12462 20.9535 5.48348 20.4 7 20.4C8.90549 20.4 10.5523 21.273 11.1848 21.6619C11.6757 21.9637 12.2968 21.9725 12.7959 21.6853C13.4311 21.32 15.0831 20.5 17 20.5C18.5413 20.5 19.9168 21.0305 20.7371 21.4366C21.6885 21.9075 23 21.2807 23 20.0593V6.11223C23 5.47706 22.6922 4.82687 22.0762 4.46427C21.2377 3.97065 19.3081 3 17 3C15.4257 3 14.0337 3.45131 13.0532 3.88572C12.6266 4.07477 12.2698 4.26422 12 4.41985Z"></path>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Docs</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Documentation</div>
                    </li>

                    {{-- ====================================================
                         ITEM 3: DECISION TREE
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('decision.tree') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/decision-tree') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg fill="currentColor" viewBox="0 0 32 32" class="w-6 h-6">
                                    <path d="M26 20.75c-1.594 0.006-3.019 0.726-3.972 1.856l-0.006 0.008-10.91-5.455c0.088-0.348 0.139-0.747 0.139-1.159s-0.050-0.811-0.146-1.193l0.007 0.034 10.911-5.455c0.963 1.109 2.374 1.806 3.949 1.806 2.883 0 5.221-2.338 5.221-5.221s-2.337-5.221-5.221-5.221c-2.883 0-5.221 2.337-5.221 5.221 0 0.010 0 0.020 0 0.031v-0.002c0.003 0.412 0.053 0.811 0.146 1.194l-0.007-0.036-10.911 5.455c-0.969-1.143-2.406-1.864-4.012-1.864-2.9 0-5.25 2.351-5.25 5.25s2.351 5.25 5.25 5.25c1.606 0 3.043-0.721 4.006-1.857l0.006-0.008 10.911 5.455c-0.082 0.347-0.129 0.745-0.129 1.154 0 2.897 2.348 5.245 5.245 5.245s5.245-2.348 5.245-5.245c0-2.897-2.348-5.245-5.245-5.245-0.002 0-0.004 0-0.005 0h0zM26 3.25c1.519 0 2.75 1.231 2.75 2.75s-1.231 2.75-2.75 2.75c-1.519 0-2.75-1.231-2.75-2.75v0c0.002-1.518 1.232-2.748 2.75-2.75h0zM6 18.75c-1.519 0-2.75-1.231-2.75-2.75s1.231-2.75 2.75-2.75c1.519 0 2.75 1.231 2.75 2.75v0c-0.002 1.518-1.232 2.748-2.75 2.75h-0zM26 28.75c-1.519 0-2.75-1.231-2.75-2.75s1.231-2.75 2.75-2.75c1.519 0 2.75 1.231 2.75 2.75v0c-0.002 1.518-1.232 2.748-2.75 2.75h-0z"></path>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Decision Tree</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Interactive Decision Tree</div>
                    </li>

                    {{-- ====================================================
                         ITEM 4: API DOCS
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('api.docs') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/api-docs') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="4" class="w-6 h-6">
                                    <path d="M16 4C14 4 11 5 11 9C11 13 11 15 11 18C11 21 6 23 6 23C6 23 11 25 11 28C11 31 11 35 11 39C11 43 14 44 16 44" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M32 4C34 4 37 5 37 9C37 13 37 15 37 18C37 21 42 23 42 23C42 23 37 25 37 28C37 31 37 35 37 39C37 43 34 44 32 44" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">API Docs</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">API Documentation</div>
                    </li>

                    {{-- ====================================================
                         ITEM 5: FEEDBACK MANAGER (ACCORDION)
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('feedback.index') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/feedback') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">

                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6 stroke-current stroke-2">
                                    <path d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Feedback Manager</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Feedback Manager</div>
                    </li>

                    {{-- ====================================================
                         ITEM 6: ANALYTICS
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('analytics') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/analytics') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-6 h-6">
                                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Analytics</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Analytics</div>
                    </li>

                    {{-- ====================================================
                         ITEM 7: KNOWLEDGE PULSE
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('knowledge.pulse') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/knowledge-pulse') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Knowledge Pulse</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Knowledge Pulse</div>
                    </li>

                    {{-- ====================================================
                         ITEM 8: WIDGET
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('widget') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/widget') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-6 h-6">
                                    <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Widget</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Widget</div>
                    </li>

                    {{-- ====================================================
                         ITEM 9: DRIVE
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('drive') }}"
                           class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/drive') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current stroke-2" fill="none">
                                    <path d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Drive</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Drive</div>
                    </li>

                    {{-- ====================================================
                         ITEM 10: SETTINGS
                         ==================================================== --}}
                    <li class="relative group">
                        <a href="{{ route('settings') }}"
                           class="flex items-center gap-4 px-3 py-3 mt-35 rounded-xl transition-all duration-200"
                           :class="activePath.includes('/settings') ? 'bg-trix-navy text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'">
                            <div class="w-6 h-6 flex justify-center items-center shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6 stroke-current stroke-2">
                                    <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 12.88V11.12C2 10.08 2.85 9.22 3.9 9.22C5.71 9.22 6.45 7.94 5.54 6.37C5.02 5.47 5.33 4.3 6.24 3.78L7.97 2.79C8.76 2.32 9.78 2.6 10.25 3.39L10.36 3.58C11.26 5.15 12.74 5.15 13.65 3.58L13.76 3.39C14.23 2.6 15.25 2.32 16.04 2.79L17.77 3.78C18.68 4.3 18.99 5.47 18.47 6.37C17.56 7.94 18.3 9.22 20.11 9.22C21.15 9.22 22.01 10.07 22.01 11.12V12.88C22.01 13.92 21.16 14.78 20.11 14.78C18.3 14.78 17.56 16.06 18.47 17.63C18.99 18.54 18.68 19.7 17.77 20.22L16.04 21.21C15.25 21.68 14.23 21.4 13.76 20.61L13.65 20.42C12.75 18.85 11.27 18.85 10.36 20.42L10.25 20.61C9.78 21.4 8.76 21.68 7.97 21.21L6.24 20.22C5.33 19.7 5.02 18.53 5.54 17.63C6.45 16.06 5.71 14.78 3.9 14.78C2.85 14.78 2 13.92 2 12.88Z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap font-medium">Settings</span>
                        </a>
                        <div x-show="!sidebarOpen" class="fixed left-20 ml-2 px-2 py-1 bg-trix-navy text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-[999]">Settings</div>
                    </li>

                </ul>
            </aside>

            {{-- ✅ 3. MAIN CONTENT (Scrolls Independently) --}}
            <main class="flex-1 bg-gray-50 h-full overflow-y-auto p-6 relative">
                <x-dialog />
                <x-toast />
                @yield('content')
            </main>

        </div>
    </div>

    @livewire('ai-chat')
    @livewireScripts

    {{-- Modal Scripts --}}
    <script>
        Livewire.on('close-modal-create', () => $modalClose('modal-create'));
        Livewire.on('close-modal-update', () => $modalClose('modal-update'));
        Livewire.on('close-modal-delete', () => $modalClose('modal-delete'));
        Livewire.on('close-modal-edit-profile', () => $modalClose('modal-edit-profile'));
        Livewire.on('close-modal-change-password', () => $modalClose('modal-change-password'));
        Livewire.on('close-modal-ai', () => $modalClose('modal-ai'));
        Livewire.on('open-modal-ai', () => $modalOpen('modal-ai'));
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarData', () => ({
                activePage: window.location.pathname,
                $modalOpen(modalId) { console.log('Opening modal:', modalId); }
            }));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    {{-- Sidebar Overlay Component --}}
    <div x-data="{ openSide: false }" x-on:open-side.window="openSide = true">
        <div x-cloak x-show="openSide" x-transition class="fixed inset-0 bg-black/40 z-[999] flex justify-end">
            <div class="w-full bg-white h-full shadow-xl overflow-y-auto max-w-md">
                <livewire:document.partial.doc-open-site />
            </div>
        </div>
    </div>

</body>
</html>
