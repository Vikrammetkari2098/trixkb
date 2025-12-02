@extends('layouts.app')
@section('content')

<div class="flex h-screen overflow-hidden" x-data="{ menuState: 'default' }"> 
    
    <div class="w-80 bg-white flex flex-col space-y-2 border-r border-gray-200">
        
        <div class="flex items-center justify-start p-2 border-b border-gray-200">
            
            <div x-data="{ 
                    tooltip: false, 
                    top: 0, 
                    left: 0,
                    updatePosition() {
                        const buttonRect = this.$refs.button.getBoundingClientRect();
                        const tooltipHeight = this.$refs.tooltip ? this.$refs.tooltip.offsetHeight : 0;
                        this.top = buttonRect.top - tooltipHeight - 8; 
                        this.left = buttonRect.left + buttonRect.width / 2;
                    }
                }" 
                class="mr-2"
                @mouseenter="tooltip = true; $nextTick(() => updatePosition())" 
                @mouseleave="tooltip = false"
                @scroll.window="updatePosition">
                
                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-solid fa-list-check fa-lg"></i>
                </button>
                
                <div x-ref="tooltip"
                     x-show="tooltip" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 scale-90" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-100" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-90" 
                     
                     :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                     class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                    All Artical
                    
                    <div class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800"></div>
                </div>
            </div>

            <div x-data="{ 
                    tooltip: false, 
                    top: 0, 
                    left: 0,
                    updatePosition() {
                        const buttonRect = this.$refs.button.getBoundingClientRect();
                        const tooltipHeight = this.$refs.tooltip ? this.$refs.tooltip.offsetHeight : 0;
                        this.top = buttonRect.top - tooltipHeight - 8; 
                        this.left = buttonRect.left + buttonRect.width / 2;
                    }
                }" 
                class="relative mr-2"
                @mouseenter="tooltip = true; $nextTick(() => updatePosition())" 
                @mouseleave="tooltip = false"
                @scroll.window="updatePosition">
                
                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-regular fa-clock"></i>
                </button>
                
                <div x-ref="tooltip"
                     x-show="tooltip" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 scale-90" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-100" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-90" 
                     
                     :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                     class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                    Recent
                    <div class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800"></div>
                </div>
            </div>

            <div x-data="{ 
                    tooltip: false, 
                    top: 0, 
                    left: 0,
                    updatePosition() {
                        const buttonRect = this.$refs.button.getBoundingClientRect();
                        const tooltipHeight = this.$refs.tooltip ? this.$refs.tooltip.offsetHeight : 0;
                        this.top = buttonRect.top - tooltipHeight - 8; 
                        this.left = buttonRect.left + buttonRect.width / 2;
                    }
                }" 
                class="relative mr-2"
                @mouseenter="tooltip = true; $nextTick(() => updatePosition())" 
                @mouseleave="tooltip = false"
                @scroll.window="updatePosition">
                
                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
                
                <div x-ref="tooltip"
                     x-show="tooltip" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 scale-90" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-100" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-90" 
                     
                     :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                     class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                    Recycle Bin
                    <div class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800"></div>
                </div>
            </div>

            <div x-data="{ 
                    tooltip: false, 
                    top: 0, 
                    left: 0,
                    updatePosition() {
                        const buttonRect = this.$refs.button.getBoundingClientRect();
                        const tooltipHeight = this.$refs.tooltip ? this.$refs.tooltip.offsetHeight : 0;
                        this.top = buttonRect.top - tooltipHeight - 8; 
                        this.left = buttonRect.left + buttonRect.width / 2;
                    }
                }" 
                class="relative mr-2"
                @mouseenter="tooltip = true; $nextTick(() => updatePosition())" 
                @mouseleave="tooltip = false"
                @scroll.window="updatePosition">
                
                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-regular fa-file-lines"></i>
                </button>
                
                <div x-ref="tooltip"
                     x-show="tooltip" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="opacity-0 scale-90" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-100" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-90" 
                     
                     :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                     class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                    API Refrences 
                    <div class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800"></div>
                </div>
            </div>

        </div>

        <div class="p-4 flex-1 overflow-y-auto">
            <div x-show="menuState === 'default'" x-transition:enter.duration.500ms x-transition:leave.duration.300ms>
                
                <div x-data="{ siteBuilderOpen: false }" class="space-y-1">
                    <button @click="siteBuilderOpen = !siteBuilderOpen; menuState = 'settings'" class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span class="flex items-center space-x-2">
                            <i class="fa-regular fa-hard-drive fa-rotate-180"></i>
                            <span>Site builder</span>
                        </span>
                        <i class="fa-solid fa-chevron-right w-3 h-3 text-gray-400 transition-transform duration-200" :class="{'transform rotate-90': siteBuilderOpen}"></i>
                    </button>
                </div>

                <div x-data="{ contentToolsOpen: false }" class="space-y-1 mt-2">
                    <button @click="contentToolsOpen = !contentToolsOpen" class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span class="flex items-center space-x-2">
                            <i class="fa-regular fa-lightbulb"></i>
                            <span>Content tools</span>
                        </span>
                        <i class="fa-solid fa-chevron-right w-3 h-3 text-gray-400 transition-transform duration-200" :class="{'transform rotate-90': contentToolsOpen}"></i>
                    </button>
                    <div x-show="contentToolsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="pl-4 space-y-1">
                        <a href="#" class="block p-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">Articles</a>
                        <a href="#" class="block p-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md">Categories</a>
                    </div>
                </div>

                <div class="my-4 border-t border-gray-200"></div>

                <div class="mt-8">
                    <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">CATEGORIES & ARTICLES</p>
                    <p class="mt-2 text-sm text-gray-500 italic p-2">No categories found</p>
                </div>

            </div>
            
            <div x-show="menuState === 'settings'" x-transition:enter.duration.500ms x-transition:leave.duration.300ms>
                
                <button @click="menuState = 'default'" class="flex items-center mb-4 text-sm font-medium text-purple-600 hover:text-purple-700">
                    <i class="fa-solid fa-arrow-left w-3 h-3 mr-2"></i>
                    <span>Back to Builder</span>
                </button>

                <div class="mb-4">
                    <div class="relative">
                        <input type="search" placeholder="Search" class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div x-data="{ portalOpen: false }" class="space-y-1">
                    <button @click="portalOpen = !portalOpen" class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span>KNOWLEDGE BASE PORTAL</span>
                        <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200" :class="{'rotate-180': portalOpen}"></i>
                    </button>
                    <div x-show="portalOpen" x-transition class="space-y-1">
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-gear text-gray-500 w-4 h-4"></i>
                            <span>General</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-users text-gray-500 w-4 h-4"></i>
                            <span>Team auditing</span>
                        </a>
                        <a href="#" class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <span class="flex items-center space-x-2">
                                <i class="fa-solid fa-language text-gray-500 w-4 h-4"></i>
                                <span>Localization & Workspace</span>
                            </span>
                            <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-cloud-arrow-up text-gray-500 w-4 h-4"></i>
                            <span>Backup & Restore</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-bell text-gray-500 w-4 h-4"></i>
                            <span>Notifications</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-tags text-gray-500 w-4 h-4"></i>
                            <span>API Tokens</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-dollar-sign text-gray-500 w-4 h-4"></i>
                            <span>Biling</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-cubes-stacked text-gray-500 w-4 h-4"></i>
                            <span>Extensions</span>
                        </a>
                    </div>
                </div>
                
                <div x-data="{ siteOpen: false }" class="space-y-1">
                    <button @click="siteOpen = !siteOpen" class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span>KNOWLEDGE BASE SITE</span>
                        <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200" :class="{'rotate-180': siteOpen}"></i>
                    </button>
                    <div x-show="siteOpen" x-transition class="space-y-1 pl-4">
                        <a href="#" class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <span class="flex items-center space-x-2">
                                <i class="fa-solid fa-display text-gray-500 w-4 h-4"></i>
                                <span>Customize Site</span>
                            </span>
                            <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-earth-africa text-gray-500 w-4 h-4"></i>
                            <span>Custom Domain</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-rotate-right text-gray-500 w-4 h-4"></i>
                            <span>Artical Redirect Rules</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-gift text-gray-500 w-4 h-4"></i>
                            <span>Integrations</span>
                        </a>
                        <a href="#" class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <span class="flex items-center space-x-2">
                                <i class="fa-solid fa-cookie text-gray-500 w-4 h-4"></i>
                                <span>Cookie Consent</span>
                            </span>
                            <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <span class="flex items-center space-x-2">
                                <i class="fa-solid fa-circle-info text-gray-500 w-4 h-4"></i>
                                <span>Smart Bars</span>
                            </span>
                            <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-circle-check text-gray-500 w-4 h-4"></i>
                            <span>Read receipt</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-volume-low text-gray-500 w-4 h-4"></i>
                            <span>Ticket deflectors</span>
                        </a>
                    </div>
                </div>
                <div x-data="{ portalOpen: false }" class="space-y-1">
                    <button @click="portalOpen = !portalOpen" class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span>USERS & SECURITY</span>
                        <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200" :class="{'rotate-180': portalOpen}"></i>
                    </button>
                    <div x-show="portalOpen" x-transition class="space-y-1">
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-people-group text-gray-500 w-4 h-4"></i>
                            <span>Team accounts & groups</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-copy text-gray-500 w-4 h-4"></i>
                            <span>Content access</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-user-shield text-gray-500 w-4 h-4"></i>
                            <span>Roles & permissions</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-book-open-reader text-gray-500 w-4 h-4"></i>
                            <span>Reader & groups</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-sitemap text-gray-500 w-4 h-4"></i>
                            <span>Site access</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-earth-africa text-gray-500 w-4 h-4"></i>
                            <span>IP restriction</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-shield text-gray-500 w-4 h-4"></i>
                            <span>Security</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-key text-gray-500 w-4 h-4"></i>
                            <span>SAML/OpenID</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-bahai text-gray-500 w-4 h-4"></i>
                            <span>JWT</span>
                        </a>
                    </div>
                </div>
                <div x-data="{ portalOpen: false }" class="space-y-1">
                    <button @click="portalOpen = !portalOpen" class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span>AI FEATURES</span>
                        <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200" :class="{'rotate-180': portalOpen}"></i>
                    </button>
                    <div x-show="portalOpen" x-transition class="space-y-1">
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-wand-magic-sparkles text-gray-500 w-4 h-4"></i>
                            <span>Eddy AI</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-sliders text-gray-500 w-4 h-4"></i>
                            <span>Customization</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-pen-ruler text-gray-500 w-4 h-4"></i>
                            <span>Style guide</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-hard-drive text-gray-500 w-4 h-4"></i>
                            <span>Manage sources</span>
                        </a>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
    
    
    <main class="flex-1 flex flex-col items-center justify-center text-center overflow-y-auto h-full">

        <div class="mb-6 w-80 h-auto mx-auto">
            <img src="{{ asset('image/apiimage.png') }}" alt="API Documentation Illustration" class="mx-auto max-w-full h-auto">
        </div>

        <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
            Your API documentation is empty
        </h2>

        <p class="mt-2 text-base text-gray-500">
            Get started by adding your OpenAPI (OAS) file
        </p>

        <button class="mt-6 px-8 py-3 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition duration-150 ease-in-out uppercase tracking-wider">
            new API
        </button>

    </main>

</div>

@endsection