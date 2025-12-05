@extends('layouts.app')
@section('content')
   <div class="flex min-h-screen bg-gray-50">

    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col pt-6">
        <div class="px-4 mb-6">
            <h1 class="text-lg font-semibold text-gray-900">KNOWLEDGE BASE PORTAL</h1>
        </div>

        <nav class="flex-1 overflow-y-auto">
            <div class="mb-6">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider px-4 mb-2">General</p>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-medium transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.942 3.333.337 2.707 1.884a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.626 1.547-1.163 2.826-2.707 1.884a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.942-3.333-.337-2.707-1.884a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.626-1.547 1.163-2.826 2.707-1.884a1.724 1.724 0 002.573-1.066z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Settings</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M5 16s4.5-5 7-5 7 5 7 5"></path></svg>
                    <span>Team auditing</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Localization &amp; Workspace</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Backup &amp; Restore</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Notifications</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2v5a2 2 0 01-2 2h-5a2 2 0 01-2-2V9a2 2 0 012-2h5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21v-1a2 2 0 012-2h1a2 2 0 012 2v1"></path></svg>
                    <span>API tokens</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 10v1m-7-5h2m14 0h2M4.75 5.5l1.442 1.442M17.803 17.803l1.442 1.442M4.75 18.495l1.442-1.442M17.803 5.197l1.442-1.442M12 6.75a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5z"></path></svg>
                    <span>Billing</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span>Extensions</span>
                </a>
            </div>

            <div class="mb-6">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider px-4 mb-2 flex items-center justify-between cursor-pointer">
                    KNOWLEDGE BASE SITE
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider px-4 mb-2 flex items-center justify-between cursor-pointer">
                    USERS & SECURITY
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider px-4 mb-2 flex items-center justify-between cursor-pointer">
                    AI FEATURES
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </p>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen">
        <header class="bg-white border-b border-gray-200 h-16 flex-shrink-0 flex items-center justify-between px-6 space-x-4">
            <div class="text-2xl font-semibold text-gray-900">Project settings</div>
            <div class="flex space-x-4">
                <button class="text-gray-600 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                    Cancel
                </button>
                <button class="bg-purple-600 text-white font-medium px-6 py-2 rounded-lg shadow-md hover:bg-purple-700 transition-colors duration-150">
                    Save
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto settings-container p-10 bg-gray-50">
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 max-w-4xl mx-auto">

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Knowledge base details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <label for="project-name" class="text-sm font-medium text-gray-700 pt-2">Project name</label>
                        <div class="md:col-span-2">
                            <input id="project-name" type="text" value="Project" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-purple-600 focus:border-purple-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <label for="country" class="text-sm font-medium text-gray-700 pt-2">Country</label>
                        <div class="md:col-span-2">
                            <select id="country" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-purple-600 focus:border-purple-600 appearance-none bg-white">
                                <option value="" disabled selected>Select country</option>
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="CA">Canada</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Customize workspace label</p>
                            <p class="text-xs text-gray-500 mt-1">Set the term used to refer workspace across your knowledge base. Choose what refers to where they are by selecting workspace in the knowledge base.</p>
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" value="Workspace" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-purple-600 focus:border-purple-600">
                            <p class="text-xs text-gray-500 mt-2">To localize this term across your knowledge base, <a href="#" class="text-purple-600 hover:underline font-medium">Click here!</a></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="text-sm font-medium text-gray-700"></div>
                        <div class="md:col-span-2 flex items-center space-x-10">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="redirect" value="root" class="form-radio h-4 w-4 text-purple-600 focus:ring-purple-600">
                                <span class="text-sm text-gray-700">Redirect to root article</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="redirect" value="same" checked class="form-radio h-4 w-4 text-purple-600 focus:ring-purple-600">
                                <span class="text-sm text-gray-700">Redirect to same article</span>
                            </label>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Remember state</p>
                            <p class="text-xs text-gray-500 mt-1">Remember the last UI state when navigating between sections.</p>
                        </div>
                        <div class="md:col-span-2">
                            <button type="button" aria-checked="true" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 bg-green-500">
                                <span aria-hidden="true" class="translate-x-5 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Editor</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Choose the default editor for new articles at the project level. If an article is in Advanced WYSIWYG editor, you cannot switch it to another editor.</p>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="radio" name="editor-choice" value="markdown" class="form-radio h-4 w-4 text-purple-600 mt-1 focus:ring-purple-600">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Markdown</p>
                                    <p class="text-xs text-gray-500">An intuitive and lightweight text-to-HTML conversion tool for content writers</p>
                                </div>
                            </label>

                            <label class="block space-y-2 cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="editor-choice" value="wysiwyg" checked class="form-radio h-4 w-4 text-purple-600 mt-1 focus:ring-purple-600">
                                    <p class="text-sm font-medium text-gray-700">Advanced WYSIWYG <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full text-white bg-green-500">NEW</span></p>
                                </div>
                                <p class="text-xs text-gray-500 ml-7">Enhanced editing and formatting experience for Text, Images, Videos, etc. Supports markdown syntax, keyboard shortcuts to insert content and cleaner editor look</p>

                                <label class="flex items-center space-x-2 text-xs text-gray-700 ml-7 mt-2">
                                    <input type="checkbox" checked class="form-checkbox h-4 w-4 text-purple-600 rounded focus:ring-purple-600">
                                    <span>Show outline view in advanced WYSIWYG editor</span>
                                </label>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Documentation</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Default review reminder for published articles/category pages. Automatically create review reminders</p>
                        </div>
                        <div class="md:col-span-2">
                            <button type="button" aria-checked="false" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 bg-gray-200">
                                <span aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Drive settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Allow or restrict file formats on Drive</p>
                        </div>
                        <div class="md:col-span-2 space-y-3">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="media-format" value="all" checked class="form-radio h-4 w-4 text-purple-600 focus:ring-purple-600">
                                <span class="text-sm text-gray-700">Allow all media formats</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="media-format" value="choose" class="form-radio h-4 w-4 text-purple-600 focus:ring-purple-600">
                                <span class="text-sm text-gray-700">Choose allowed media formats</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Analytics settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Exclude certain IPs from project analytics.</p>
                        </div>
                        <div class="md:col-span-2 flex items-center space-x-3">
                            <input type="text" placeholder="Enter description" class="w-full max-w-sm p-2 border border-gray-300 rounded-lg focus:ring-purple-600 focus:border-purple-600">
                            <span class="text-sm text-gray-500 hidden sm:inline">eg: 0.0.0.0 - 255.255.255</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Support Access</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-sm text-gray-700">
                            <p class="font-medium">Grant permission to the support user to access the team account for troubleshooting, support or testing.</p>
                        </div>
                        <div class="md:col-span-2">
                            <button type="button" aria-checked="false" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 bg-gray-200">
                                <span aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Delete knowledge base</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-sm text-gray-700 md:col-span-2">
                            <p class="font-medium">To delete your project, please contact support: <a href="mailto:support@document360.com" class="text-purple-600 hover:underline">support@document360.com</a></p>
                        </div>
                        <div class="md:col-span-1 md:justify-self-end">
                            <button class="bg-red-600 text-white font-medium px-6 py-2 rounded-lg shadow-md hover:bg-red-700 transition-colors duration-150">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
