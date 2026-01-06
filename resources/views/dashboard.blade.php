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

                @livewire('dashboard.document-list')
                <!-- Analytics and Comments -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="analyticsData()">
                    <!-- Analytics -->
                    @livewire('dashboard.dashboard-analyatics')

                    <!-- Comments -->
                    @livewire('dashboard.comments')

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
