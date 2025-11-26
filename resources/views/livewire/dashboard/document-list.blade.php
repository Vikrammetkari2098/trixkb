  <!-- Documents Section -->
               <div
                    class="bg-white rounded-xl shadow-soft p-5 md:p-6 mb-6"
                    x-data="{ activeTab: 'recent', modalOpen: false }"
                    @open-modal.window="if ($event.detail === 'modal-create') modalOpen = true"
                >
                    <!-- Header -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between sm:items-end gap-4">
                        <div class="flex items-center">
                            <h2 class="text-xl font-bold text-gray-800 mr-4">Documents</h2>
                            <button class="text-blue-600 text-sm font-medium hover:underline">View all</button>
                        </div>

                        <div class="relative w-full sm:max-w-sm">
                            <input type="text" placeholder="Search articles"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
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
                    <div x-show="activeTab === 'recent'"
                        x-transition
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">

                        <!-- Document Card 1 -->
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover-lift cursor-pointer">
                            <div class="h-20 bg-green-50 border-b border-gray-100 flex items-center justify-center p-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center border border-green-200">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.275a1.8 1.8 0 010 2.55L14.55 12.5a2 2 0 01-2.83 0L7.432 8.35a1.8 1.8 0 010-2.55 1.8 1.8 0 012.55 0L12 8.62l2.018-2.825a1.8 1.8 0 012.55 0z"></path>
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

                        <!-- Dummy Cards (same pattern) -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover-lift cursor-pointer">
                            <div class="h-20 bg-yellow-50 border-b border-gray-100 flex items-center justify-center p-4">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center border border-yellow-200">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.46 9.58 5 8 5c-4 0-4.5 4-4.5 4s-.5 4 4.5 4c1.58 0 2.832-.46 4-.853m0-13c1.168.79 2.42 1.253 4 1.253 4 0 4.5-4 4.5-4s.5-4-4.5-4c-1.58 0-2.832.46-4 .853m-12 11c0 3.993 4.967 7.005 8 7.005s8-3.012 8-7.005M4 14c.732.228 1.517.345 2.333.345C8.423 14.345 12 14 12 14"></path>
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

                        <!-- Create New Article Card -->
                        <div
                            class="border-2 border-dashed border-blue-300 bg-blue-50 rounded-xl flex items-center justify-center p-4 transition-colors duration-300 hover:bg-blue-100 hover:border-blue-400 cursor-pointer h-full min-h-[120px] hover-lift"
                            @click="$dispatch('open-modal', 'modal-create')"
                        >
                            <div class="text-center">
                                <div class="w-10 h-10 rounded-full border-2 border-blue-300 flex items-center justify-center mx-auto mb-2 bg-white">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-blue-600">Create article</p>
                            </div>
                        </div>

                    </div>

                    <!-- STARRED -->
                    <div x-show="activeTab === 'starred'" x-transition
                        class="flex flex-col items-center justify-center min-h-[300px] py-10">
                        <img src="{{ asset('image/starred.png') }}" class="mx-auto w-40 h-40 mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No items to display</h3>
                        <p class="text-gray-500 mb-6">You haven't starred any items yet.</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg shadow-md">
                            Create article
                        </button>
                    </div>
