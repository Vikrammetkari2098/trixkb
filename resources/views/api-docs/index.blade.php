@extends('layouts.app')
@section('content')
    <div class="flex h-screen overflow-hidden" x-data="{ menuState: 'default', contentToolState: 'find-and-replace', siteBuilderState: 'customize-site', documentationopen: true, kbSiteOpen: true }">

<div class="flex h-screen overflow-hidden" x-data="{ menuState: 'default', contentToolState: 'find-and-replace', siteBuilderState: 'customize-site', documentationopen: true, kbSiteOpen: true }">

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

                <template x-if="tooltip">
                    <div x-ref="tooltip"
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
                </template>
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
            class="mr-2"
            @mouseenter="tooltip = true; $nextTick(() => updatePosition())"
            @mouseleave="tooltip = false"
            @scroll.window="updatePosition">

                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-regular fa-clock"></i>
                </button>

                <template x-if="tooltip">
                    <div x-ref="tooltip"
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
                </template>
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
            class="mr-2"
            @mouseenter="tooltip = true; $nextTick(() => updatePosition())"
            @mouseleave="tooltip = false"
            @scroll.window="updatePosition">

                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-regular fa-trash-can"></i>
                </button>

                <template x-if="tooltip">
                    <div x-ref="tooltip"
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
                </template>
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
            class="mr-2"
            @mouseenter="tooltip = true; $nextTick(() => updatePosition())"
            @mouseleave="tooltip = false"
            @scroll.window="updatePosition">

                <button x-ref="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                    <i class="fa-regular fa-file-lines"></i>
                </button>

                <template x-if="tooltip">
                    <div x-ref="tooltip"
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
                </template>
            </div>
        </div>

        <div class="p-4 flex-1 overflow-y-auto">

            <div x-show="menuState === 'default'" x-transition:enter.duration.500ms x-transition:leave.duration.300ms>

                <div class="space-y-1">
                    <button @click="menuState = 'site-builder'" class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                        <span class="flex items-center space-x-2">
                            <i class="fa-regular fa-hard-drive fa-rotate-180"></i>
                            <span>Site builder</span>
                        </span>
                        <i class="fa-solid fa-chevron-right w-3 h-3 text-gray-400"></i>
                    </button>

                    <template x-if="tooltip">
                        <div x-ref="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                            class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                            All Artical
                            <div
                                class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800">
                            </div>
                        </div>
                    </template>
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
                }" class="mr-2" @mouseenter="tooltip = true; $nextTick(() => updatePosition())"
                    @mouseleave="tooltip = false" @scroll.window="updatePosition">

                    <button x-ref="button"
                        class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                        <i class="fa-regular fa-clock"></i>
                    </button>

                    <template x-if="tooltip">
                        <div x-ref="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                            class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                            Recent
                            <div
                                class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800">
                            </div>
                        </div>
                    </template>
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
                }" class="mr-2" @mouseenter="tooltip = true; $nextTick(() => updatePosition())"
                    @mouseleave="tooltip = false" @scroll.window="updatePosition">

                    <button x-ref="button"
                        class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>

                    <template x-if="tooltip">
                        <div x-ref="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                            class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                            Recycle Bin
                            <div
                                class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800">
                            </div>
                        </div>
                    </template>
                </div>

            </div>

            <div x-show="menuState === 'site-builder'" x-transition:enter.duration.500ms x-transition:leave.duration.300ms>

                <button @click="menuState = 'default'" class="flex items-center mb-4 text-sm font-medium text-black-600 ">
                    <i class="fa-solid fa-arrow-left w-3 h-3 mr-2"></i>
                    <span>Back</span>
                </button>

                    <button x-ref="button"
                        class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-150">
                        <i class="fa-regular fa-file-lines"></i>
                    </button>

                    <template x-if="tooltip">
                        <div x-ref="tooltip" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            :style="`top: ${top}px; left: ${left}px; transform: translateX(-50%);`"
                            class="fixed z-[100] px-3 py-1 text-xs text-white bg-gray-800 rounded-md shadow-lg whitespace-nowrap">
                            API Refrences
                            <div
                                class="absolute bottom-[-4px] left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-l-transparent border-r-4 border-r-transparent border-t-4 border-t-gray-800">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="p-4 flex-1 overflow-y-auto">

                <div x-show="menuState === 'default'" x-transition:enter.duration.500ms x-transition:leave.duration.300ms>

                    <div class="space-y-1">
                        <button @click="menuState = 'site-builder'"
                            class="w-full flex items-center justify-between p-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                            <span class="flex items-center space-x-2">
                                <i class="fa-regular fa-hard-drive fa-rotate-180"></i>
                                <span>Site builder</span>
                            </span>
                            <i class="fa-solid fa-chevron-right w-3 h-3 text-gray-400"></i>
                        </button>
                    </div>
                </div>

                <div x-data="{ kbSiteOpen: true }" class="space-y-1 mt-2">
                    <button @click="kbSiteOpen = !kbSiteOpen" class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                        <span>KNOWLEDGE BASE SITE</span>
                        <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200" :class="{'rotate-180': kbSiteOpen}"></i>
                    </button>
                    <div x-show="kbSiteOpen" x-transition class="space-y-1 pl-4">
                        <a href="#" @click.prevent="siteBuilderState = 'customize-site'"
                        :class="{'bg-purple-100 text-gray-700': siteBuilderState === 'customize-site', 'text-gray-700 hover:bg-gray-100': siteBuilderState !== 'customize-site'}"
                        class="flex items-center space-x-2 p-2 text-sm rounded-md">
                        <i class="fa-solid fa-display w-4 h-4"
                        :class="{'text-gray-700': siteBuilderState === 'customize-site', 'text-gray-500': siteBuilderState !== 'customize-site'}"></i>
                            <span>Customize Site</span>
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
                                <i class="fa-regular fa-lightbulb"></i>
                                <span>Content tools</span>
                            </span>
                            <i class="fa-solid fa-chevron-right w-3 h-3 text-gray-400"></i>
                        </button>
                    </div>

                    <div class="my-4 border-t border-gray-200"></div>

                    <div class="mt-8">
                        <p class="text-xs font-semibold uppercase text-gray-400 tracking-wider">CATEGORIES & ARTICLES</p>
                        <p class="mt-2 text-sm text-gray-500 italic p-2">No categories found</p>
                    </div>

                </div>

                <div x-show="menuState === 'site-builder'" x-transition:enter.duration.500ms
                    x-transition:leave.duration.300ms>

                    <button @click="menuState = 'default'"
                        class="flex items-center mb-4 text-sm font-medium text-black-600 ">
                        <i class="fa-solid fa-arrow-left w-3 h-3 mr-2"></i>
                        <span>Back</span>
                    </button>

                    <div class="mb-4">
                        <div class="relative">
                            <input type="search" placeholder="Search"
                                class="w-full py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500">
                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="menuState === 'content-tools'" x-transition:enter.duration.500ms x-transition:leave.duration.300ms>

                <button @click="menuState = 'default'" class="flex items-center mb-4 text-sm font-medium text-black-600 ">
                    <i class="fa-solid fa-arrow-left w-3 h-3 mr-2"></i>
                    <span>Back</span>
                </button>

                    <div x-data="{ portalOpen: false }" class="space-y-1">
                        <button @click="portalOpen = !portalOpen"
                            class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 hover:bg-gray-100 rounded-md transition duration-150">
                            <span>KNOWLEDGE BASE PORTAL</span>
                            <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': portalOpen }"></i>
                        </button>
                        <div x-show="portalOpen" x-transition class="space-y-1">
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-gear text-gray-500 w-4 h-4"></i>
                                <span>General</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-users text-gray-500 w-4 h-4"></i>
                                <span>Team auditing</span>
                            </a>
                            <a href="#"
                                class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-language text-gray-500 w-4 h-4"></i>
                                    <span>Localization & Workspace</span>
                                </span>
                                <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-cloud-arrow-up text-gray-500 w-4 h-4"></i>
                                <span>Backup & Restore</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-bell text-gray-500 w-4 h-4"></i>
                                <span>Notifications</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-tags text-gray-500 w-4 h-4"></i>
                                <span>API Tokens</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-dollar-sign text-gray-500 w-4 h-4"></i>
                                <span>Billing</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-cubes-stacked text-gray-500 w-4 h-4"></i>
                                <span>Extensions</span>
                            </a>
                        </div>
                    </div>

                    <div x-data="{ kbSiteOpen: true }" class="space-y-1 mt-2">
                        <button @click="kbSiteOpen = !kbSiteOpen"
                            class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                            <span>KNOWLEDGE BASE SITE</span>
                            <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': kbSiteOpen }"></i>
                        </button>
                        <div x-show="kbSiteOpen" x-transition class="space-y-1 pl-4">
                            <a href="#" @click.prevent="siteBuilderState = 'customize-site'"
                                :class="{ 'bg-purple-100 text-gray-700': siteBuilderState === 'customize-site', 'text-gray-700 hover:bg-gray-100': siteBuilderState !== 'customize-site' }"
                                class="flex items-center space-x-2 p-2 text-sm rounded-md">
                                <i class="fa-solid fa-display w-4 h-4"
                                    :class="{ 'text-gray-700': siteBuilderState === 'customize-site', 'text-gray-500': siteBuilderState !== 'customize-site' }"></i>
                                <span>Customize Site</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-earth-africa text-gray-500 w-4 h-4"></i>
                                <span>Custom Domain</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-rotate-right text-gray-500 w-4 h-4"></i>
                                <span>Artical Redirect Rules</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-gift text-gray-500 w-4 h-4"></i>
                                <span>Integrations</span>
                            </a>
                            <a href="#"
                                class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-cookie text-gray-500 w-4 h-4"></i>
                                    <span>Cookie Consent</span>
                                </span>
                                <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                            </a>
                            <a href="#"
                                class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-circle-info text-gray-500 w-4 h-4"></i>
                                    <span>Smart Bars</span>
                                </span>
                                <i class="fa-solid fa-globe text-gray-500 w-3 h-3"></i>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-circle-check text-gray-500 w-4 h-4"></i>
                                <span>Read receipt</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-volume-low text-gray-500 w-4 h-4"></i>
                                <span>Ticket deflectors</span>
                            </a>
                        </div>
                    </div>

                <div x-data="{ documentationopen: true }" class="space-y-1">
                    <button @click="documentationopen = !documentationopen" class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                        <span>DOCUMENTATION</span>
                        <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200" :class="{'rotate-180': documentationopen}"></i>
                    </button>
                    <div x-show="documentationopen" x-transition class="pl-2 space-y-1">
                        <a href="#" @click.prevent="contentToolState = 'find-and-replace'"
                        :class="{'bg-purple-100 text-gray-700': contentToolState === 'find-and-replace', 'text-gray-700 hover:bg-gray-100': contentToolState !== 'find-and-replace'}"
                        class="flex items-center space-x-2 p-2 text-sm rounded-md">
                        <i class="fa-solid fa-magnifying-glass w-4 h-4"
                        :class="{'text-gray-700': contentToolState === 'find-and-replace', 'text-gray-500': contentToolState !== 'find-and-replace'}"></i>
                        <span>Find and replace</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-circle-nodes text-gray-500 w-4 h-4"></i>
                            <span>Workflow designer</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-stopwatch text-gray-500 w-4 h-4"></i>
                            <span>Artical review reminders</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-tag text-gray-500 w-4 h-4"></i>
                            <span>Tags</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fa-solid fa-magnifying-glass-dollar text-gray-500 w-4 h-4"></i>
                            <span>SEO description</span>
                        </a>
                    </div>

                    <div x-data="{ portalOpen: false }" class="space-y-1 mt-2">
                        <button @click="portalOpen = !portalOpen"
                            class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                            <span>AI FEATURES</span>
                            <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': portalOpen }"></i>
                        </button>
                        <div x-show="portalOpen" x-transition class="space-y-1">
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-wand-magic-sparkles text-gray-500 w-4 h-4"></i>
                                <span>Eddy AI</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-sliders text-gray-500 w-4 h-4"></i>
                                <span>Customization</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-pen-ruler text-gray-500 w-4 h-4"></i>
                                <span>Style guide</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-hard-drive text-gray-500 w-4 h-4"></i>
                                <span>Manage sources</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div x-show="menuState === 'content-tools'" x-transition:enter.duration.500ms
                    x-transition:leave.duration.300ms>

                    <button @click="menuState = 'default'"
                        class="flex items-center mb-4 text-sm font-medium text-black-600 ">
                        <i class="fa-solid fa-arrow-left w-3 h-3 mr-2"></i>
                        <span>Back</span>
                    </button>

                    <h3 class="text-lg font-semibold text-gray-800">Content tools</h3>
                    <p class="text-xs text-gray-500 mb-4">Common for both Documentation and API</p>

                    <div class="my-4 border-t border-gray-200"></div>

                    <div x-data="{ documentationopen: true }" class="space-y-1">
                        <button @click="documentationopen = !documentationopen"
                            class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                            <span>DOCUMENTATION</span>
                            <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': documentationopen }"></i>
                        </button>
                        <div x-show="documentationopen" x-transition class="pl-2 space-y-1">
                            <a href="#" @click.prevent="contentToolState = 'find-and-replace'"
                                :class="{ 'bg-purple-100 text-gray-700': contentToolState === 'find-and-replace', 'text-gray-700 hover:bg-gray-100': contentToolState !== 'find-and-replace' }"
                                class="flex items-center space-x-2 p-2 text-sm rounded-md">
                                <i class="fa-solid fa-magnifying-glass w-4 h-4"
                                    :class="{ 'text-gray-700': contentToolState === 'find-and-replace', 'text-gray-500': contentToolState !== 'find-and-replace' }"></i>
                                <span>Find and replace</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-circle-nodes text-gray-500 w-4 h-4"></i>
                                <span>Workflow designer</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-stopwatch text-gray-500 w-4 h-4"></i>
                                <span>Artical review reminders</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-tag text-gray-500 w-4 h-4"></i>
                                <span>Tags</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-magnifying-glass-dollar text-gray-500 w-4 h-4"></i>
                                <span>SEO description</span>
                            </a>
                        </div>
                    </div>

                    <div x-data="{ contentReuseOpen: false }" class="space-y-1 mt-2">
                        <button @click="contentReuseOpen = !contentReuseOpen"
                            class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                            <span>CONTENT REUSE</span>
                            <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': contentReuseOpen }"></i>
                        </button>
                        <div x-show="contentReuseOpen" x-transition class="pl-2 space-y-1">
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-file-lines text-gray-500 w-4 h-4"></i>
                                <span>Templates</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-code text-gray-500 w-4 h-4"></i>
                                <span>Variables</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-file-lines text-gray-500 w-4 h-4"></i>
                                <span>Snippets</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-a text-gray-500 w-4 h-4"></i>
                                <span>Glossary</span>
                            </a>
                        </div>
                    </div>

                    <div x-data="{ importExportOpen: false }" class="space-y-1 mt-2">
                        <button @click="importExportOpen = !importExportOpen"
                            class="w-full flex items-center justify-between p-2 text-xs font-semibold uppercase text-gray-700 bg-gray-100 rounded-md transition duration-150">
                            <span>IMPORT AND EXPORT</span>
                            <i class="fa-solid fa-caret-down w-3 h-3 text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': importExportOpen }"></i>
                        </button>
                        <div x-show="importExportOpen" x-transition class="pl-2 space-y-1">
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-file-import text-gray-500 w-4 h-4"></i>
                                <span>Import and export project</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-file-pdf text-gray-500 w-4 h-4"></i>
                                <span>Export to PDF</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 p-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                <i class="fa-solid fa-rocket text-gray-500 w-4 h-4"></i>
                                <span>Migrate content</span>
                            </a>
                        </div>
                    </div>

                    <div class="space-y-1 mt-2 mb-4">
                        <a href="#" @click.prevent="contentToolState = 'custom-pages'"
                            :class="{ 'bg-purple-100 text-purple-700': contentToolState === 'custom-pages' }"
                            class="flex items-center space-x-2 p-2 text-sm text-gray-700 bg-gray-100 rounded-md">
                            <i class="fa-regular fa-file-lines w-4 h-4"
                                :class="{ 'text-purple-600': contentToolState === 'custom-pages', 'text-gray-500': contentToolState !== 'custom-pages' }"></i>
                            <span>Custom pages</span>
                        </a>
                    </div>
                </div>

                <div class="space-y-1 mt-2 mb-4">
                    <a href="#" @click.prevent="contentToolState = 'custom-pages'"
                        :class="{'bg-purple-100 text-purple-700': contentToolState === 'custom-pages'}"
                        class="flex items-center space-x-2 p-2 text-sm text-gray-700 bg-gray-100 rounded-md">
                        <i class="fa-regular fa-file-lines w-4 h-4"
                            :class="{'text-purple-600': contentToolState === 'custom-pages', 'text-gray-500': contentToolState !== 'custom-pages'}"></i>
                        <span>Custom pages</span>
                    </a>
                </div>
            </div>

        </div>
    </div>


    <main class="flex-1 flex flex-col items-center justify-center text-center overflow-y-auto h-full">
                   <!-- API Main page -->
        <div x-show="menuState === 'default'"
         class="w-full h-full flex flex-col items-center justify-center p-8">

        <div class="mb-6 w-80 h-auto mx-auto">
            <img src="{{ asset('image/apiimage.png') }}" alt="API Documentation Illustration" class="mx-auto max-w-full h-auto">
        </div>


        <main class="flex-1 flex flex-col items-center justify-center text-center overflow-y-auto w-full h-full">
            <!-- API Main page -->
            <div x-show="menuState === 'default'" class="w-full h-full flex flex-col items-center justify-center p-8">

        <button class="mt-6 px-8 py-3 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition duration-150 ease-in-out uppercase tracking-wider">
            new API
        </button>
    </div>
                    <!-- Custom Pages -->
        <div x-show="menuState === 'content-tools' && contentToolState === 'custom-pages'"
         class="w-full h-full flex flex-col items-center justify-center p-8">

        <div class="mb-6 w-80 h-auto mx-auto">
            <img src="{{ asset('image/apiimage2.png') }}" alt="API Documentation Illustration" class="mx-auto max-w-full h-auto">
        </div>

                <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                    Your API documentation is empty
                </h2>

                <p class="mt-2 text-base text-gray-500">
                    Get started by adding your OpenAPI (OAS) file
                </p>

        <button class="mt-6 px-8 py-3 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition duration-150 ease-in-out uppercase tracking-wider">
            Create page
        </button>
    </div>
                  <!-- Find & replece Page -->
        <div x-show="menuState === 'content-tools' && contentToolState === 'find-and-replace'"
     class="w-full h-full flex flex-col items-center justify-start p-8 overflow-y-auto bg-white">

    <div class="w-full flex justify-between items-start mb-6 pt-4">
        <div class="text-left">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800 flex items-center mb-1 mr-2">
                Find and replace&nbsp;
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" /></svg>
            </h2>
            <p class="text-sm text-gray-500">
                Find article content and replace with desired text across all versions and languages.
            </p>
        </div>

        <button class="flex items-center space-x-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
            <span>Filter</span>
        </button>
    </div>

    <div class="w-full mb-10">
        <div class="flex flex-wrap items-center gap-4">

            <div class="flex items-center space-x-2 w-100">
                <label for="find-text" class="text-sm font-medium text-gray-700 whitespace-nowrap">Find</label>
                <input type="text" id="find-text" placeholder="Enter search text"
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div class="flex items-center space-x-2 w-110">
                <label for="replace-text" class="text-sm font-medium text-gray-700 whitespace-nowrap">Replace with</label>
                <input type="text" id="replace-text" placeholder="Enter replace text"
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <button class="px-6 py-2.5 text-sm font-medium text-white bg-purple-600 rounded-md shadow-md hover:bg-purple-700 transition duration-150 h-10">
                Replace
            </button>
        </div>

        <div class="mt-4 flex items-center text-left">
            <input id="match-whole-words" type="checkbox" class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
            <label for="match-whole-words" class="ml-2 text-sm text-gray-900 select-none">
                Match whole words
            </label>
        </div>
    </div>

    <div class="w-full max-w-4xl flex flex-col items-center justify-center pt-8">

        <div class="mb-6 w-80 h-auto mx-auto">
             <img src="{{ asset('image/apiimage3.png') }}" alt="Find and Replace Illustration" class="mx-auto max-w-full h-auto">
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mt-4">
            Find and replace any content
        </h3>
        <p class="mt-2 text-base text-gray-500 text-center">
            Replace any words, phrases and numbers in your articles / category pages
        </p>
    </div>
