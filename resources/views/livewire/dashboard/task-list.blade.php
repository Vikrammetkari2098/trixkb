<div class="bg-white rounded-xl p-5 md:p-6 mb-6" x-data="{}">
    <div>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 flex items-center mb-4 sm:mb-0">
                Tasks
                <button class="text-blue-600 text-sm font-medium hover:underline ml-3">
                    View all
                </button>
            </h1>
            <!-- Badge Counters (Top Right) -->
            <div class="flex flex-wrap justify-start sm:justify-end items-center gap-2 text-xs font-semibold">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-neutral-soft-text" style="background-color: rgba(107, 114, 128, 0.1);">This week <span class="ml-1 px-1 bg-gray-900 text-white rounded-full font-bold">10</span></span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-neutral-soft-text" style="background-color: rgba(107, 114, 128, 0.1);">Today <span class="ml-1 px-1 bg-gray-900 text-white rounded-full font-bold">5</span></span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-error-soft-text" style="background-color: rgba(235, 100, 100, 0.1);">Overdue <span class="ml-1 px-1 bg-gray-900 text-white rounded-full font-bold">5</span></span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-neutral-soft-text" style="background-color: rgba(107, 114, 128, 0.1);">Snoozed <span class="ml-1 px-1 bg-gray-900 text-white rounded-full font-bold">3</span></span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">

            <!-- Filter Bar -->
            <div class="p-4 md:p-6 flex flex-col lg:flex-row items-start lg:items-center gap-3 border-b border-gray-100">
               <div class="p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-4 border-b border-gray-100">

                    <div class="relative inline-flex">
                        <button type="button"
                            class="flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Assigned to me
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </button>
                    </div>
                    <div x-data="{ activeTab: 'workflow' }" class="inline-flex rounded-lg overflow-hidden border border-purple-400">
                        <button
                            @click="activeTab = 'workflow'"
                            :class="{
                                'bg-purple-100 text-purple-700': activeTab === 'workflow',
                                'bg-white text-purple-600 hover:bg-purple-50': activeTab !== 'workflow'
                            }"
                            class="px-4 py-2 text-sm font-medium border-r border-purple-300 transition duration-150">
                            Workflow
                        </button>
                        <button
                            @click="activeTab = 'feedback'"
                            :class="{
                                'bg-purple-100 text-purple-700': activeTab === 'feedback',
                                'bg-white text-purple-600 hover:bg-purple-50': activeTab !== 'feedback'
                            }"
                            class="px-4 py-2 text-sm font-medium border-r border-purple-300 transition duration-150">
                            Feedback
                        </button>
                        <button
                            @click="activeTab = 'review'"
                            :class="{
                                'bg-purple-100 text-purple-700': activeTab === 'review',
                                'bg-white text-purple-600 hover:bg-purple-50': activeTab !== 'review'
                            }"
                            class="px-4 py-2 text-sm font-medium transition duration-150">
                            Review reminder
                        </button>
                    </div>

                    <div class="relative w-full md:w-64">
                        <input type="text"
                            placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                </div>

                    <!-- Search and Filter -->
                    <div class="relative w-full lg:w-64 ml-auto">
                        <input type="text"
                            placeholder="Search..."
                            class="pl-10 pr-10 py-2 w-full rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition duration-150 text-sm">

                        <!-- Search Icon -->
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>

                        <!-- Filter Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="absolute right-3 top-1/2 -translate-y-1/2 
                                text-gray-400 w-5 h-5 cursor-pointer 
                                hover:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                    </div>
                </div>

                <!-- Task Table - Custom table CSS converted to inline Tailwind utilities -->
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">Title</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">Category</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">Due Date</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700">Assigned To</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.62-.921 1.92 0l1.24 3.818 4.01-.582c.996-.144 1.396 1.253.682 1.93l-2.903 2.835.686 4.01c.17.994-.871 1.765-1.789 1.25L10 15.187l-3.593 1.896c-.918.515-1.959-.256-1.789-1.25l.686-4.01L3.197 8.093c-.714-.677-.314-2.074.682-1.93l4.01.582 1.24-3.818z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">Troubleshooting Common Issues</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Workflow</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-sm font-medium text-gray-600">Draft</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 11 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-yellow-500 text-white justify-center text-sm">J</div>
                                    John Smith
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">Integrations and API Documentation</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Workflow</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-sm font-medium text-gray-600">Draft</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 8 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-indigo-500 text-white justify-center text-sm">M</div>
                                    Mark James
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">How to Use Search Effectively</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Feedback</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <span class="text-sm font-medium text-yellow-600 bg-yellow-50 p-1 rounded-md">Needs review</span>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 6 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-yellow-500 text-white justify-center text-sm">J</div>
                                    John Smith
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.3 16a2 2 0 001.732 3z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">Getting Started Guide</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Review reminder</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-600 bg-gray-100 p-1 rounded-md">Planned</span>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 6 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-indigo-500 text-white justify-center text-sm">M</div>
                                    Mark James
                                </td>
                            </tr>

                            <!-- Row 5 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">How to Set Up Your Account</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Workflow</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <span class="text-sm font-medium text-indigo-600 bg-indigo-50 p-1 rounded-md">L1 Review</span>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 6 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-indigo-500 text-white justify-center text-sm">M</div>
                                    Mark James
                                </td>
                            </tr>

                            <!-- Row 6 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">Feature Overview</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Feedback</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-600 bg-gray-100 p-1 rounded-md">Planned</span>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 6 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-yellow-500 text-white justify-center text-sm">J</div>
                                    John Smith
                                </td>
                            </tr>

                            <!-- Row 7 -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-normal">
                                    <div class="flex items-center gap-1">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.3 16a2 2 0 001.732 3z"/>
                                        </svg>
                                        <span class="font-medium text-gray-800 text-sm">Product Updates and Release Notes</span>
                                    </div>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">Review reminder</td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <span class="text-sm font-medium text-yellow-600 bg-yellow-50 p-1 rounded-md">Needs review</span>
                                </td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap"><span class="text-rose-500 font-medium">Overdue by 6 days</span></td>
                                <td class="p-2 md:p-3 border-b border-gray-100 whitespace-nowrap">
                                    <div class="inline-flex items-center w-7 h-7 rounded-full bg-red-500 text-white justify-center text-sm">S</div>
                                    Sarah Miller
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
        // Customizing the Tailwind theme to include specific colors used in the design
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Custom purple shades for tabs and dropdown
                        'soft-purple-bg': '#f3f0ff',
                        'soft-purple-border': '#c9c3ff',
                        'active-purple-bg': '#e5e0ff',
                        'deep-purple-text': '#5544d9',
                        // Custom colors for 'soft' badges (using arbitrary values for background colors)
                        'error-soft-text': 'hsl(350, 78%, 65%)',
                        'neutral-soft-text': '#6b7280',
                    }
                }
            }
        }
    </script>
</div>


