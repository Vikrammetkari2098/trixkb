@extends('layouts.app')
@section('content')
    <style>

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        }

        .shadow-soft {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08);
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .segmented-tab {
            border-radius: 0.5rem;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }

        .segmented-tab:last-child {
            border-right: none;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
    </style>
    <div class="text-gray-800" x-data="dashboard()">
        <div class="min-h-screen bg-gray-50">
            <!-- Main Content -->
            <div>
                <!-- Header with Greeting -->
            <div class="mb-6" x-data="greetingData()">
                    <!-- one gradient for both blocks -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4
                                p-4 md:p-6 rounded-xl shadow-soft"
                        style="background: linear-gradient(90deg, #ffffff 0%, #ffffff 40%, #F4C6FF 70%, #C4A4FF 100%);">

                        <!-- Greeting -->
                        <div class="w-full md:w-1/2">
                            <p class="text-sm text-gray-500 font-medium mb-1" x-text="currentDate"></p>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                                <span class="mr-3 text-yellow-500">
                                    <svg x-show="isMorning" class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <svg x-show="isAfternoon" class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <svg x-show="isEvening" class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                </span>
                                <span x-text="greetingMessage"></span>
                            </h1>
                        </div>

                        <!-- Promo -->
                        <div class="relative w-full md:w-1/2 h-32 md:h-40 flex items-center justify-start">
                            <div class="relative z-10 text-gray-800 px-2 md:px-4">
                                <h2 class="text-lg md:text-xl font-semibold mb-2 leading-tight">
                                    Effortless documentation with<br>Eddy AI.
                                    <a href="#" class="text-blue-700 hover:underline font-medium">Learn more</a>
                                </h2>
                            </div>
                            <img src="{{ asset('image/dashboard.png') }}" alt="Eddy AI Illustration"
                                class="absolute right-0 bottom-0 h-full object-contain" />
                        </div>
                    </div>
                </div>
                <!-- Tasks Section -->
                @livewire('dashboard.task-list')


                <!-- Documents Section -->
                <div class="bg-white rounded-xl shadow-soft p-5 md:p-6 mb-6" x-data="{ activeTab: 'recent' }">
                    <div class="mb-6 flex flex-col sm:flex-row justify-between sm:items-end gap-4">
                        <div class="flex items-center">
                            <h2 class="text-xl font-bold text-gray-800 mr-4">Documents</h2>
                            <button class="text-blue-600 text-sm font-medium hover:underline">View all</button>
                        </div>
                        <div class="relative w-full sm:max-w-sm">
                            <input type="text" placeholder="Search articles" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="mb-6 border-b border-gray-200">
                        <div class="flex -mb-px space-x-2 sm:space-x-4">
                            <button
                                @click="activeTab = 'recent'"
                                :class="{
                                    'border-blue-500 text-blue-600': activeTab === 'recent',
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'recent'
                                }"
                                class="py-2 px-4 text-sm font-medium border-b-2 rounded-t-lg transition-colors duration-150"
                            >
                                Recent
                            </button>
                            <button
                                @click="activeTab = 'starred'"
                                :class="{
                                    'border-blue-500 text-blue-600': activeTab === 'starred',
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'starred'
                                }"
                                class="py-2 px-4 text-sm font-medium border-b-2 rounded-t-lg transition-colors duration-150"
                            >
                                Starred
                            </button>
                        </div>
                    </div>

                    <!-- Recent Documents -->
                    <div x-show="activeTab === 'recent'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                        <!-- Document Cards -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover-lift cursor-pointer">
                            <div class="h-20 bg-green-50 border-b border-gray-100 flex items-center justify-center p-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center border border-green-200">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.275a1.8 1.8 0 010 2.55L14.55 12.5a2 2 0 01-2.83 0L7.432 8.35a1.8 1.8 0 010-2.55 1.8 1.8 0 012.55 0L12 8.62l2.018-2.825a1.8 1.8 0 012.55 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="p-3 text-sm">
                                <p class="font-semibold text-gray-800 mb-1 truncate">Product Installation Steps</p>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                    <span class="truncate">VM</span>
                                    <span class="mx-1">•</span>
                                    <span>This Tuesday</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover-lift cursor-pointer">
                            <div class="h-20 bg-yellow-50 border-b border-gray-100 flex items-center justify-center p-4">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center border border-yellow-200">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.46 9.58 5 8 5c-4 0-4.5 4-4.5 4s-.5 4 4.5 4c1.58 0 2.832-.46 4-.853m0-13c1.168.79 2.42 1.253 4 1.253 4 0 4.5-4 4.5-4s.5-4-4.5-4c-1.58 0-2.832.46-4 .853m-12 11c0 3.993 4.967 7.005 8 7.005s8-3.012 8-7.005M4 14c.732.228 1.517.345 2.333.345C8.423 14.345 12 14 12 14"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="p-3 text-sm">
                                <p class="font-semibold text-gray-800 mb-1 truncate">New Article</p>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                    <span class="truncate">VM</span>
                                    <span class="mx-1">•</span>
                                    <span>This Tuesday</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover-lift cursor-pointer">
                            <div class="h-20 bg-green-50 border-b border-gray-100 flex items-center justify-center p-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center border border-green-200">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="p-3 text-sm">
                                <p class="font-semibold text-gray-800 mb-1 truncate">Initial Setup Guide</p>
                                <div class="flex items-center text-gray-500 text-xs">
                                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                    <span class="truncate">VM</span>
                                    <span class="mx-1">•</span>
                                    <span>This Tuesday</span>
                                </div>
                            </div>
                        </div>

                        <!-- Create New Article Card -->
                        <div class="border-2 border-dashed border-blue-300 bg-blue-50 rounded-xl flex items-center justify-center p-4 transition-colors duration-300 hover:bg-blue-100 hover:border-blue-400 cursor-pointer h-full min-h-[120px] hover-lift">
                            <div class="text-center">
                                <div class="w-10 h-10 rounded-full border-2 border-blue-300 flex items-center justify-center mx-auto mb-2 bg-white">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-blue-600">Create article</p>
                            </div>
                        </div>
                    </div>

                    <!-- Starred Documents -->
                    <div x-show="activeTab === 'starred'" class="flex flex-col items-center justify-center min-h-[300px] py-10">
                        <img src="{{ asset('image/starred.png') }}" alt="No starred items illustration" class="mx-auto w-40 h-40 mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No items to display</h3>
                        <p class="text-gray-500 mb-6">You haven't starred any items yet.</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors duration-150 shadow-md">
                            Create article
                        </button>
                    </div>
                </div>
                @livewire('dashboard.document-list')
                <!-- Analytics and Comments -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="analyticsData()">
                    <!-- Analytics -->
                    <div class="bg-white rounded-xl shadow-soft p-5 md:p-6 border border-gray-100" x-data="{ activeTab: 'content' }">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Analytics</h3>
                            <button class="text-blue-600 text-sm font-medium hover:underline">View all</button>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4 mb-4 gap-3">
                            <div class="flex space-x-2">
                                <button @click="activeTab = 'content'"
                                    :class="{
                                        'bg-blue-100 text-blue-700 border-blue-500': activeTab === 'content',
                                        'text-gray-600 hover:text-blue-600 border-transparent': activeTab !== 'content'
                                    }"
                                    class="py-1.5 px-3 text-sm font-medium rounded-lg border-2 transition-colors duration-150">
                                    Content overview
                                </button>
                                <button @click="activeTab = 'project'"
                                    :class="{
                                        'bg-blue-100 text-blue-700 border-blue-500': activeTab === 'project',
                                        'text-gray-600 hover:text-blue-600 border-transparent': activeTab !== 'project'
                                    }"
                                    class="py-1.5 px-3 text-sm font-medium rounded-lg border-2 transition-colors duration-150">
                                    Project overview
                                </button>
                            </div>

                            <div class="relative" x-data="{ open: false, timeFilter: 'Last Week' }" @click.away="open = false">
                                <button @click="open = !open"
                                    class="flex items-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg py-1.5 px-3 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <span x-text="timeFilter"></span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

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

                        <!-- Content Overview -->
                        <div x-show="activeTab === 'content'" class="space-y-4">
                            <h4 class="text-gray-800 font-semibold">Created articles <span class="font-bold text-lg ml-1">3</span></h4>

                            <div class="w-full h-2 bg-green-200 rounded-full overflow-hidden mb-1">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 100%;"></div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <p><span class="status-dot bg-yellow-500"></span>Draft (<span class="font-semibold">3</span>)</p>
                                <p><span class="status-dot bg-green-500"></span>Published (<span class="font-semibold">0</span>)</p>
                            </div>

                            <div class="pt-2 space-y-3 text-gray-700">
                                <p class="flex justify-between">Views <span class="font-bold">1</span></p>
                                <p class="flex justify-between">Reads <span class="font-bold">0</span></p>
                                <p class="flex justify-between">Likes <span class="font-bold">0</span></p>
                                <p class="flex justify-between">Dislikes <span class="font-bold">0</span></p>
                                <p class="flex justify-between text-red-500">
                                    <a href="#" class="flex items-center hover:underline">
                                        Broken Links
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </a>
                                    <span class="font-bold">0</span>
                                </p>
                            </div>

                            <p class="text-xs text-gray-400 mt-4 pt-4 border-t border-gray-100">Note: This data represents analytics for all contributors.</p>
                        </div>

                        <!-- Project Overview -->
                        <div x-show="activeTab === 'project'" class="space-y-4 pt-1">
                            <div class="flex justify-between items-center text-gray-700 pb-2">
                                <p class="text-base">Recent logins</p>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <div class="w-6 h-6 bg-purple-200 rounded-full flex items-center justify-center text-purple-600 font-medium text-xs">VM</div>
                                </div>
                            </div>

                            <div class="text-gray-700 pb-3 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <p class="text-base">Team accounts</p>
                                    <span class="font-bold text-base text-gray-800">1</span>
                                </div>
                                <a href="#" class="text-blue-600 text-sm font-medium hover:underline block mt-1">Manage team</a>
                            </div>

                            <div class="text-gray-700 pb-3 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <p class="text-base">Readers</p>
                                    <span class="font-bold text-base text-gray-800">0</span>
                                </div>
                                <a href="#" class="text-blue-600 text-sm font-medium hover:underline block mt-1">Manage readers</a>
                            </div>

                            <div class="text-gray-700 pb-3 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <p class="text-base">Drive storage</p>
                                    <span class="font-bold text-sm text-gray-600">0.00 bytes used of 500GB</span>
                                </div>
                                <a href="#" class="text-blue-600 text-sm font-medium hover:underline block mt-1">Manage files</a>
                            </div>

                            <div class="text-gray-700 pt-1">
                                <p class="text-base mb-1">Failed searches</p>
                                <div class="flex justify-end space-x-6 text-sm">
                                    <div class="text-gray-500 text-right">Search <p class="text-blue-600 font-bold">0</p></div>
                                    <div class="text-gray-500 text-right">Eddy AI <p class="text-blue-600 font-bold">0</p></div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center text-gray-700 pt-3 border-t border-gray-100">
                                <p class="text-base">Last backup</p>
                                <span class="font-medium text-sm text-gray-600">15 Oct 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Comments -->
                    <div class="bg-white rounded-xl shadow-soft p-5 md:p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Comments</h3>
                            <p class="text-xs text-gray-500">Last updated 9 minutes ago</p>
                        </div>

                        <div class="p-6 md:p-8 text-center mt-4">
                            <img src="{{ asset('image/comment.png') }}" alt="No open comments illustration" class="mx-auto w-32 h-32 md:w-40 md:h-40 mb-6">
                            <h3 class="text-lg md:text-xl font-semibold text-gray-600 mb-2">No open comments</h3>
                            <p class="text-gray-500">There are no open comments for review right now.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('greetingData', () => ({
                    currentDate: '',
                    greetingMessage: '',
                    isMorning: false,
                    isAfternoon: false,
                    isEvening: false,
                    userName: '{{ $userName }}',

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

                Alpine.data('tasksSection', () => ({
                    activeAssigned: 'Assigned to me',
                    activeWorkflowTab: 'workflow',

                    tasks: {
                        workflow: [
                            {id:3, title:'Fix Workflow Bug Description', assigned:'Barry Allen', due:'Oct 22, 2025', priority:'High', priorityClass:'bg-red-100 text-red-700 border border-red-200', status:'Pending Review', statusClass:'bg-yellow-100 text-yellow-700 border border-yellow-200'}
                        ],
                        feedback: [],
                        review: [
                            {id:1, title:'Update Project Documentation', assigned:'Charles Franklin', due:'Oct 20, 2025', priority:'Medium', priorityClass:'bg-yellow-100 text-yellow-700 border border-yellow-200', status:'In Progress', statusClass:'bg-green-100 text-green-700 border border-green-200'},
                            {id:2, title:'Review API Integration Guide', assigned:'Natalie Smith', due:'Oct 21, 2025', priority:'High', priorityClass:'bg-red-100 text-red-700 border border-red-200', status:'Pending', statusClass:'bg-yellow-100 text-yellow-700 border border-yellow-200'}
                        ]
                    }
                }));

                Alpine.data('analyticsData', () => ({
                    activeTab: 'content',
                    timeFilter: 'Last week',
                }));

                Alpine.data('dashboard', () => ({
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
                }));
            });
        </script>
    </div>
@endsection