</div>
             <!-- Customize Page -->
<div x-show="menuState === 'site-builder' && siteBuilderState === 'customize-site'"
     x-transition:enter.duration.500ms
     x-transition:leave.duration.300ms
     class="w-full h-full flex flex-col items-center justify-start p-8 overflow-y-auto bg-gray-50">

    <div class="w-full max-w-7xl bg-white p-6 shadow-md rounded-lg mb-4 sticky top-0 z-10">
        <div class="flex justify-between items-center pb-4 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Customize site</h2>
            <div class="space-x-2">
                <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150">
                    Cancel
                </button>
                <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 transition duration-150">
                    Save
                </button>
            </div>
        </div>

        <div class="flex items-start space-x-4 pt-0">
            <div class="p-3 bg-white rounded-lg ">
                <img src="{{ asset('image/site1.png') }}" alt="Customize Site Icon" class="w-20 h-20 object-cover">
            </div>

            <div class="flex flex-col">
                <h3 class="text-xl font-semibold text-gray-800 mb-1 text-left">Site design</h3>
                <p class="text-sm text-gray-600 mb-4 max-w-4xl text-left">Personalize your website by incorporating branding elements, header and footer sections, homepage, login page, and error pages all in one central location.</p>

                <div class="flex space-x-4">
                    <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 transition duration-150 flex items-center space-x-2">
                        <i class="fa-solid fa-pen"></i>
                        <span>Customize site</span>
                    </button>
                    <a href="#" class="flex items-center space-x-1 text-sm font-medium  text-blue-600 transition duration-150 self-center">
                        <i class="fa-solid fa-code"></i>
                        <span>Custom CSS & JavaScript
                            <i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </a>
                </div>

        <div class="border-b border-gray-300 pt-4 mb-6"></div>

        <div class="border-b border-gray-300 pb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Site theme</h3>
            <div class="flex items-center space-x-6">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="site-theme" class="text-purple-600 focus:ring-purple-500 w-4 h-4" checked>
                    <span class="text-sm font-medium text-gray-700 flex items-center">
                        <i class="fa-solid fa-sun text-gray-500 mr-1"></i>
                        Both Light & Dark
                    </span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="site-theme" class="text-purple-600 focus:ring-purple-500 w-4 h-4">
                    <span class="text-sm font-medium text-gray-700">Light only</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="site-theme" class="text-purple-600 focus:ring-purple-500 w-4 h-4">
                    <span class="text-sm font-medium text-gray-700">Dark only</span>
                </label>
            </div>
        </div>

        <div class="border-b border-gray-300 pb-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Branding</h3>

    <div class="flex flex-col space-y-4 mb-8">

        <div class="flex justify-start">

            <div class="flex space-x-4">

                <div class="w-35 h-35 border border-gray-300 rounded-lg flex flex-col items-center justify-end p-2 cursor-pointer bg-white shadow-md">
                    <img src="{{ asset('image/kblogo.png') }}" alt="Light Theme Logo" class="w-full h-auto object-contain mb-3">
                    <div class="text-xs text-gray-400">Click to change</div>
                </div>

                <div class="w-35 h-35 border border-gray-300 rounded-lg flex flex-col items-center justify-end p-2 cursor-pointer bg-black shadow-md">
                    <img src="{{ asset('image/kblogo.png') }}" alt="Dark Theme Logo" class="w-full h-auto object-contain mb-3" style="filter: invert(1);">
                    <div class="text-xs text-gray-400 text-white">Click to change</div>
                </div>
            </div>

                    <div class="mt-4 flex items-center text-left">
                        <input id="match-whole-words" type="checkbox"
                            class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <label for="match-whole-words" class="ml-2 text-sm text-gray-900 select-none">
                            Match whole words
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col space-y-4 pt-4">

        <div class="flex justify-start items-start">

            <div class="w-70 h-35 border border-gray-300 rounded-lg flex flex-col items-center justify-center p-2 cursor-pointer bg-white shadow-md">
                <img src="{{ asset('image/kbai.png') }}" alt="Favicon" class="w-8 h-8 object-contain mb-3">
                <button class="text-xs text-gray-400">Click to change</button>
            </div>

            <div class="ml-8 pt-2">
                <p class="text-sm font-medium text-gray-700 text-left">Favicon <i class="fa-solid fa-info-circle text-gray-400 text-xs ml-1"></i></p>
                <p class="text-xs text-gray-500 mt-1 max-w-xl text-left">
                    Max size: 200KB | Supported formats: ICO, PNG, SVG | Recommended resolutions: 16×16, 32×32, 48×48, 64×64, 128×128, 180×180, and 256×256 pixels.
                </p>
            </div>
        </div>
    </div>
