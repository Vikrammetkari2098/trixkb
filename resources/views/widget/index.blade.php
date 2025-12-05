@extends('layouts.app')
@section('content')

<div class="bg-white">
    <div x-data="{ currentView: 'list', currentConfigTab: 'connect' }">

        <div id="widgetListPage" x-show="currentView === 'list'" class="p-8 bg-white min-h-screen">
            <div class="mx-auto bg-white rounded-md shadow-sm">
                <header class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Knowledge base widget</h2>
                    <button @click="currentView = 'config'" class="px-4 py-2 bg-violet-500 text-white rounded-md hover:brightness-95">
                        Add widget
                    </button>
                </header>

                <div class="p-4">
                    <div class="mb-4">
                        <input type="text" placeholder="Search widgets"
                               class="w-full border rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-violet-200" />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Widget Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content access</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JWT</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last updated</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @for ($i = 1; $i <= 2; $i++)
                                <tr class="hover:bg-gray-50 group">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Knowledge base widget {{ $i }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">Project</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">Disabled</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">This Tuesday</td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <button class="text-blue-500 hover:text-blue-700 p-1 rounded-md">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                                                </svg>
                                            </button>

                                            <button @click="currentView = 'config'" class="text-gray-400 hover:text-gray-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </button>

                                            <button class="text-purple-500 hover:text-purple-700">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 1h11a2 2 0 0 1 2 2v13h-2V3H8V1zM5 5h11a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2zm11 15V7H5v13h11z"/>
                                                </svg>
                                            </button>

                                            <button class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="widgetConfigPage" x-show="currentView === 'config'" class="flex flex-col h-screen font-sans antialiased">
            <header class="flex items-center p-4 lg:p-6 bg-white border-b border-gray-200">
                <span class="text-gray-500 mr-4 text-sm">Widget name</span>
                <input type="text" class="border border-gray-300 p-2 rounded-md w-150 text-sm focus:ring-[#9370DB] focus:border-[#9370DB]">

                <div class="flex space-x-4 ml-75">
                    <button @click="currentView = 'list'" class="px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-50 transition duration-150">
                        Cancel
                    </button>
                    <button @click="alert('Save clicked!')" class="px-4 py-2 bg-[#9370DB] text-white rounded-md font-medium hover:bg-purple-600 transition duration-150">
                        Save
                    </button>
                </div>
            </header>

            <main class="flex flex-1 overflow-hidden">
                <div class="config-panel flex-shrink-0 w-full lg:w-3/5 xl:w-2/3 bg-white border-r border-gray-200 overflow-y-auto p-6">
                    <div class="border-b border-gray-200 mb-6 flex space-x-6 pt-2" id="widgetTabs">
                        <button @click="currentConfigTab = 'connect'"
                                :class="currentConfigTab === 'connect' ? 'border-[#9370DB] text-[#9370DB]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="tab-button pb-2 text-sm font-medium border-b-2">Configure & Connect</button>
                        <button @click="currentConfigTab = 'css'"
                                :class="currentConfigTab === 'css' ? 'border-[#9370DB] text-[#9370DB]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="tab-button pb-2 text-sm font-medium border-b-2">Custom CSS</button>
                        <button @click="currentConfigTab = 'javascript'"
                                :class="currentConfigTab === 'javascript' ? 'border-[#9370DB] text-[#9370DB]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="tab-button pb-2 text-sm font-medium border-b-2">Custom JavaScript</button>
                        <button @click="currentConfigTab = 'url'"
                                :class="currentConfigTab === 'url' ? 'border-[#9370DB] text-[#9370DB]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="tab-button pb-2 text-sm font-medium border-b-2">URL Mapping</button>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" x-show="currentConfigTab === 'connect'">
                            <div class="mb-8 pb-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-700 mb-1">Connection</h3>
                                <p class="text-sm text-status-red">This widget isn't connected to any webpages yet.</p>
                            </div>

                            <div class="mb-8 pb-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-700 mb-1">Widget JavaScript</h3>
                                <p class="text-xs text-gray-500 mb-3">Inserts custom JavaScript before the <code class="text-xs">&lt;body&gt;</code> tag of the added page.</p>
                                <div class="flex justify-between items-center border border-gray-300 p-3 rounded-md cursor-pointer bg-white text-gray-700">
                                    <span class="text-sm">Connected domains</span>
                                    <span class="text-xs text-gray-500">▼</span>
                                </div>
                            </div>

                            <div class="mb-8 pb-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-700 mb-1">JWT</h3>
                                <p class="text-xs text-gray-500 mb-3">Configure JWT for your widget.</p>
                                <div class="flex justify-between items-center border border-gray-300 p-3 rounded-md cursor-pointer bg-white text-gray-700">
                                    <span class="text-sm">Configure JWT</span>
                                    <span class="text-xs text-gray-500">▼</span>
                                </div>
                            </div>

                            <div class="mb-8 pb-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-700 mb-4">Customize the experience</h3>
                                <div class="flex items-center space-x-6 text-sm">
                                    <span class="font-medium">Select type</span>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="select-type" checked class="text-[#9370DB] focus:ring-[#9370DB]">
                                        <span class="ml-1 text-gray-700">Widget</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="select-type" class="text-[#9370DB] focus:ring-[#9370DB]">
                                        <span class="ml-1 text-gray-700">Chatbot</span>
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-100 text-[#9370DB] font-medium rounded-sm">BETA</span>
                                        <span class="ml-1 text-xs w-4 h-4 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold cursor-help">i</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-8 pb-4 border-b border-gray-100 relative">
                                <h3 class="text-base font-semibold text-gray-700 mb-1">AI Assistive search</h3>
                                <p class="text-xs text-gray-500 mb-3 w-5/6">You have not enabled AI assistive search for KB widgets in the AI settings page.</p>
                                <label class="absolute right-0 top-6 inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#9370DB]"></div>
                                </label>
                            </div>

                            <div class="mb-8 pb-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-700 mb-1">Style widget</h3>
                                <p class="text-xs text-gray-500 mb-3">Customize widget styles and themes</p>

                                <div class="flex justify-between items-center border border-gray-300 p-3 rounded-md cursor-pointer bg-white text-gray-700">
                                    <span class="text-xs text-gray-500">Style options</span>
                                    <span class="text-xs text-gray-500">▼</span>
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-base font-semibold text-gray-700 mb-1">Content access</h3>
                                <p class="text-xs text-gray-500 mb-3">
                                    Choose what content level end-users can access in the widget.
                                    <span class="ml-1 text-xs w-4 h-4 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold inline-flex cursor-help">i</span>
                                </p>

                                <div class="flex justify-between items-center border border-gray-300 p-3 rounded-md cursor-pointer bg-white text-gray-700">
                                    <span class="text-xs text-gray-500">Select access</span>
                                    <span class="text-xs text-gray-500">▼</span>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" x-show="currentConfigTab === 'css'">
    <div class="w-full mt-8">

        <p class="text-gray-600 mb-3">
            Custom CSS added here will only be applied to the widget
        </p>

        <div class="border border-gray-300 rounded-md overflow-hidden">

            <div class="flex">
                <div class="w-12 bg-gray-50 text-gray-400 text-sm py-2 px-3 border-r border-gray-300">
                    1
                </div>

                <textarea
                    class="w-full h-[300px] p-4 text-gray-800 text-sm focus:outline-none resize-none"

                ></textarea>
            </div>

        </div>

        <div class="text-right text-gray-400 text-sm mt-2">
            Shift + Tab to format
        </div>

    </div>
</div>


                        <div class="tab-pane" x-show="currentConfigTab === 'javascript'">
    <div class="w-full mt-8">

        <p class="text-gray-600 mb-3">
            Custom JavaScript added here will only be applied to the widget
        </p>

        <div class="border border-gray-300 rounded-md overflow-hidden">

            <div class="flex">
                <div class="w-12 bg-gray-50 text-gray-400 text-sm py-2 px-3 border-r border-gray-300">
                    1
                </div>

                <textarea
                    class="w-full h-[300px] p-4 text-gray-800 text-sm focus:outline-none resize-none font-mono"

                ></textarea>
            </div>

        </div>

        <div class="text-right text-gray-400 text-sm mt-2">
            Shift + Tab to format
        </div>

    </div>
</div>


                        <div class="tab-pane" x-show="currentConfigTab === 'url'">
    <div class="w-full mt-8 flex flex-col items-center justify-center">
        <div class="illustration-area mb-8 w-full max-w-sm">
            <img src="{{ asset('image/widget.png') }}"
                 alt="No URL mapping added illustration"
                 class="w-full h-auto object-contain mx-auto">
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 mb-3 text-center">
            No URL mapping added
        </h2>

        <p class="text-base text-gray-500 mb-8 max-w-xs text-center">
            URL mapping lets you show specific articles, or hide the widget, on specific URLs.
        </p>

        <div>
            <button class="bg-purple-600 text-white font-medium py-3 px-6 rounded-lg hover:bg-purple-700 transition">
                New URL mapping
            </button>
        </div>
    </div>
</div>

                    </div>
                </div>

                <div class="flex h-150 bg-white-100" x-data="{ currentPreviewTab: 'page-help' }">
                    <div class="w-16 flex items-center justify-center bg-white">
                        <span class="transform -rotate-90 text-sm font-semibold text-gray-700 uppercase tracking-widest">PREVIEW</span>
                    </div>
                    <div class="flex-1 p-6 max-w-lg bg-white shadow-xl">
                        <div class="flex justify-end space-x-4 mb-6">
                            <div class="relative inline-block text-left">
                                <button class="inline-flex justify-center items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Main Workspace
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative inline-block text-left">
                                <button class="inline-flex justify-center items-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    English
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="tab-controls" class="flex border-b border-gray-200 mb-6">
                            <button @click="currentPreviewTab = 'page-help'"
                                        :class="currentPreviewTab === 'page-help' ? 'text-indigo-600 border-indigo-600 border-b-2' : 'text-gray-500 hover:text-gray-700'"
                                        class="tab-btn px-4 py-2 text-sm font-semibold">PAGE HELP</button>
                            <button @click="currentPreviewTab = 'knowledge-base'"
                                        :class="currentPreviewTab === 'knowledge-base' ? 'text-indigo-600 border-indigo-600 border-b-2' : 'text-gray-500 hover:text-gray-700'"
                                        class="tab-btn px-4 py-2 text-sm font-semibold">KNOWLEDGE BASE</button>
                        </div>

                        <div class="relative mb-8">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" placeholder="Search..." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div x-show="currentPreviewTab === 'page-help'">
                            <p class="text-lg font-semibold text-gray-800 mb-10 text-left">Most searched articles</p>
                            <div class="flex justify-center mb-4">
                                <svg class="h-20 w-20 text-gray-300 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    <circle cx="10" cy="9" r="0.5" fill="currentColor" />
                                    <circle cx="14" cy="9" r="0.5" fill="currentColor" />
                                    <path d="M9 13c.83 1 2.17 1 3 0" stroke="currentColor" stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="text-gray-500 text-center">Not enough data to show articles specific to this page. Check again later.</p>
                        </div>

                        <div x-show="currentPreviewTab === 'knowledge-base'">
                            <p class="text-lg font-semibold text-gray-800 mb-10 text-left">Most searched articles</p>
                            <div class="flex justify-center mb-4">
                                <svg class="h-20 w-20 text-gray-300 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    <circle cx="10" cy="9" r="0.5" fill="currentColor" />
                                    <circle cx="14" cy="9" r="0.5" fill="currentColor" />
                                    <path d="M9 13c.83 1 2.17 1 3 0" stroke="currentColor" stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="text-gray-500 text-center">Not enough data to show most searched articles. Check again later.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
</div>

@endsection
