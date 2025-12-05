


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
    
                { title: 'Integrations and API Documentation', avatarId: 'avatar-6.png', time: '1 hour ago', user: 'VM', icon: 'clipboard' },
                { title: 'Integrations', avatarId: 'avatar-7.png', time: '59 minutes ago', user: 'JD', icon: 'clipboard' },
                { title: 'How to Use Search Effectively', avatarId: 'avatar-1.png', time: '2 hours ago', user: 'KB', icon: 'folder' },
                { title: 'Getting Started Guide for Knowledge base', avatarId: 'avatar-10.png', time: '5 hours ago', user: 'SA', icon: 'book' },
                { title: 'How to Setup Your Account', avatarId: 'avatar-12.png', time: 'This Wednesday', user: 'LH', icon: 'settings' },
                { title: 'Integrations and API Documentation', avatarId: 'avatar-15.png', time: '23 hours ago', user: 'VM', icon: 'chip' }
            ]">
                <div class="bg-white rounded-xl card-shadow border border-gray-100 overflow-hidden transition-all duration-300 card-hover cursor-pointer flex flex-col justify-between">

                    <div class="h-24 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center border border-purple-200">
                            <template x-if="doc.icon === 'clipboard'">
                                <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                    <path d="M8 5.00005C7.01165 5.00082 6.49359 5.01338 6.09202 5.21799C5.71569 5.40973 5.40973 5.71569 5.21799 6.09202C5 6.51984 5 7.07989 5 8.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V8.2C19 7.07989 19 6.51984 18.782 6.09202C18.5903 5.71569 18.2843 5.40973 17.908 5.21799C17.5064 5.01338 16.9884 5.00082 16 5.00005M8 5.00005V7H16V5.00005M8 5.00005V4.70711C8 4.25435 8.17986 3.82014 8.5 3.5C8.82014 3.17986 9.25435 3 9.70711 3H14.2929C14.7456 3 15.1799 3.17986 15.5 3.5C15.8201 3.82014 16 4.25435 16 4.70711V5.00005M12 15H9M15 11H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </template>

                            <template x-if="doc.icon === 'folder'">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </template>

                            <template x-if="doc.icon === 'magnifying-glass'">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </template>
                            
                            <template x-if="doc.icon === 'book'">
                                <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                    <path d="M8 5.00005C7.01165 5.00082 6.49359 5.01338 6.09202 5.21799C5.71569 5.40973 5.40973 5.71569 5.21799 6.09202C5 6.51984 5 7.07989 5 8.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V8.2C19 7.07989 19 6.51984 18.782 6.09202C18.5903 5.71569 18.2843 5.40973 17.908 5.21799C17.5064 5.01338 16.9884 5.00082 16 5.00005M8 5.00005V7H16V5.00005M8 5.00005V4.70711C8 4.25435 8.17986 3.82014 8.5 3.5C8.82014 3.17986 9.25435 3 9.70711 3H14.2929C14.7456 3 15.1799 3.17986 15.5 3.5C15.8201 3.82014 16 4.25435 16 4.70711V5.00005M12 15H9M15 11H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </template>

                            <template x-if="doc.icon === 'settings'">
                                <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                    <path d="M8 5.00005C7.01165 5.00082 6.49359 5.01338 6.09202 5.21799C5.71569 5.40973 5.40973 5.71569 5.21799 6.09202C5 6.51984 5 7.07989 5 8.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V8.2C19 7.07989 19 6.51984 18.782 6.09202C18.5903 5.71569 18.2843 5.40973 17.908 5.21799C17.5064 5.01338 16.9884 5.00082 16 5.00005M8 5.00005V7H16V5.00005M8 5.00005V4.70711C8 4.25435 8.17986 3.82014 8.5 3.5C8.82014 3.17986 9.25435 3 9.70711 3H14.2929C14.7456 3 15.1799 3.17986 15.5 3.5C15.8201 3.82014 16 4.25435 16 4.70711V5.00005M12 15H9M15 11H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </template>

                            <template x-if="doc.icon === 'chip'">
                                <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                                    <path d="M8 5.00005C7.01165 5.00082 6.49359 5.01338 6.09202 5.21799C5.71569 5.40973 5.40973 5.71569 5.21799 6.09202C5 6.51984 5 7.07989 5 8.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V8.2C19 7.07989 19 6.51984 18.782 6.09202C18.5903 5.71569 18.2843 5.40973 17.908 5.21799C17.5064 5.01338 16.9884 5.00082 16 5.00005M8 5.00005V7H16V5.00005M8 5.00005V4.70711C8 4.25435 8.17986 3.82014 8.5 3.5C8.82014 3.17986 9.25435 3 9.70711 3H14.2929C14.7456 3 15.1799 3.17986 15.5 3.5C15.8201 3.82014 16 4.25435 16 4.70711V5.00005M12 15H9M15 11H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </template>

                        </div>
                    </div>

                    <div class="p-3">
                        <p class="font-medium text-gray-800 mb-1 leading-snug h-10 overflow-hidden" x-text="doc.title"></p>

                        <div class="flex items-center text-gray-500 text-xs mt-1">
                            <div class="w-10 h-10 rounded-full mr-2 flex-shrink-0 overflow-hidden avatar"> 
                                <img x-bind:src="'https://cdn.flyonui.com/fy-assets/avatar/' + doc.avatarId" 
                                    :alt="doc.user + ' Avatar'" 
                                    class="w-full h-full object-cover"/> 
                            </div>
                            
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