</div>

        <div class="border-b border-gray-300 pb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Colors</h3>

            <div class="mb-4 flex items-center space-x-2">
                <input id="auto-contrast" type="checkbox" class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500" checked>
                <label for="auto-contrast" class="text-sm text-gray-900 select-none">
                    Auto set color contrast to meet <span class="text-purple-600 font-semibold hover:underline">WCAG</span> standards
                </label>
            </div>
            <p class="text-xs text-gray-500 mb-4 max-w-xl">By setting auto color contrast and your color preference, we will auto apply the right color for your site elements.</p>

            <div class="mb-6">
                <label for="brand-color" class="text-sm font-medium text-gray-700 block mb-1 text-left">Brand color</label>
                <p class="text-xs text-gray-500 mb-2 text-left">This will be used as primary color for CTA's, Selection states etc.</p>
                <div class="flex items-center space-x-4">
                    <div class="relative flex items-center border border-gray-300 rounded-lg p-2">
                         <div class="w-6 h-6 rounded mr-2" style="background-color: #400B56;"></div>
                         <input type="text" id="brand-color" value="#400B56" class="text-sm w-24 border-none focus:ring-0 p-0">
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mt-4">
                        Find and replace any content
                    </h3>
                    <p class="mt-2 text-base text-gray-500 text-center">
                        Replace any words, phrases and numbers in your articles / category pages
                    </p>
                </div>
            </div>
            <!-- Customize Page -->
            <div x-show="menuState === 'site-builder' && siteBuilderState === 'customize-site'"
                x-transition:enter.duration.500ms x-transition:leave.duration.300ms
                class="w-full h-full flex flex-col items-start justify-start overflow-y-auto bg-gray-50 scrollbar-hide p-8">

            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1 text-left">Hyperlink color</label>
                <p class="text-xs text-gray-500 mb-2 text-left">This will be used as primary color for CTA's, Selection states etc.</p>

                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="hyperlink-color" class="text-purple-600 focus:ring-purple-500 w-4 h-4" checked>
                        <span class="text-sm font-medium text-gray-700">Use Industry standard</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="hyperlink-color" class="text-purple-600 focus:ring-purple-500 w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Use brand color</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="hyperlink-color" class="text-purple-600 focus:ring-purple-500 w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Use a different color</span>
                    </label>
                </div>

                    <div class="flex items-start space-x-4 pt-0">
                        <div class="p-3 bg-white rounded-lg ">
                            <img src="{{ asset('image/site1.png') }}" alt="Customize Site Icon"
                                class="w-20 h-20 object-cover">
                        </div>

        <div class="border-b border-gray-300 pb-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Fonts</h3>
    <p class="text-base font-medium text-gray-700 mb-1 text-left">Article font pairing</p>
    <p class="text-xs text-gray-500 mb-4 text-left">This will be applied at your article Titles and Contents.</p>

    <div class="flex space-x-8 overflow-x-auto pb-4">

        <div class="flex flex-col items-center">
            <div class="min-w-[125px] h-70 border-2 border-purple-600 p-3 rounded-lg bg-purple-50 cursor-pointer">
                <p class="text-sm font-semibold mb-2" style="font-family: 'Thillium Web', sans-serif;">Why did we build Document360?</p>
                <p class="text-xs text-gray-600" style="font-family: 'Inter', sans-serif;">Exploring a new product... (Preview text)</p>
            </div>
            <p class="mt-2 text-xs font-semibold text-gray-700 text-center">Thillium Web + Inter</p>
        </div>

                            <div class="flex space-x-4">
                                <button
                                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-md hover:bg-purple-700 transition duration-150 flex items-center space-x-2">
                                    <i class="fa-solid fa-pen"></i>
                                    <span>Customize site</span>
                                </button>
                                <a href="#"
                                    class="flex items-center space-x-1 text-sm font-medium  text-blue-600 transition duration-150 self-center">
                                    <i class="fa-solid fa-code"></i>
                                    <span>Custom CSS & JavaScript
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-gray-300 pt-4 mb-6"></div>

        <div class="flex flex-col items-center">
            <div class="min-w-[125px] h-70 border border-gray-300 p-3 rounded-lg bg-white hover:border-purple-500 cursor-pointer">
                <p class="text-sm font-semibold mb-2" style="font-family: 'Roboto', sans-serif;">Why did we build Document360?</p>
                <p class="text-xs text-gray-600" style="font-family: 'Nunito', sans-serif;">Exploring a new product... (Preview text)</p>
            </div>
            <p class="mt-2 text-xs font-semibold text-gray-700 text-center">Roboto + Nunito</p>
        </div>
    </div>

    <p class="text-sm text-gray-600 mt-4 cursor-pointer underline text-left">Have a specific font combination in mind?</p>

    <div class="mt-6 text-left">
        <label for="site-font" class="text-base font-medium text-gray-700 block mb-1 text-left">Site font</label>
        <p class="text-xs text-gray-500 mb-2 text-left">This will be applied to all your KB site menu, navigation and everything else!</p>
        <select id="site-font" class="w-64 border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500">
            <option>Inter</option>
            <option>Roboto</option>
        </select>
    </div>
