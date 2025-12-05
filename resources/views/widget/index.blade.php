@extends('layouts.app')
@section('content')

<script>
    // JavaScript function to switch between the two views
    function toggleView(viewId) {
        const listPage = document.getElementById('widgetListPage');
        const configPage = document.getElementById('widgetConfigPage');

        if (viewId === 'list') {
            listPage.classList.remove('hidden');
            configPage.classList.add('hidden');
        } else if (viewId === 'config') {
            listPage.classList.add('hidden');
            configPage.classList.remove('hidden');
        }
    }

    // Set initial view on page load (show the list)
    document.addEventListener('DOMContentLoaded', () => {
        toggleView('list');
    });
</script>

{{-- ---------------------------------------------------------------- --}}
{{-- 1. WIDGET LIST PAGE (Default View) --}}
{{-- ---------------------------------------------------------------- --}}
<div id="widgetListPage" class="p-8 bg-gray-50 min-h-screen">
    <div class="mx-auto bg-white rounded-md shadow-sm">

        <header class="flex items-center justify-between p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Knowledge base widget</h2>
            
            {{-- **ACTION: Click calls toggleView('config')** --}}
            <button onclick="toggleView('config')" 
                    class="px-4 py-2 bg-violet-500 text-white rounded-md hover:brightness-95">
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

                                    <button onclick="toggleView('config')" class="text-gray-400 hover:text-gray-700">
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

{{-- ---------------------------------------------------------------- --}}
{{-- 2. WIDGET CONFIGURATION PAGE (Hidden by default) --}}
{{-- ---------------------------------------------------------------- --}}
<div id="widgetConfigPage" class="hidden flex flex-col h-screen font-sans antialiased">
    
    <header class="flex items-center p-4 lg:p-6 bg-white border-b border-gray-200">
        <span class="text-gray-500 mr-4 text-sm">Widget name</span>
        <input type="text" 
        class="border border-gray-300 p-2 rounded-md w-150 text-sm focus:ring-[#9370DB] focus:border-[#9370DB]">
       
        
            {{-- **ACTION: Click calls toggleView('list') to go back** --}}
            <div class="flex space-x-4 ml-75" >
            
            {{-- Cancel Button (No custom margins needed, space-x handles gap) --}}
            <button onclick="toggleView('list')" class="px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-50 transition duration-150">
                Cancel
            </button>
            
            {{-- Save Button --}}
            <button class="px-4 py-2 text-sm bg-primary-purple text-white rounded-md font-medium hover:bg-purple-600 transition duration-150 shadow-md">
                Save
            </button>
        </div>
       
    </header>
    
    <main class="flex flex-1 overflow-hidden">
        
        <div class="config-panel flex-shrink-0 w-full lg:w-3/5 xl:w-2/3 bg-white border-r border-gray-200 overflow-y-auto p-6">
            
            <div class="border-b border-gray-200 mb-6 flex space-x-6 pt-2" id="widgetTabs">
    
    <button class="tab-button pb-2 text-sm font-medium border-b-2 border-[#9370DB] text-[#9370DB]" data-tab="connect">
        Configure & connect
    </button>
    
    <button class="tab-button pb-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="css">
        Custom CSS
    </button>
    
    <button class="tab-button pb-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="javascript">
        Custom JavaScript
    </button>
    
    <button class="tab-button pb-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="url">
        URL Mapping
    </button>
</div>

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
                <div class="flex justify-end items-center border border-gray-300 h-6 p-2 rounded-md cursor-pointer bg-white text-gray-700">
                    <span class="text-xs text-gray-500">▼</span>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-base font-semibold text-gray-700 mb-1">Content access</h3>
                <p class="text-xs text-gray-500 mb-3">Choose what content level end-users can access in the widget. 
                    <span class="ml-1 text-xs w-4 h-4 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold inline-flex cursor-help">i</span>
                </p>
                <div class="flex justify-end items-center border border-gray-300 h-6 p-2 rounded-md cursor-pointer bg-white text-gray-700">
                    <span class="text-xs text-gray-500">▼</span>
                </div>
            </div>

        </div>
        
        <div class="preview-panel flex-1 bg-gray-100 p-6">
            
            <div class="flex justify-end items-center mb-6 text-sm">
                <span class="text-gray-600 mr-2">Main Workspace</span>
                <select class="p-1 border border-gray-300 rounded-md text-gray-600 text-xs">
                    <option>English</option>
                </select>
            </div>
            
            <div class="max-w-sm mx-auto bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="text-xs font-semibold text-gray-500 p-2 text-center">PREVIEW</div>
                
                <div class="flex border-b border-gray-100">
                    <div class="flex flex-1">
                        <button class="flex-1 py-3 text-center text-xs font-medium text-gray-500 hover:text-gray-700">PAGE HELP</button>
                        <button class="flex-1 py-3 text-center text-xs font-medium text-[#9370DB] border-b-2 border-[#9370DB]">KNOWLEDGE BASE</button>
                    </div>
                    <div class="p-3 text-gray-400 border-l border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                
                <div class="p-4">
                    <div class="most-searched">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4">Most searched articles</h3>
                        <div class="no-data text-center py-10 px-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-xs">Not enough data to show most search articles. Check again later.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
</div>

@endsection