    @extends('layouts.app')
    @section('content')
        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                font-family: 'Inter', sans-serif;
            }
            /* Custom style for segmented tabs */
            .segmented-tab {
                border-radius: 0.5rem; /* Matches the image's overall corner radius */
                border-right: 1px solid rgba(255, 255, 255, 0.3); /* Slight divider */
            }
            .segmented-tab:last-child {
                border-right: none;
            }
        </style>
        <style>
            /* Hide scrollbar for Chrome, Safari and Opera */
            .scrollbar-hide::-webkit-scrollbar {
            display: none;
            }

            /* Hide scrollbar for IE, Edge and Firefox */
            .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
            }
        </style>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#3498db',
                            secondary: '#2c3e50',
                            accent: '#7f8c8d',
                            light: '#f9fafb',
                            card: '#ffffff',
                            lavender: '#efe7fb',
                            lavenderDark: '#5d3b9e',
                        }
                    }
                }
            }
        </script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('greetingData', () => ({
                    currentDate: '',
                    greetingMessage: '',
                    isMorning: false,
                    isAfternoon: false,
                    isEvening: false,
                    userName: '{{ $userName }}', // Pass PHP variable to JavaScript

                    init() {
                        this.updateDateTime();
                        setInterval(() => this.updateDateTime(), 1000 * 60);
                    },

                    updateDateTime() {
                        const now = new Date();
                        const options = { weekday: 'long', month: 'long', day: 'numeric' };
                        this.currentDate = now.toLocaleDateString('en-US', options);

                        const hour = now.getHours();
                        if (hour >= 5 && hour < 12) {
                            this.greetingMessage = `Good morning, ${this.userName}!`;
                            this.isMorning = true;
                        } else if (hour >= 12 && hour < 18) {
                            this.greetingMessage = `Good afternoon, ${this.userName}!`;
                            this.isAfternoon = true;
                        } else {
                            this.greetingMessage = `Good evening, ${this.userName}!`;
                            this.isEvening = true;
                        }
                    }
                }));
            });
        </script>


    <body class="bg-light text-gray-800" x-data="dashboard()">
        <div  class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex h-screen overflow-hidden">
                <!-- Main Content Wrapper -->
                <div class="flex-1 flex flex-col overflow-auto">
                    <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 scrollbar-hide">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center mb-6">
                            <div class="p-4 lg:p-0" x-data="greetingData()">
                                <p class="text-sm text-gray-500 font-medium mb-1" x-text="currentDate"></p>
                                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                                    <span class="mr-3 text-yellow-500">
                                        <svg x-show="isMorning" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <svg x-show="isAfternoon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <svg x-show="isEvening" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                                    </span>
                                    <span x-text="greetingMessage"></span>
                                </h1>
                            </div>

                            <div class="relative rounded-xl overflow-hidden shadow-lg lg:col-span-1 h-40 flex items-center justify-start p-6"
                                style="background: linear-gradient(to right, #e0c3fc 0%, #8ec5fc 100%);">
                                <div class="relative z-10 text-gray-800">
                                    <h2 class="text-xl font-semibold mb-2 leading-tight">
                                        Effortless documentation with<br>Eddy AI. <a href="#" class="text-primary hover:underline font-medium">Learn more</a>
                                    </h2>
                                </div>
                                <img src="{{ asset('image/dashboard.png') }}" alt="Eddy AI Illustration" class="absolute right-0 bottom-0 h-full object-cover">
                        </div>

                        <!-- Tasks Section with Tabs -->
                        <div class="bg-card rounded-xl shadow-lg overflow-hidden" x-data="tasksSection()">
                            <!-- Header with Status Filters -->
                            <div class="flex justify-between items-start p-4 border-b border-gray-100 flex-col sm:flex-row">
                                <h2 class="text-xl font-bold text-secondary flex items-center mb-3 sm:mb-0">
                                    Tasks
                                    <button class="text-primary text-sm font-medium hover:underline ml-3">View all</button>
                                </h2>

                                <!-- Status Filters (This week, Today, Overdue, Snoozed) -->
                                <div class="flex flex-wrap space-x-2 text-xs font-semibold">
                                    <button class="bg-red-100 text-red-700 px-3 py-1 rounded-full flex items-center">
                                        This week <span class="ml-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">0</span>
                                    </button>
                                    <button class="bg-gray-100 text-secondary px-3 py-1 rounded-full flex items-center">
                                        Today <span class="ml-1 bg-gray-400 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">0</span>
                                    </button>
                                    <button class="bg-red-100 text-red-700 px-3 py-1 rounded-full flex items-center">
                                        Overdue <span class="ml-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">0</span>
                                    </button>
                                    <button class="bg-gray-100 text-secondary px-3 py-1 rounded-full flex items-center">
                                        Snoozed <span class="ml-1 bg-gray-400 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">0</span>
                                    </button>
                                </div>
                            </div>

                        <div class="p-4 flex flex-col md:flex-row items-center gap-4 border-b border-gray-100">
                                <div class="relative inline-block" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center bg-card border border-gray-300 text-secondary font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                        <span x-text="activeAssigned">Assigned to me</span>
                                        <i class="fas fa-chevron-down text-xs ml-2 transition-transform duration-200" :class="open ? 'rotate-180' : 'rotate-0'"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10 border border-gray-200">
                                        <a href="#" @click.prevent="activeAssigned = 'Created by me'; open = false" class="block px-4 py-2 text-sm text-secondary hover:bg-gray-100">Vikram Metkari</a>
                                    </div>
                                </div>

                                <div class="flex rounded-lg overflow-hidden shadow-sm flex-shrink-0">
                                    <template x-for="tab in ['workflow', 'feedback', 'review']" :key="tab">
                                        <button @click="activeWorkflowTab=tab"
                                            :class="activeWorkflowTab === tab
                                                ? 'bg-white text-black shadow'
                                                : 'bg-[#e5ddf7] text-lavenderDark hover:bg-[#d5cbf2]'"
                                            class="px-4 py-2 text-sm font-semibold transition-colors duration-150 segmented-tab whitespace-nowrap capitalize border-r border-lavenderDark/20 last:border-r-0">
                                            <span x-text="tab"></span>
                                        </button>
                                    </template>
                                </div>

                                <div class="flex-1 w-full md:w-auto flex items-center space-x-2">
                                    <div class="relative w-full">
                                        <input type="text" placeholder="Search..."
                                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-all text-sm">
                                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-accent text-sm"></i>
                                    </div>
                                    <button class="p-3 border border-gray-300 rounded-lg text-accent hover:bg-gray-100 transition-colors flex-shrink-0">
                                        <i class="fas fa-sliders-h"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Task Table -->
                            <template x-if="tasks[activeWorkflowTab].length > 0">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-100 text-left">
                                        <thead class="bg-gray-50/50">
                                            <tr>
                                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Task</th>
                                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Assigned To</th>
                                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Due Date</th>
                                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Priority</th>
                                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="task in tasks[activeWorkflowTab]" :key="task.id">
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-6 py-4 font-medium text-secondary" x-text="task.title"></td>
                                                    <td class="px-6 py-4 text-sm text-accent" x-text="task.assigned"></td>
                                                    <td class="px-6 py-4 text-sm text-accent" x-text="task.due"></td>
                                                    <td class="px-6 py-4">
                                                        <span class="px-3 py-1 text-xs rounded-full" :class="task.priorityClass" x-text="task.priority"></span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="px-3 py-1 text-xs rounded-full" :class="task.statusClass" x-text="task.status"></span>
                                                    </td>
                                                    <td class="px-6 py-4 flex space-x-2">
                                                        <button class="text-primary hover:text-blue-700 text-sm font-medium">Open</button>
                                                        <button class="text-green-500 hover:text-green-700 text-sm font-medium">Complete</button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </template>

                            <!-- No Tasks Message -->
                            <template x-if="tasks[activeWorkflowTab].length === 0">
                                <div class="p-10 text-center">
                                    <img src="{{ asset('image/task.png') }}" alt="No open comments illustration" class="mx-auto w-40 h-40 mb-6">
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No tasks in this category</h3>
                                    <p class="text-accent">Sit back and relax. All tasks are complete or unassigned.</p>
                                </div>
                            </template>
                        </div>
                        <div class="bg-card rounded-xl shadow-lg p-5" x-data="{ activeTab: 'recent' }">

                            <div class="mb-6 flex flex-col sm:flex-row justify-between sm:items-end">
                                <div class="flex items-center mb-4 sm:mb-0">
                                    <h2 class="text-xl font-bold text-secondary mr-6">Documents</h2>
                                    <button class="text-primary text-sm font-medium hover:underline">View all</button>
                                </div>
                                <div class="relative w-full max-w-sm">
                                    <input type="text" placeholder="Search articles" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary text-secondary">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>

                            <div class="mb-6 border-b border-gray-200 w-fit">
                                <div class="flex -mb-px space-x-2 sm:space-x-4">
                                    <button
                                        @click="activeTab = 'recent'"
                                        :class="{
                                            'bg-purple-50 text-primary border-primary': activeTab === 'recent',
                                            'text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'recent'
                                        }"
                                        class="py-2 px-4 text-sm font-medium border-b-2 rounded-t-lg transition-colors duration-150 border-transparent"
                                    >
                                        Recent
                                    </button>
                                    <button
                                        @click="activeTab = 'starred'"
                                        :class="{
                                            'bg-purple-100 text-primary border-primary': activeTab === 'starred',
                                            'text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'starred'
                                        }"
                                        class="py-2 px-4 text-sm font-medium border-b-2 rounded-t-lg transition-colors duration-150 border-transparent"
                                    >
                                        Starred
                                    </button>
                                </div>
                            </div>


                            <div x-show="activeTab === 'recent'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

                                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden transition-shadow duration-300 hover:shadow-xl cursor-pointer">
                                    <div class="h-24 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-4">
                                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center border border-green-500/20">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.275a1.8 1.8 0 010 2.55L14.55 12.5a2 2 0 01-2.83 0L7.432 8.35a1.8 1.8 0 010-2.55 1.8 1.8 0 012.55 0L12 8.62l2.018-2.825a1.8 1.8 0 012.55 0z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="p-4 text-sm">
                                        <p class="font-semibold text-secondary mb-1 truncate">Product Installation Steps</p>
                                        <div class="flex items-center text-accent text-xs">
                                            <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                                            <span class="truncate">VM</span>
                                            <span class="mx-2">•</span>
                                            <span class="text-gray-500">This Tuesday</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden transition-shadow duration-300 hover:shadow-xl cursor-pointer">
                                    <div class="h-24 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-4">
                                        <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center border border-yellow-500/20">
                                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.46 9.58 5 8 5c-4 0-4.5 4-4.5 4s-.5 4 4.5 4c1.58 0 2.832-.46 4-.853m0-13c1.168.79 2.42 1.253 4 1.253 4 0 4.5-4 4.5-4s.5-4-4.5-4c-1.58 0-2.832.46-4 .853m-12 11c0 3.993 4.967 7.005 8 7.005s8-3.012 8-7.005M4 14c.732.228 1.517.345 2.333.345C8.423 14.345 12 14 12 14"></path></svg>
                                        </div>
                                    </div>
                                    <div class="p-4 text-sm">
                                        <p class="font-semibold text-secondary mb-1 truncate">New Article</p>
                                        <div class="flex items-center text-accent text-xs">
                                            <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                                            <span class="truncate">VM</span>
                                            <span class="mx-2">•</span>
                                            <span class="text-gray-500">This Tuesday</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden transition-shadow duration-300 hover:shadow-xl cursor-pointer">
                                    <div class="h-24 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-4">
                                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center border border-green-500/20">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="p-4 text-sm">
                                        <p class="font-semibold text-secondary mb-1 truncate">Initial Setup Guide</p>
                                        <div class="flex items-center text-accent text-xs">
                                            <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                                            <span class="truncate">VM</span>
                                            <span class="mx-2">•</span>
                                            <span class="text-gray-500">This Tuesday</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-2 border-dashed border-primary/50 bg-indigo-50/50 rounded-xl flex items-center justify-center p-6 transition-colors duration-300 hover:bg-indigo-100/50 hover:border-primary cursor-pointer h-full min-h-[160px]">
                                    <div class="text-center">
                                        <div class="w-12 h-12 rounded-full border-2 border-primary/30 flex items-center justify-center mx-auto mb-2 bg-white">
                                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-primary">Create article</p>
                                    </div>
                                </div>

                            </div>

                            <div x-show="activeTab === 'starred'" class="flex flex-col items-center justify-center min-h-[300px] py-10">
                                <img src="{{ asset('image/starred.png') }}"  alt="No starred items illustration" class="mx-auto w-48 h-48 mb-6">

                                <h3 class="text-xl font-semibold text-gray-800 mb-2">No items to display</h3>
                                <p class="text-gray-500 mb-6">You haven't starred any items yet.</p>

                                <button class="bg-primary hover:bg-primary/90 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-150 shadow-md">
                                    Create article
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="analyticsData()">
                            <div class="bg-white rounded-xl shadow-lg p-5 border border-gray-100" x-data="{ activeTab: 'content' }">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-secondary">Analytics</h3>
                                    <button class="text-primary text-sm font-medium hover:underline">View all</button>
                                </div>

                                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                                    <div class="flex space-x-2">
                                        <button @click="activeTab = 'content'" :class="{'bg-purple-100 text-primary border-primary': activeTab === 'content', 'text-gray-600 hover:text-primary border-transparent': activeTab !== 'content'}" class="py-1 px-3 text-sm font-medium rounded-lg border-2 transition-colors duration-150">Content overview</button>
                                        <button @click="activeTab = 'project'" :class="{'bg-purple-100 text-primary border-primary': activeTab === 'project', 'text-gray-600 hover:text-primary border-transparent': activeTab !== 'project'}" class="py-1 px-3 text-sm font-medium rounded-lg border-2 transition-colors duration-150">Project overview</button>
                                    </div>

                                <div class="relative" x-data="{ open: false, timeFilter: 'Last Week' }" @click.away="open = false">
                                        <!-- Button -->
                                        <button @click="open = !open"
                                            class="flex items-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg py-1 px-3 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                            <span x-text="timeFilter"></span>
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Dropdown -->
                                        <div x-show="open" x-transition
                                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                            <ul class="py-1 text-sm text-gray-700">
                                                <li>
                                                    <button @click="timeFilter = 'Last Week'; open = false"
                                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">Last Week</button>
                                                </li>
                                                <li>
                                                    <button @click="timeFilter = 'Last Month'; open = false"
                                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">Last Month</button>
                                                </li>
                                                <li>
                                                    <button @click="timeFilter = 'Custom Date'; open = false"
                                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">Custom Date</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="activeTab === 'content'" class="space-y-3">
                                    <h4 class="text-secondary font-semibold">Created articles <span class="font-bold text-lg ml-1">3</span></h4>

                                    <div class="w-full h-2 bg-green-500 rounded-full overflow-hidden mb-1">
                                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 100%;"></div>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <p><span class="inline-block w-2 h-2 rounded-full bg-yellow-500 mr-1"></span>Draft (<span class="font-semibold">3</span>)</p>
                                        <p><span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1"></span>Published (<span class="font-semibold">0</span>)</p>
                                    </div>

                                    <div class="pt-2 space-y-3 text-secondary">
                                        <p class="flex justify-between">Views <span class="font-bold">1</span></p>
                                        <p class="flex justify-between">Reads <span class="font-bold">0</span></p>
                                        <p class="flex justify-between">Likes <span class="font-bold">0</span></p>
                                        <p class="flex justify-between">Dislikes <span class="font-bold">0</span></p>
                                        <p class="flex justify-between text-red-500">
                                            <a href="#" class="flex items-center hover:underline">
                                                Broken Links
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </a>
                                            <span class="font-bold">0</span>
                                        </p>
                                    </div>

                                    <p class="text-xs text-gray-400 mt-4 pt-4 border-t border-gray-100">Note: This data represents analytics for all contributors.</p>
                                </div>

                                <div x-show="activeTab === 'project'" class="space-y-4 pt-1">

                                    <div class="flex justify-between items-center text-secondary pb-2">
                                        <p class="text-base">Recent logins</p>
                                        <div class="flex items-center text-accent text-sm">
                                            <div class="w-6 h-6 bg-purple-200 rounded-full flex items-center justify-center text-purple-600 font-medium text-xs">VM</div>
                                        </div>
                                    </div>

                                    <div class="text-secondary pb-2 border-b border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <p class="text-base">Team accounts</p>
                                            <span class="font-bold text-base text-gray-800">1</span>
                                        </div>
                                        <a href="#" class="text-primary text-sm font-medium hover:underline block mt-1">Manage team</a>
                                    </div>

                                    <div class="text-secondary pb-2 border-b border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <p class="text-base">Readers</p>
                                            <span class="font-bold text-base text-gray-800">0</span>
                                        </div>
                                        <a href="#" class="text-primary text-sm font-medium hover:underline block mt-1">Manage readers</a>
                                    </div>

                                    <div class="text-secondary pb-2 border-b border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <p class="text-base">Drive storage</p>
                                            <span class="font-bold text-sm text-gray-600">0.00 bytes used of 500GB</span>
                                        </div>
                                        <a href="#" class="text-primary text-sm font-medium hover:underline block mt-1">Manage files</a>
                                    </div>


                                    <div class="text-secondary pt-2">
                                        <p class="text-base mb-1">Failed searches</p>
                                        <div class="flex justify-end space-x-6 text-sm">
                                            <div class="text-gray-500 text-right">Search <p class="text-primary font-bold">0</p></div>
                                            <div class="text-gray-500 text-right">Eddy AI <p class="text-primary font-bold">0</p></div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center text-secondary pt-2 border-t border-gray-100">
                                        <p class="text-base">Last backup</p>
                                        <span class="font-medium text-sm text-gray-600">15 Oct 2025</span>
                                    </div>

                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-lg p-5 border border-gray-100">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-secondary">Comments</h3>
                                    <p class="text-xs text-accent">Last updated 9 minutes ago</p>
                                </div>

                                <div class="p-8 text-center mt-10">
                                    <img src="{{ asset('image/comment.png') }}" alt="No open comments illustration" class="mx-auto w-40 h-40 mb-6">
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No open comments</h3>
                                    <p class="text-accent">There are no open comments for review right now.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('analyticsData', () => ({
                activeTab: 'content',
                timeFilter: 'Last week',
            }));
        });
    </script>
        <script>
        function tasksSection() {
            return {
                activeAssigned: 'Assigned to me',
                activeWorkflowTab: 'workflow',

                tasks: {
                    workflow: [
                        {id:3, title:'Fix Workflow Bug Description', assigned:'Barry Allen', due:'Oct 22, 2025', priority:'High', priorityClass:'bg-red-100 text-red-700 border border-red-200', status:'Pending Review', statusClass:'bg-yellow-100 text-yellow-700 border border-yellow-200'}
                    ],
                    feedback: [
                    ],
                    review: [
                        {id:1, title:'Update Project Documentation', assigned:'Charles Franklin', due:'Oct 20, 2025', priority:'Medium', priorityClass:'bg-yellow-100 text-yellow-700 border border-yellow-200', status:'In Progress', statusClass:'bg-green-100 text-green-700 border border-green-200'},
                        {id:2, title:'Review API Integration Guide', assigned:'Natalie Smith', due:'Oct 21, 2025', priority:'High', priorityClass:'bg-red-100 text-red-700 border border-red-200', status:'Pending', statusClass:'bg-yellow-100 text-yellow-700 border border-yellow-200'}
                    ]
                }
            }
        }
        function dashboard() {
            return {
                isSidebarOpen: window.innerWidth >= 1024,
                activeSection: 'dashboard',
                greetingMessage: '',
                currentDate: '',

                init() {
                    this.updateDateTime();
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) {
                            this.isSidebarOpen = true;
                        }
                    });
                },

                updateDateTime() {
                    const now = new Date();
                    const time = now.getHours();

                    if (time < 12) {
                        this.greetingMessage = "Good morning, Vikram!";
                    } else if (time < 18) {
                        this.greetingMessage = "Good afternoon, Vikram!";
                    } else {
                        this.greetingMessage = "Good evening, Vikram!";
                    }

                    this.currentDate = now.toLocaleDateString('en-US', {
                        weekday: 'long',
                        month: 'long',
                        day: 'numeric'
                    });
                }
            }
        }
        </script>
    </body>
    @endsection
