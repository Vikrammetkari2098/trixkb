@extends('layouts.app')

@section('content')
    <style>
        /* Custom Styles for the Interactive Flow/Decision Tree Sidebar */
        .flow-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding-bottom: 0.25rem;
            padding-top: 0.25rem;
        }

        .flow-line {
            height: 6px;
            background-color: #3B82F6;
            width: 100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 0;
            right: 0;
            z-index: 10;
        }

        .flow-circle {
            width: 24px;
            height: 24px;
            background-color: #7C3AED;
            border-radius: 9999px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            margin-left: auto;
            margin-right: auto;
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        .flow-container:hover .flow-circle {
            opacity: 1;
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(124, 58, 237, 0.3);
        }

        .flow-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 8px rgba(124, 58, 237, 0.4);
        }

        /* Fix for dropdowns showing on load */
        [x-cloak] {
            display: none !important;
        }

        /* Dropdown positioning fixes */
        .dropdown-menu {
            display: none;
        }

        .dropdown-open:opacity-100 {
            display: block;
        }

        /* Editor modal styles */
        .editor-toolbar {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .editor-toolbar-btn {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
        }

        .editor-toolbar-btn:hover {
            background-color: #f3f4f6;
        }

        .editor-toolbar-btn.primary {
            background-color: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        .editor-toolbar-btn.primary:hover {
            background-color: #4338ca;
        }

        .editor-content {
            min-height: 500px;
            padding: 1.5rem;
            font-size: 1rem;
            line-height: 1.75;
        }

        .editor-sidebar {
            border-left: 1px solid #e5e7eb;
            padding: 1rem;
            background-color: #f9fafb;
        }

        .sidebar-section {
            margin-bottom: 1.5rem;
        }

        .sidebar-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            color: #374151;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .sidebar-item:hover {
            background-color: #e5e7eb;
        }

        .sidebar-item-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: #6b7280;
        }

        .quick-insert-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-insert-btn:hover {
            background-color: #f3f4f6;
        }

        .add-image-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .add-image-btn:hover {
            background-color: #f3f4f6;
        }

        .jump-to-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            color: #374151;
            font-size: 0.875rem;
        }
    </style>

    <div class="flex h-screen overflow-hidden" x-data="{
        showCreateTreeModal: false,
        showStepEditorModal: false,
        stepTitle: 'Step title goes here',
        stepContent: '',
        activeTab: 'edit'
    }">
        <div class="flex-1 flex overflow-hidden bg-gray-50">
            <!-- Sidebar -->
            <div class="flex-shrink-0 w-64 bg-white border-r border-gray-200 overflow-y-auto shadow-lg z-10">
                <div class="px-4 py-4 border-b border-gray-100 flex items-center h-16">
                    <span class="text-lg font-semibold text-gray-800 tracking-tight">INTERACTIVE DECISION TREES</span>
                </div>

                <div class="p-4" x-data="{ treeOpen: true }">
                    <div class="flex items-center justify-between mb-2">
                        <div @click="treeOpen = !treeOpen"
                            class="flex items-center space-x-2 text-gray-500 hover:text-gray-700 cursor-pointer select-none">
                            <svg class="w-4 h-4 transition-transform duration-200"
                                :class="{'rotate-180': treeOpen, 'rotate-0': !treeOpen}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <span class="text-sm font-medium">Interactive Decision Trees</span>
                        </div>

                        <!-- Tree Options Dropdown -->
                        <div x-data="{ treeOptionsOpen: false }" @click.outside="treeOptionsOpen = false" class="relative inline-flex">
                            <button @click="treeOptionsOpen = !treeOptionsOpen"
                                type="button"
                                class="p-1 rounded-full text-gray-500 hover:bg-gray-100 transition"
                                aria-haspopup="menu"
                                :aria-expanded="treeOptionsOpen"
                                aria-label="Tree Options">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                            </button>

                            <ul x-show="treeOptionsOpen"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                x-cloak
                                class="absolute right-0 mt-8 min-w-60 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-50 origin-top-right"
                                role="menu"
                                aria-orientation="vertical">

                                <li class="flex items-center gap-2 px-2">
                                    <button type="button" class="flex-1 flex items-center justify-center p-2 hover:bg-gray-100 rounded">
                                        <span class="icon-[tabler--eye-off] text-gray-400 size-5"></span>
                                    </button>
                                    <button type="button" class="flex-1 flex items-center justify-center p-2 hover:bg-red-50 rounded">
                                        <span class="icon-[tabler--trash] text-red-400 size-5"></span>
                                    </button>
                                </li>
                                <hr class="my-1 border-gray-200">

                                <li>
                                    <a @click="showCreateTreeModal = true; treeOptionsOpen = false;"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 cursor-pointer">
                                        <span class="icon-[tabler--git-branch] text-gray-400 size-5"></span>
                                        Add interactive decision tree
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 cursor-pointer">
                                        <span class="icon-[tabler--folder] text-gray-400 size-5"></span>
                                        Sub category
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center gap-3 px-4 py-2 text-sm text-gray-800 hover:bg-gray-100" href="#">
                                        <span class="icon-[tabler--credit-card] text-gray-400 size-5"></span>
                                        Set drive folder
                                    </a>
                                </li>

                                <li x-data="{ nestedSecurityOpen: false }" class="relative">
                                    <a @click="nestedSecurityOpen = !nestedSecurityOpen"
                                       class="flex items-center justify-between px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 cursor-pointer">
                                        <span class="flex items-center gap-3">
                                            <span class="icon-[tabler--lock] text-gray-400 size-5"></span>
                                            Security
                                        </span>
                                        <span class="icon-[tabler--chevron-right] text-gray-400 size-4 transition-transform"
                                              :class="{'rotate-90': nestedSecurityOpen}"></span>
                                    </a>

                                    <div x-show="nestedSecurityOpen"
                                         x-transition
                                         x-cloak
                                         class="absolute left-0 top-full ml-1 w-64 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50">
                                        <a class="flex items-start gap-3 px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <span class="icon-[tabler--lock] text-gray-400 size-5"></span>
                                            <span>
                                                <div class="text-xs font-semibold text-gray-700 tracking-wide">KNOWLEDGE BASE PORTAL</div>
                                                <div class="text-xs text-gray-500">Access control</div>
                                            </span>
                                        </a>
                                        <a class="flex items-start gap-3 px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <span class="icon-[tabler--lock] text-gray-400 size-5"></span>
                                            <span>
                                                <div class="text-xs font-semibold text-gray-700 tracking-wide">KNOWLEDGE BASE SITE</div>
                                                <div class="text-xs text-gray-500">Access control</div>
                                            </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <ul x-show="treeOpen" x-transition:enter.duration.500ms x-transition:leave.duration.400ms class="space-y-1 pl-3">
                        <li class="relative">
                            <div class="absolute left-0 top-0 h-full w-1 bg-violet-600 rounded-full"></div>
                            <div class="flex items-center justify-between pl-3 pr-2 py-1.5 bg-violet-50/50 rounded-r-lg cursor-pointer">
                                <div class="flex items-center space-x-2 text-gray-900 font-semibold text-sm">
                                    <span class="w-2 h-2 rounded-full bg-yellow-400 border border-yellow-500"></span>
                                    <span>new kb</span>
                                </div>

                                <!-- Item Options Dropdown -->
                                <div x-data="{ itemOptionsOpen: false }" @click.outside="itemOptionsOpen = false" class="relative inline-flex">
                                    <button @click="itemOptionsOpen = !itemOptionsOpen"
                                            type="button"
                                            class="p-1 rounded-full hover:bg-gray-100 text-gray-500 transition"
                                            aria-haspopup="menu"
                                            :aria-expanded="itemOptionsOpen"
                                            aria-label="Item Options">
                                        <span class="icon-[tabler--dots] size-6"></span>
                                    </button>

                                    <ul x-show="itemOptionsOpen"
                                        x-transition
                                        x-cloak
                                        class="absolute right-0 mt-8 rounded-xl shadow-lg border border-gray-100 bg-white w-56 py-2 z-50 origin-top-right"
                                        role="menu"
                                        aria-orientation="vertical">
                                        <li>
                                            <div class="flex items-center justify-around gap-4 px-4 py-2 text-gray-600 text-sm">
                                                <button type="button" class="p-1 hover:bg-gray-50 rounded-lg flex items-center gap-2">
                                                    <span class="icon-[tabler--eye-off] size-5 text-gray-500"></span>
                                                    <span class="text-sm">Hide</span>
                                                </button>
                                                <button type="button" class="p-1 hover:bg-red-50 rounded-lg flex items-center gap-2 text-red-600">
                                                    <span class="icon-[tabler--trash] size-5"></span>
                                                    <span class="text-sm">Delete</span>
                                                </button>
                                            </div>
                                        </li>
                                        <li><div class="border-t my-2 border-gray-200"></div></li>
                                        <li>
                                            <button type="button" disabled class="flex items-center gap-4 w-full px-4 py-2 text-gray-300 text-sm cursor-not-allowed">
                                                <span class="icon-[tabler--circle-check] size-5"></span>
                                                Publish
                                            </button>
                                        </li>
                                        <li><div class="border-t my-2 border-gray-200"></div></li>
                                        <li x-data="{ itemSecurityOpen: false }" class="relative">
                                            <div @click="itemSecurityOpen = !itemSecurityOpen"
                                                 class="flex items-center justify-between px-4 py-2 text-gray-600 text-sm cursor-pointer hover:bg-gray-50">
                                                <div class="flex items-center gap-4">
                                                    <span class="icon-[tabler--lock] size-5"></span>
                                                    Security
                                                </div>
                                                <span class="icon-[tabler--chevron-right] size-4 transition-transform" :class="itemSecurityOpen ? 'rotate-90' : ''"></span>
                                            </div>
                                            <div x-show="itemSecurityOpen"
                                                 x-transition
                                                 x-cloak
                                                 id="security-submenu"
                                                 class="ml-8 mt-1 space-y-2 pb-2">
                                                <a href="#" class="block p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <div class="flex items-center gap-3">
                                                        <span class="icon-[tabler--lock-open] size-5 text-gray-500"></span>
                                                        <div>
                                                            <p class="text-xs font-semibold text-gray-700">KNOWLEDGE BASE PORTAL</p>
                                                            <p class="text-xs text-gray-500">Access control</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="block p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <div class="flex items-center gap-3">
                                                        <span class="icon-[tabler--lock-open] size-5 text-gray-500"></span>
                                                        <div>
                                                            <p class="text-xs font-semibold text-gray-700">KNOWLEDGE BASE SITE</p>
                                                            <p class="text-xs text-gray-500">Access control</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <div class="flow-container">
                            <div class="flow-line"></div>
                            <div class="flow-circle">
                                <button type="button" class="w-full h-full flex items-center justify-center text-white" aria-label="Add a new step">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-y-auto bg-white">
                <header class="flex-shrink-0 bg-white border-b border-gray-200 shadow-sm h-16 flex items-center justify-between px-6">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-bold text-gray-900">new kb</h1>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            DRAFT
                        </span>
                        <a href="#" target="_blank" class="flex items-center space-x-1 text-sm text-gray-500 hover:text-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>Preview</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Header Dropdown with Alpine.js -->
                        <div x-data="{ headerDropdownOpen: false }" @click.outside="headerDropdownOpen = false" class="relative inline-flex">
                            <button @click="headerDropdownOpen = !headerDropdownOpen"
                                id="dropdown-menu-icon"
                                type="button"
                                class="dropdown-toggle btn btn-soft btn-secondary"
                                aria-haspopup="menu"
                                :aria-expanded="headerDropdownOpen"
                                aria-label="Dropdown">
                                <span class="icon-[tabler--dots] size-6"></span>
                            </button>

                            <ul x-show="headerDropdownOpen"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                x-cloak
                                class="absolute right-0 mt-10 min-w-60 bg-white shadow-lg border border-gray-200 rounded-lg p-2 z-50"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="dropdown-menu-icon">
                                <li>
                                    <a class="dropdown-item flex items-center gap-3 px-3 py-2 hover:bg-gray-100 rounded" href="#">
                                        <span class="icon-[tabler--world] size-5 text-gray-500"></span>
                                        SEO
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item flex items-center gap-3 px-3 py-2 hover:bg-gray-100 rounded" href="#">
                                        <span class="icon-[tabler--tag] size-5 text-gray-500"></span>
                                        Tags
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item flex items-center gap-3 px-3 py-2 hover:bg-gray-100 rounded" href="#">
                                        <span class="icon-[tabler--settings] size-5 text-gray-500"></span>
                                        More options
                                    </a>
                                </li>
                                <li class="my-2 border-t border-gray-200"></li>
                                <li>
                                    <a class="dropdown-item flex items-center gap-3 px-3 py-2 hover:bg-gray-100 rounded" href="#">
                                        <span class="icon-[tabler--history] size-5 text-gray-500"></span>
                                        Version history
                                    </a>
                                </li>
                                <li x-data="{ headerSecurityOpen: false }" class="relative">
                                    <a @click="headerSecurityOpen = !headerSecurityOpen"
                                        class="dropdown-item flex items-center justify-between gap-3 px-3 py-2 hover:bg-gray-100 rounded cursor-pointer">
                                        <span class="flex items-center gap-3">
                                            <span class="icon-[tabler--lock] size-5 text-gray-500"></span>
                                            Security
                                        </span>
                                        <span class="icon-[tabler--chevron-right] size-5 text-gray-400 transition-transform"
                                              :class="{'rotate-90': headerSecurityOpen}"></span>
                                    </a>
                                    <div x-show="headerSecurityOpen"
                                         x-transition
                                         x-cloak
                                         class="absolute left-0 top-full ml-1 w-72 bg-white border border-gray-200 shadow-lg rounded-lg p-3 z-50">
                                        <div class="p-3 rounded-lg hover:bg-gray-100 cursor-pointer">
                                            <div class="flex items-start gap-3">
                                                <span class="icon-[tabler--lock] size-5 text-gray-500 mt-1"></span>
                                                <div>
                                                    <div class="font-semibold text-gray-700">
                                                        KNOWLEDGE BASE PORTAL
                                                    </div>
                                                    <div class="text-gray-500 text-sm -mt-1">
                                                        Access control
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 rounded-lg hover:bg-gray-100 cursor-pointer">
                                            <div class="flex items-start gap-3">
                                                <span class="icon-[tabler--lock] size-5 text-gray-500 mt-1"></span>
                                                <div>
                                                    <div class="font-semibold text-gray-700">
                                                        KNOWLEDGE BASE SITE
                                                    </div>
                                                    <div class="text-gray-500 text-sm -mt-1">
                                                        Access control
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg shadow-sm text-white bg-violet-600 hover:bg-violet-700 transition-all">
                            Publish
                        </button>
                    </div>
                </header>

                <main class="flex-1 p-6 flex flex-col justify-center items-center bg-gray-50">
                    <div class="w-full max-w-md text-center py-10">
                        <p class="text-gray-600 mb-6 font-semibold">Load from template</p>
                        <div class="space-y-3 mb-8">
                            <button type="button" class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                                Workflow Designer - 2 Step
                            </button>
                            <button type="button" class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                                Workflow Assignment - 3 Step
                            </button>
                        </div>
                        <p class="text-gray-400 mb-6">or</p>
                        <p class="text-gray-600 mb-6 font-semibold">Start blank</p>
                        <button @click="showStepEditorModal = true"
                                type="button"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add your first step
                        </button>
                    </div>
                </main>
            </div>
        </div>

        <!-- CREATE TREE MODAL -->
        <div x-show="showCreateTreeModal"
             x-transition.opacity
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div x-show="showCreateTreeModal"
                 x-transition.scale
                 class="bg-white rounded-lg shadow-xl w-full max-w-md p-6"
                 @click.away="showCreateTreeModal = false">
                <h2 class="text-lg font-bold text-gray-800 mb-4">
                    Create New Interactive Decision Tree
                </h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                           placeholder="Enter title">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none">
                        <option value="">Select Category</option>
                        <option value="General">Interactive Decision Trees</option>
                        <option value="Technical">Technical</option>
                        <option value="Support">Support</option>
                        <option value="Troubleshooting">Troubleshooting</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg"
                            @click="showCreateTreeModal = false">
                        Cancel
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            @click="showCreateTreeModal = false">
                        Save
                    </button>
                </div>
            </div>
        </div>
        <!-- STEP EDITOR MODAL -->
        <div x-show="showStepEditorModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/20">

            <div x-show="showStepEditorModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="showStepEditorModal = false"
                class="bg-white rounded-lg shadow-lg w-full max-w-6xl h-[90vh] flex flex-col overflow-hidden border border-gray-200">

                <!-- Modal Header -->
                <header class="flex items-center justify-between p-4 border-b border-gray-200 bg-gray">
                    <div class="flex items-center space-x-2 text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Layout</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <button @click="showStepEditorModal = false"
                            class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <main class="flex-grow flex overflow-hidden bg-white">
                    <div class="grid grid-cols-12 w-full">

                        <!-- Left Panel -->
                        <div class="col-span-8 p-8 overflow-y-auto border-r border-gray-200">
                            <h1 class="text-4xl font-light text-gray-300 mb-6">Step title goes here</h1>
                            <p class="text-gray-500 mb-8">Press '/' for commands</p>

                            <!-- Quick Insert Toolbar -->
                            <div class="flex items-center space-x-1 mb-8 border border-gray-200 rounded-lg p-2 w-max bg-white shadow-sm">
                                <span class="text-sm font-medium text-gray-700 px-2">Quick insert</span>
                                <span class="text-gray-300">|</span>
                                <button class="p-1.5 hover:bg-gray-100 rounded text-gray-600 hover:text-gray-800 transition-colors">☰</button>
                                <button class="p-1.5 hover:bg-gray-100 rounded text-gray-600 hover:text-gray-800 transition-colors">🖼️</button>
                                <button class="p-1.5 hover:bg-gray-100 rounded text-gray-600 hover:text-gray-800 transition-colors">🔗</button>
                                <button class="p-1.5 hover:bg-gray-100 rounded text-gray-600 hover:text-gray-800 transition-colors">$$</button>
                                <button class="p-1.5 hover:bg-gray-100 rounded text-gray-600 hover:text-gray-800 transition-colors">/&lt;></button>
                                <span class="text-gray-300">|</span>
                                <button class="p-1.5 text-sm text-blue-600 font-medium hover:text-blue-800 hover:bg-blue-50 rounded transition-colors">More</button>
                            </div>

                            <!-- Action Button with Dropdown -->
                            <div x-data="{ showActionType: false }" class="relative">
                                <button @click="showActionType = !showActionType"
                                        class="flex items-center space-x-2 px-4 py-2.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors border border-blue-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span class="font-medium">Action</span>
                                    <svg :class="showActionType ? 'rotate-180' : ''"
                                        class="w-4 h-4 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Action Type Dropdown -->
                                <div x-show="showActionType"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    @click.away="showActionType = false"
                                    class="absolute z-10 top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-lg border border-gray-200 p-3">
                                    <p class="text-xs uppercase text-gray-500 mb-2 tracking-wider">Action Type</p>
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" class="form-checkbox text-blue-600 rounded border-gray-300" checked>
                                            <span class="text-gray-700 text-sm">Buttons</span>
                                        </label>
                                        <label class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" class="form-checkbox text-blue-600 rounded border-gray-300">
                                            <span class="text-gray-700 text-sm">Radio choices</span>
                                        </label>
                                        <label class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" class="form-checkbox text-blue-600 rounded border-gray-300" checked>
                                            <span class="text-gray-700 text-sm">Dropdown choices</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel -->
                        <div class="col-span-4 p-8 flex flex-col items-center justify-center bg-gray-50">
                            <div class="p-10 bg-gray-100 rounded-lg text-center border border-gray-200 hover:border-gray-300 transition-colors">
                                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <button class="mt-3 text-blue-600 font-medium hover:text-blue-800 hover:underline transition-colors">
                                    Add image
                                </button>
                                <p class="text-xs text-gray-500 mt-1">Supports PNG, JPG, SVG</p>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="flex items-center justify-end p-4 border-t border-gray-200 **bg-gray-100**">
                    <button class="flex items-center space-x-2 text-gray-600 font-medium mr-4 hover:text-gray-800 px-3 py-2 rounded hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="text-sm">Preview</span>
                    </button>
                    <button @click="showStepEditorModal = false"
                            class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors shadow-sm">
                        Done
                    </button>
                </footer>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add slash command listener
            document.addEventListener('keydown', function(e) {
                if (e.key === '/' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    // Focus on the editor or show command palette
                    const editor = document.querySelector('[contenteditable="true"]');
                    if (editor) {
                        editor.focus();
                    }
                }
            });

            // Initialize content editable area
            const editor = document.querySelector('[contenteditable="true"]');
            if (editor) {
                editor.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const text = e.clipboardData.getData('text/plain');
                    document.execCommand('insertText', false, text);
                });
            }
        });
    </script>
@endsection
