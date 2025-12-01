


<div  class="bg-white rounded-xl shadow-soft p-5 md:p-6 mb-6">
    <div
        class="bg-white rounded-xl shadow-soft p-5 md:p-6 mb-6""
        x-data="{ activeTab: 'recent', modalOpen: false }"
    >
        <!-- Header (Documents Title and Search) -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800 mr-2">Documents</h2>
                <button class="text-purple-600 text-sm font-medium hover:underline">View all</button>
            </div>

            <!-- Search Input -->
            <div class="relative w-full sm:max-w-xs order-first sm:order-last">
                <input type="text" placeholder="Search articles"
                    class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-700 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-500 transition">
                <!-- Search Icon (Lucide: Search) -->
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 10l3 3m0-3l-3 3M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

       <!-- Tabs Container -->
        <div class="mb-6 flex">
            <div class="flex space-x-1 bg-white p-1 rounded-xl border border-gray-200">

                <!-- Recent Tab -->
                <button
                    @click="activeTab = 'recent'"
                    :class="{
                        'bg-blue-100 text-blue-700 border border-blue-500 shadow-sm': activeTab === 'recent',
                        'text-gray-600 hover:text-blue-600 border-transparent': activeTab !== 'recent'
                    }"
                    class="py-2 px-6 text-sm font-medium rounded-xl transition-all duration-200"
                >
                    Recent
                </button>

                <!-- Starred Tab -->
                <button
                    @click="activeTab = 'starred'"
                    :class="{
                        'bg-blue-100 text-blue-700 border border-blue-500 shadow-sm': activeTab === 'starred',
                        'text-gray-600 hover:text-blue-600 border-transparent': activeTab !== 'starred'
                    }"
                    class="py-2 px-6 text-sm font-medium rounded-xl transition-all duration-200"
                >
                    Starred
                </button>

            </div>
        </div>

        <!-- RECENT DOCUMENTS CONTENT -->
        <div x-show="activeTab === 'recent'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4 md:gap-6">

            <!-- Card Structure Helper Function -->
            <template x-for="(doc, index) in [
                { title: 'Integrations and API Documentation', time: '1 hour ago', user: 'VM', icon: 'file-text' },
                { title: 'Integrations', time: '59 minutes ago', user: 'JD', icon: 'file-text' },
                { title: 'How to Use Search Effectively', time: '2 hours ago', user: 'KB', icon: 'search' },
                { title: 'Getting Started Guide for Knowledge base', time: '5 hours ago', user: 'SA', icon: 'file-text' },
                { title: 'How to Setup Your Account', time: 'This Wednesday', user: 'LH', icon: 'file-text' },
                { title: 'Integrations and API Documentation', time: '23 hours ago', user: 'VM', icon: 'file-text' }
            ]">
                <div class="bg-white rounded-xl card-shadow border border-gray-100 overflow-hidden transition-all duration-300 card-hover cursor-pointer flex flex-col justify-between">

                    <!-- Card Top Section (Icon & Background) -->
                    <div class="h-24 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center border border-purple-200">
                            <!-- Icon (Document or Search-related) -->
                            <template x-if="doc.icon === 'file-text'">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m-6-6h12M9 3v18M3 9h18M3 15h18"></path>
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6" />
                                </svg>
                            </template>
                            <template x-if="doc.icon === 'search'">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 19l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </template>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-3">
                        <!-- Document Title -->
                        <p class="font-medium text-gray-800 mb-1 leading-snug h-10 overflow-hidden" x-text="doc.title"></p>

                        <!-- User and Time Footer -->
                        <div class="flex items-center text-gray-500 text-xs mt-1">
                            <!-- Placeholder for User Avatar (using CSS class) -->
                            <span class="avatar-placeholder"></span>
                            <span class="truncate uppercase" x-text="doc.user"></span>
                            <span class="mx-1">•</span>
                            <span x-text="doc.time"></span>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Create New Article Card -->
            <div
                class="border-2 border-dashed border-purple-300 bg-purple-50 rounded-xl flex items-center justify-center p-4 transition-colors duration-300 hover:bg-purple-100 hover:border-purple-400 cursor-pointer h-full min-h-[160px] hover:shadow-lg"
                @click="$dispatch('open-modal', 'modal-create')"
            >
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full border-2 border-purple-300 flex items-center justify-center mx-auto mb-2 bg-white shadow-sm">
                        <!-- Plus Icon (Lucide: Plus) -->
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-purple-600">Create article</p>
                </div>
            </div>

        </div>

        <!-- STARRED DOCUMENTS CONTENT -->
        <div x-show="activeTab === 'starred'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            class="flex flex-col items-center justify-center min-h-[300px] py-10">

            <!-- Using your provided image path -->
            <img src="{{ asset('image/starred.png') }}" onerror="this.src='https://placehold.co/160x160/F5F3FF/7C3AED?text=No+Starred+Items'" class="mx-auto w-40 h-40 mb-6" alt="No starred items icon">

            <h3 class="text-xl font-semibold text-gray-800 mb-2">No items to display</h3>
            <p class="text-gray-500 mb-6">You haven't starred any items yet.</p>

            <!-- Button -->
            <button class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2.5 px-6 rounded-lg shadow-md transition duration-150">
                Create article
            </button>
        </div>
    </div>
    <style>
        /* Custom styles for the rounded cards and subtle lift effect */
        .card-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .card-hover:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        /* Custom utility to simplify the image placeholder */
        .avatar-placeholder {
            width: 1rem;
            height: 1rem;
            border-radius: 9999px; /* full circle */
            margin-right: 0.25rem;
            background-color: #9ca3af; /* gray-400 */
            display: inline-block;
            flex-shrink: 0;
        }
</style>
<script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purple: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        },
                        gray: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            400: '#9ca3af',
                            500: '#6b7280',
                            800: '#1f2937',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</div>


