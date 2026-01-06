@extends('layouts.app')
@section('content')
    <div x-data="settingsApp()" class="flex min-h-screen bg-gray-50" x-init="init()">
        <aside class="w-72 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col p-0 rounded-r-lg shadow-xl">
            <!-- Search Bar -->
            <div class="p-4 border-b border-gray-100">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Search" class="w-full pl-10 pr-4 py-2 text-sm text-gray-700 placeholder-gray-400 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150">
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto bg-gray-50 custom-scroll pt-2">
                <!-- KNOWLEDGE BASE PORTAL -->
                <div class="mb-4">
                    <p @click="toggleSection('portal')" class="text-sm font-semibold text-gray-500 uppercase tracking-wider px-4 py-2 mb-1 flex items-center justify-between cursor-pointer hover:bg-gray-50 rounded-lg mx-2">
                        KNOWLEDGE BASE PORTAL
                        <svg :class="{'rotate-0': sections.portal, 'rotate-90': !sections.portal}" class="w-4 h-4 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </p>

                    <div x-show="sections.portal" x-collapse class="space-y-1">
                        <!-- General (Active Link) -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 rounded-lg bg-primary-50 text-primary-600 border-l-4 border-primary-500 text-sm font-medium transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18l-.78.39c-.98.49-2.22-.05-2.61-1.02a2 2 0 0 0-2.31-1.91l-.26 2.05a2 2 0 0 1-.58 1.42l-1.37 1.37a2 2 0 0 0 0 2.82l1.37 1.37a2 2 0 0 1 .58 1.42l-.26 2.05a2 2 0 0 0 2.31 1.91l.78-.39c.98-.49 2.22.05 2.61 1.02a2 2 0 0 0 2.31 1.91l.26-2.05a2 2 0 0 1 .58-1.42l1.37-1.37a2 2 0 0 0 0-2.82l-1.37-1.37a2 2 0 0 1-.58-1.42l.26-2.05a2 2 0 0 0-2.31-1.91l-.78.39a2 2 0 0 1-1.41-.92L12 4.01V4a2 2 0 0 0-2-2z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <span>General</span>
                        </a>

                        <!-- Team auditing -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            <span>Team auditing</span>
                        </a>

                        <!-- Localization & Workspace -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                                <path d="M2 12h20"/>
                            </svg>
                            <span>Localization &amp; Workspace</span>
                        </a>

                        <!-- Backup & Restore -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/>
                                <path d="M12 12v9"/>
                                <path d="m8 17 4 4 4-4"/>
                            </svg>
                            <span>Backup &amp; Restore</span>
                        </a>

                        <!-- Notifications -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                            </svg>
                            <span>Notifications</span>
                        </a>

                        <!-- API tokens -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <path d="M15 4V2"/>
                                <path d="M15 22V20"/>
                                <path d="M5.5 17.5l-1.25 1.25"/>
                                <path d="M19.8 6.2l1.25-1.25"/>
                                <path d="M6.75 16.75l-1.25 1.25"/>
                                <path d="M19.25 5.75l1.25-1.25"/>
                                <circle cx="12" cy="12" r="3"/>
                                <path d="m14 15 6 6"/>
                                <path d="m4 4 6 6"/>
                            </svg>
                            <span>API tokens</span>
                        </a>

                        <!-- Billing -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <line x1="12" x2="12" y1="2" y2="22"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                            <span>Billing</span>
                        </a>

                        <!-- Extensions -->
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 ml-3 mr-1">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <path d="M8 12h8"/>
                                <path d="M12 8v8"/>
                            </svg>
                            <span>Extensions</span>
                        </a>
                    </div>
                </div>

                <div class="border-t border-gray-100 mx-4 mt-4 mb-2"></div>

                <div class="mb-2">
                    <p @click="toggleSection('site')" class="text-sm font-semibold text-gray-500 uppercase tracking-wider px-4 py-2 mb-1 flex items-center justify-between cursor-pointer hover:bg-gray-50 rounded-lg mx-2">
                        KNOWLEDGE BASE SITE
                        <svg :class="{'rotate-0': sections.site, 'rotate-90': !sections.site}" class="w-4 h-4 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </p>
                    <div x-show="sections.site" x-collapse>
                        <a href="#" @click.prevent="siteBuilderState = 'customize-site'" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-0.75-3M3 17h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </span>
                            <span>Customize site</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 017.5 11c-2.345 0-4.721.429-6 1.25M12 18.5A18.022 18.022 0 0116.5 15c2.345 0 4.721.429 6 1.25"></path></svg>
                            </span>
                            <span>Custom domain</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                            </span>
                            <span>Article redirect rules</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.42 9.61 5 8.362 5c-4.636 0-8.257 4.02-7.519 8.653A18.062 18.062 0 0012 21.018m0-13l7.487-3.743C21.614 4.542 22 5.013 22 5.517v12.969c0 .504-.386.975-.86.994l-7.487-3.743"></path></svg>
                            </span>
                            <span>Article settings & SEO</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0v4m-5 4h2m-2 4h2M12 4a9 9 0 019 9v2M3 13v2m6 0h2v4h4v-4h2v4h4"></path></svg>
                            </span>
                            <span>Integrations</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <span>Cookie consent</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <span>Smart bars</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <span>Read receipt</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <span class="ml-3 mr-1 w-5 h-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19c-1.6 1.8-3.9 1.8-5.5 0-1.6-1.8-1.6-4.9 0-6.7 1.6-1.8 3.9-1.8 5.5 0M15 19c-1.6 1.8-3.9 1.8-5.5 0-1.6-1.8-1.6-4.9 0-6.7 1.6-1.8 3.9-1.8 5.5 0"></path></svg>
                            </span>
                            <span>Ticket deflectors</span>
                        </a>
                    </div>
                </div>

               <div class="mb-2">
                    <p @click="toggleSection('users')" class="text-sm font-semibold text-gray-500 uppercase tracking-wider px-4 py-2 mb-1 flex items-center justify-between cursor-pointer hover:bg-gray-50 rounded-lg mx-2">
                        USERS & SECURITY
                        <svg :class="{'rotate-0': sections.users, 'rotate-90': !sections.users}" class="w-4 h-4 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </p>
                    <div x-show="sections.users" x-collapse>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.653-.13-1.272-.363-1.832M17 20L12 15m0-12a4 4 0 11-8 0 4 4 0 018 0zm-8 0a4 4 0 00-4 4v2a2 2 0 002 2h8a2 2 0 002-2v-2a4 4 0 00-4-4zM12 15a4 4 0 100-8 4 4 0 000 8zm-8 4v2a2 2 0 002 2h4a2 2 0 002-2v-2a4 4 0 00-4-4h-4a4 4 0 00-4 4z"></path></svg>
                            <span>Team accounts & groups</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            <span>Content access</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.525.32 1.08.572 1.666.75A6.002 6.002 0 0110.325 4.317z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Roles & permissions</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.5A.5.5 0 0011.5 6h-7A.5.5 0 004 6.5v12a.5.5 0 00.5.5h15a.5.5 0 00.5-.5v-12a.5.5 0 00-.5-.5h-7A.5.5 0 0012 6.5zM12 6.5c0-.653.13-1.272.363-1.832M12 6.5v12m0-12a4 4 0 11-8 0 4 4 0 018 0zm-8 0a4 4 0 00-4 4v2a2 2 0 002 2h8a2 2 0 002-2v-2a4 4 0 00-4-4zM12 15a4 4 0 100-8 4 4 0 000 8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M8 14h.01M16 10h.01M16 14h.01M12 10h.01M12 14h.01M16 18h.01M8 18h.01M12 18h.01"></path></svg>
                            <span>Readers & groups</span>
                        </a>

                        <a href="#" class="flex items-center justify-between space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <div class="flex items-center space-x-3">
                                <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                <span>Site access</span>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">PRIVATE</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v10a.5.5 0 00.5.5h10a.5.5 0 00.5-.5V13a2 2 0 012-2h1.945M2 7V4a2 2 0 012-2h16a2 2 0 012 2v3m-7 1h-2m0 0H9m2 0V7m-2 2v2m4-2v2"></path></svg>
                            <span>IP restriction</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002.944 12c.001 2.825.86 5.568 2.446 7.848.74.88 1.63 1.674 2.662 2.378A12.001 12.001 0 0012 22.056c2.825-.001 5.568-.86 7.848-2.446.88-.74 1.674-1.63 2.378-2.662A12.001 12.001 0 0021.056 12c0-2.825-.86-5.568-2.446-7.848z"></path></svg>
                            <span>Security</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7l-5.46-5.46a1 1 0 00-1.414 0L7 4m0 16a2 2 0 002 2h6a2 2 0 002-2V7H7v13z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4h10m-3-2a2 2 0 00-2-2H9a2 2 0 00-2 2m10 4h-4m0 4h-4m0 4h-4"></path></svg>
                            <span>SAML / OpenID</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6a3 3 0 100 6 3 3 0 000-6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c-1.898 3.2-4.8 5.4-8 6.5C9.8 17.4 6.898 15.2 5 12c1.898-3.2 4.8-5.4 8-6.5C14.2 6.6 17.102 8.8 19 12z"></path></svg>
                            <span>JWT</span>
                        </a>
                    </div>
                </div>

                <div class="mb-6">
                    <p @click="toggleSection('ai')" class="text-sm font-semibold text-gray-500 uppercase tracking-wider px-4 py-2 mb-1 flex items-center justify-between cursor-pointer hover:bg-gray-50 rounded-lg mx-2">
                        AI FEATURES
                        <svg :class="{'rotate-0': sections.ai, 'rotate-90': !sections.ai}" class="w-4 h-4 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </p>
                    <div x-show="sections.ai" x-collapse>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 2.286a1 1 0 01.114.339l.714 2.143a1 1 0 00.95.748h2.094a1 1 0 01.95.748l.714 2.143a1 1 0 00.114.339L19 20M13 3l-2.286 2.286a1 1 0 00-.114.339L9.886 7.77a1 1 0 01-.95.748H6.842a1 1 0 00-.95.748l-.714 2.143a1 1 0 00-.114.339L3 20"></path></svg>
                            <span>Eddy AI</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572 1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Customization</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            <span>Style guide</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 mx-2 pr-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm transition-colors duration-150">
                            <svg class="ml-3 mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17v-4m0 0l2 2 2-2m-2 2V9m5 4l-2-2m2 2l2-2m-2 2v4m5-13h-2a2 2 0 00-2 2v4a2 2 0 002 2h2a2 2 0 002-2v-4a2 2 0 00-2-2zM8 8H6a2 2 0 00-2 2v4a2 2 0 002 2h2a2 2 0 002-2v-4a2 2 0 00-2-2z"></path></svg>
                            <span>Manage sources</span>
                        </a>

                        </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 h-16 flex-shrink-0 flex items-center justify-between px-6 space-x-4">
                <div class="text-2xl font-semibold text-gray-900">Project settings</div>
                <div class="flex space-x-4">
                    <button @click="cancel()" class="text-gray-600 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                        Cancel
                    </button>
                    <button @click="save()" class="bg-primary-600 text-white font-medium px-6 py-2 rounded-lg shadow-md hover:bg-primary-700 transition-colors duration-150">
                        Save
                    </button>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="bg-white p-8 shadow-lg border border-gray-200  w-full">
                    <!-- Knowledge Base Details -->
                    <div class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Knowledge base details</h3>

                        <div class="space-y-6">
                            <!-- Project Name -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <label for="project-name" class="text-sm font-medium text-gray-700 pt-2">Project name</label>
                                <div class="md:col-span-2">
                                    <input x-model="settings.projectName" id="project-name" type="text" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150">
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <label for="country" class="text-sm font-medium text-gray-700 pt-2">Country</label>
                                <div class="md:col-span-2">
                                    <select x-model="settings.country" id="country" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white">
                                        <option value="" disabled>Select country</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="CA">Canada</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Customize Workspace Label -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="text-sm text-gray-700">
                                    <p class="font-medium">Customize workspace label</p>
                                    <p class="text-xs text-gray-500 mt-1">Set the term used to refer workspace across your knowledge base.</p>
                                </div>
                                <div class="md:col-span-2">
                                    <input x-model="settings.workspaceLabel" type="text" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150">
                                    <p class="text-xs text-gray-500 mt-2">
                                        To localize this term across your knowledge base,
                                        <a href="#" class="text-primary-600 hover:underline font-medium">Click here!</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Redirect Option -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="text-sm font-medium text-gray-700"></div>
                                <div class="md:col-span-2 flex items-center space-x-10">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input x-model="settings.redirectOption" value="root" type="radio" class="form-radio h-4 w-4 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-700">Redirect to root article</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input x-model="settings.redirectOption" value="same" type="radio" class="form-radio h-4 w-4 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm text-gray-700">Redirect to same article</span>
                                    </label>
                                    <button @click="showInfo('redirect')" type="button" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember State Toggle -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                                <div class="text-sm text-gray-700">
                                    <p class="font-medium">Remember state</p>
                                    <p class="text-xs text-gray-500 mt-1">Remember the last UI state when navigating between sections.</p>
                                </div>
                                <div class="md:col-span-2">
                                    <button @click="settings.rememberState = !settings.rememberState" type="button" :class="{'bg-green-500': settings.rememberState, 'bg-gray-200': !settings.rememberState}" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                        <span :class="{'translate-x-5': settings.rememberState, 'translate-x-0': !settings.rememberState}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform transition duration-200"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editor Settings -->
                    <div class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Editor</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-sm text-gray-700">
                                <p class="font-medium">Choose the default editor for new articles at the project level.</p>
                            </div>
                            <div class="md:col-span-2 space-y-4">
                                <label class="flex items-start space-x-3 cursor-pointer">
                                    <input x-model="settings.editor" value="markdown" type="radio" class="form-radio h-4 w-4 text-primary-600 mt-1 focus:ring-primary-500">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Markdown</p>
                                        <p class="text-xs text-gray-500">An intuitive and lightweight text-to-HTML conversion tool for content writers</p>
                                    </div>
                                </label>

                                <label class="block space-y-2 cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <input x-model="settings.editor" value="wysiwyg" type="radio" class="form-radio h-4 w-4 text-primary-600 mt-1 focus:ring-primary-500">
                                        <p class="text-sm font-medium text-gray-700">Advanced WYSIWYG <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full text-white bg-green-500">NEW</span></p>
                                    </div>
                                    <p class="text-xs text-gray-500 ml-7">Enhanced editing and formatting experience for Text, Images, Videos, etc.</p>

                                    <label class="flex items-center space-x-2 text-xs text-gray-700 ml-7 mt-2">
                                        <input x-model="settings.showOutline" type="checkbox" class="form-checkbox h-4 w-4 text-primary-600 rounded focus:ring-primary-500">
                                        <span>Show outline view in advanced WYSIWYG editor</span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Documentation Settings -->
                    <div class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Documentation</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            <div class="text-sm text-gray-700">
                                <p class="font-medium">Default review reminder for published articles/category pages.</p>
                            </div>
                            <div class="md:col-span-2">
                                <button @click="settings.reviewReminders = !settings.reviewReminders" type="button" :class="{'bg-green-500': settings.reviewReminders, 'bg-gray-200': !settings.reviewReminders}" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <span :class="{'translate-x-5': settings.reviewReminders, 'translate-x-0': !settings.reviewReminders}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform transition duration-200"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Drive Settings -->
                    <div class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Drive settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-sm text-gray-700">
                                <p class="font-medium">Allow or restrict file formats on Drive</p>
                            </div>
                            <div class="md:col-span-2 space-y-3">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input x-model="settings.mediaFormat" value="all" type="radio" class="form-radio h-4 w-4 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-700">Allow all media formats</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input x-model="settings.mediaFormat" value="choose" type="radio" class="form-radio h-4 w-4 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-700">Choose allowed media formats</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Settings -->
                    <div class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Analytics settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            <div class="text-sm text-gray-700">
                                <p class="font-medium">Exclude certain IPs from project analytics.</p>
                            </div>
                            <div class="md:col-span-2 flex items-center space-x-3">
                                <input x-model="settings.excludedIPs" type="text" placeholder="Enter IP range" class="w-full max-w-sm p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <span class="text-sm text-gray-500 hidden sm:inline">eg: 0.0.0.0 - 255.255.255</span>
                                <button @click="showInfo('analytics')" type="button" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Support Access -->
                    <div class="border-b border-gray-200 pb-8 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Support Access</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            <div class="text-sm text-gray-700">
                                <p class="font-medium">Grant permission to the support user to access the team account.</p>
                            </div>
                            <div class="md:col-span-2">
                                <button @click="settings.supportAccess = !settings.supportAccess" type="button" :class="{'bg-green-500': settings.supportAccess, 'bg-gray-200': !settings.supportAccess}" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <span :class="{'translate-x-5': settings.supportAccess, 'translate-x-0': !settings.supportAccess}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform transition duration-200"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Knowledge Base -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Delete knowledge base</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            <div class="text-sm text-gray-700 md:col-span-2">
                                <p class="font-medium">
                                    To delete your project, please contact support:
                                    <a href="mailto:support@document360.com" class="text-primary-600 hover:underline">
                                        support@document360.com
                                    </a>
                                </p>
                            </div>
                            <div class="md:col-span-3">
                                <button @click="confirmDelete()" class="bg-red-600 text-white font-medium px-6 py-2.5 rounded-lg shadow-md hover:bg-red-700 transition-colors duration-150">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('settingsApp', () => ({
                sections: {
                    portal: true,
                    site: false,
                    users: false,
                    ai: false
                },
                settings: {
                    projectName: 'Project',
                    country: '',
                    workspaceLabel: 'Workspace',
                    redirectOption: 'same',
                    rememberState: true,
                    editor: 'wysiwyg',
                    showOutline: true,
                    reviewReminders: false,
                    mediaFormat: 'all',
                    excludedIPs: '',
                    supportAccess: false
                },
                showModal: false,
                modalTitle: '',
                modalContent: '',

                init() {
                    // Load saved settings from localStorage
                    const saved = localStorage.getItem('knowledgeBaseSettings');
                    if (saved) {
                        this.settings = { ...this.settings, ...JSON.parse(saved) };
                    }
                },

                toggleSection(section) {
                    this.sections[section] = !this.sections[section];
                },

                save() {
                    // Save settings to localStorage
                    localStorage.setItem('knowledgeBaseSettings', JSON.stringify(this.settings));

                    // Show success message
                    alert('Settings saved successfully!');

                    // In a real app, you would send data to server here
                    // axios.post('/api/settings', this.settings).then(response => {...})
                },

                cancel() {
                    // Reset to saved settings
                    const saved = localStorage.getItem('knowledgeBaseSettings');
                    if (saved) {
                        this.settings = JSON.parse(saved);
                    }
                    // Or go back to previous page
                    // window.history.back();
                },

                showInfo(type) {
                    const info = {
                        redirect: {
                            title: 'Redirect Options',
                            content: 'Choose how to handle article redirections when moving or deleting articles.'
                        },
                        analytics: {
                            title: 'Analytics IP Exclusion',
                            content: 'Exclude specific IP addresses or ranges from being tracked in your analytics.'
                        }
                    };

                    if (info[type]) {
                        this.modalTitle = info[type].title;
                        this.modalContent = info[type].content;
                        this.showModal = true;
                    }
                },

                confirmDelete() {
                    if (confirm('Are you sure you want to delete this knowledge base? This action cannot be undone.')) {
                        // Handle delete action
                        alert('Delete request sent to support.');
                    }
                }
            }));
        });
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(107, 114, 128, 0.5);
            border-radius: 2px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        input:focus, select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection
