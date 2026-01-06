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