</div>

        <div class="border-b border-gray-300 pb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Styling</h3>
            <p class="text-base font-medium text-gray-700 mb-2 text-left">Buttons / Form elements style</p>

            <div class="flex items-center space-x-4">
                <button class="px-4 py-2 text-sm font-medium text-purple-600 bg-purple-50 border border-purple-600 rounded-lg shadow-sm">
                    Rounded
                </button>
                 <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-none shadow-sm hover:bg-gray-50">
                    Sharp
                </button>
                 <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50">
                    Bubble
                </button>
            </div>
        </div>

        <div>
    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Site layout</h3>

    <div class="flex flex-col gap-6">

        <div class="flex items-center space-x-6">
            <div class="w-80 h-40">
                <div class="p-4 border-2 border-purple-600 rounded-lg bg-white cursor-pointer w-full h-full">

                    <div class="w-full h-full flex space-x-2">
                        <div class="w-1/4 h-full bg-gray-200 rounded-sm"></div>

                        <div class="w-3/4 h-full flex flex-col justify-start pt-2 space-y-4">
                            <div class="w-full h-4 bg-gray-200 rounded-sm"></div>

                            <div class="space-y-2">
                                <div class="w-full h-3 bg-gray-300 rounded-sm"></div>
                                <div class="w-11/12 h-3 bg-gray-300 rounded-sm"></div>
                                <div class="w-10/12 h-3 bg-gray-300 rounded-sm"></div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-gray-300 pb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Colors</h3>

                        <div class="mb-4 flex items-center space-x-2">
                            <input id="auto-contrast" type="checkbox"
                                class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500" checked>
                            <label for="auto-contrast" class="text-sm text-gray-900 select-none">
                                Auto set color contrast to meet <span
                                    class="text-purple-600 font-semibold hover:underline">WCAG</span> standards
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mb-4 max-w-xl">By setting auto color contrast and your color
                            preference, we will auto apply the right color for your site elements.</p>

                        <div class="mb-6">
                            <label for="brand-color" class="text-sm font-medium text-gray-700 block mb-1 text-left">Brand
                                color</label>
                            <p class="text-xs text-gray-500 mb-2 text-left">This will be used as primary color for CTA's,
                                Selection states etc.</p>
                            <div class="flex items-center space-x-4">
                                <div class="relative flex items-center border border-gray-300 rounded-lg p-2">
                                    <div class="w-6 h-6 rounded mr-2" style="background-color: #400B56;"></div>
                                    <input type="text" id="brand-color" value="#400B56"
                                        class="text-sm w-24 border-none focus:ring-0 p-0">
                                </div>
                                <button
                                    class="flex items-center space-x-1 px-3 py-1 text-xs text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-150">
                                    <i class="fa-solid fa-lightbulb text-yellow-500"></i>
                                    <span>on light theme &</span>
                                </button>
                                <button
                                    class="flex items-center space-x-1 px-3 py-1 text-xs text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-150">
                                    <i class="fa-solid fa-moon text-gray-500"></i>
                                    <span>on dark theme</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700 block mb-1 text-left">Hyperlink color</label>
                            <p class="text-xs text-gray-500 mb-2 text-left">This will be used as primary color for CTA's,
                                Selection states etc.</p>

                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="hyperlink-color"
                                        class="text-purple-600 focus:ring-purple-500 w-4 h-4" checked>
                                    <span class="text-sm font-medium text-gray-700">Use Industry standard</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="hyperlink-color"
                                        class="text-purple-600 focus:ring-purple-500 w-4 h-4">
                                    <span class="text-sm font-medium text-gray-700">Use brand color</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="hyperlink-color"
                                        class="text-purple-600 focus:ring-purple-500 w-4 h-4">
                                    <span class="text-sm font-medium text-gray-700">Use a different color</span>
                                </label>
                            </div>

                            <div class="flex space-x-3 mt-4">
                                <button
                                    class="px-6 py-1.5 text-xs font-semibold text-purple-500 bg-white underline">Link</button>
                                <button
                                    class="px-6 py-1.5 text-xs font-semibold text-purple-700 bg-white underline">Link</button>
                                <button
                                    class="px-6 py-1.5 text-xs font-semibold text-pink-800 bg-white underline">Link</button>
                                <button
                                    class="px-6 py-1.5 text-xs font-semibold text-purple-500 bg-gray-800 rounded-lg">Link</button>
                                <button
                                    class="px-6 py-1.5 text-xs font-semibold text-purple-700 bg-gray-800 rounded-lg">Link</button>
                                <button
                                    class="px-6 py-1.5 text-xs font-semibold text-pink-800 bg-gray-800 rounded-lg">Link</button>
                            </div>
                        </div>
                    </div>
            </div>

            <div>
                <p class="text-base font-medium text-gray-700 text-left">Full width</p>
                <p class="text-sm text-gray-600 mt-1 max-w-lg">
                    Your KB site will adopt to customers/users screen resolution for the best fit.
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-6">
            <div class="w-80 h-40">
                <div class="p-4 border-1 border-gray-400  rounded-lg bg-white cursor-pointer w-full h-full">

                    <div class="w-full h-full flex space-x-2">
                        <div class="w-1/4 h-full bg-gray-200 rounded-sm"></div>

                        <div class="w-3/4 h-full flex flex-col justify-start pt-2 space-y-4">
                            <div class="w-full h-4 bg-gray-200 rounded-sm"></div>

                            <div class="space-y-2">
                                <div class="w-full h-3 bg-gray-300 rounded-sm"></div>
                                <div class="w-11/12 h-3 bg-gray-300 rounded-sm"></div>
                                <div class="w-10/12 h-3 bg-gray-300 rounded-sm"></div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mt-4 cursor-pointer underline text-left">Have a specific font
                            combination in mind?</p>

                        <div class="mt-6 text-left">
                            <label for="site-font" class="text-base font-medium text-gray-700 block mb-1 text-left">Site
                                font</label>
                            <p class="text-xs text-gray-500 mb-2 text-left">This will be applied to all your KB site menu,
                                navigation and everything else!</p>
                            <select id="site-font"
                                class="w-64 border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500">
                                <option>Inter</option>
                                <option>Roboto</option>
                            </select>
                        </div>
                    </div>

                    <div class="border-b border-gray-300 pb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Styling</h3>
                        <p class="text-base font-medium text-gray-700 mb-2 text-left">Buttons / Form elements style</p>

                        <div class="flex items-center space-x-4">
                            <button
                                class="px-4 py-2 text-sm font-medium text-purple-600 bg-purple-50 border border-purple-600 rounded-lg shadow-sm">
                                Rounded
                            </button>
                            <button
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-none shadow-sm hover:bg-gray-50">
                                Sharp
                            </button>
                            <button
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50">
                                Bubble
                            </button>
                        </div>
                    </div>
            </div>

            <div>
                <p class="text-base font-medium text-gray-700 text-left">Center</p>
                <p class="text-sm text-gray-600 mt-1 max-w-lg text-left">
                    Your KB site will be restricted to certain width on every screen your customers/users are viewing.
                </p>
            </div>
        </div>
    </div>
</div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 text-left">Site layout</h3>

                        <div class="flex flex-col gap-6">

                            <div class="flex items-center space-x-6">
                                <div class="w-80 h-40">
                                    <div
                                        class="p-4 border-2 border-purple-600 rounded-lg bg-white cursor-pointer w-full h-full">

                                        <div class="w-full h-full flex space-x-2">
                                            <div class="w-1/4 h-full bg-gray-200 rounded-sm"></div>

@endsection
