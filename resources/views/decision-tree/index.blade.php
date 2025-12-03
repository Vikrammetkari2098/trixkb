@extends('layouts.app')

@section('content')
    <style>
        /*
         * Custom Styles for the Interactive Flow/Decision Tree Sidebar
         * These styles handle the flow line and the central insertion circle.
         */

        /* Ensures the flow line stays centered within the container's height */
        .flow-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding-bottom: 0.25rem;
            padding-top: 0.25rem;
        }

        /* The horizontal flow line - UPDATED: Thicker (6px) and Blue (#3B82F6 - blue-500) */
        .flow-line {
            height: 6px; /* Increased thickness */
            background-color: #3B82F6; /* Blue color */
            width: 100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 0;
            right: 0;
            z-index: 10;
        }

        /* The insertion point (Add Step Button) */
        .flow-circle {
            /* Small circle styling */
            width: 24px;
            height: 24px;
            background-color: #7C3AED; /* Original violet, but we'll hide it for the initial state */
            border-radius: 9999px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            margin-left: auto;
            margin-right: auto;

            /* ADDED: Initial state is hidden (opacity 0) and smaller (scale 0.8) */
            opacity: 0;
            transform: scale(0.8);

            /* ADDED: Transition for smooth hover effect */
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        /* The parent container is now responsible for showing the circle on hover */
        .flow-container:hover .flow-circle {
            /* SHOW ON HOVER: Full opacity and scale 1 (normal size) */
            opacity: 1;
            transform: scale(1);

            /* ADDED: Box-shadow for glow effect on hover */
            box-shadow: 0 0 0 6px rgba(124, 58, 237, 0.3);
        }

        /* Optional: slight scale on the circle itself when hovered */
        .flow-circle:hover {
             transform: scale(1.1);
             box-shadow: 0 0 0 8px rgba(124, 58, 237, 0.4);
        }
    </style>

    <div class="flex h-screen overflow-hidden" x-data="{ showCreateTreeModal: false }"> <div class="flex-1 flex overflow-hidden bg-gray-50">

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

                        <div x-data="{ open: false }" @click.outside="open = false" class="relative inline-flex">
                            <button @click="open = !open"
                                type="button"
                                class="p-1 rounded-full text-gray-500 hover:bg-gray-100 transition"
                                aria-haspopup="menu"
                                :aria-expanded="open"
                                aria-label="Tree Options">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                            </button>

                            <ul x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
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
                                    <a @click="showCreateTreeModal = true; open = false;"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 cursor-pointer">
                                        <span class="icon-[tabler--git-branch] text-gray-400 size-5"></span>
                                        Add interactive decision tree
                                    </a>
                                </li>
                                <li>
                                    <a
                                        @click.prevent="showCreateSubCategoryModal = true; open = false;"
                                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 cursor-pointer"
                                    >
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

                                <li x-data="{ nestedOpen: false }" class="relative group">
                                    <a @click="nestedOpen = !nestedOpen"
                                    class="flex items-center justify-between px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 cursor-pointer"
                                    aria-controls="nested-security-submenu">
                                        <span class="flex items-center gap-3">
                                            <span class="icon-[tabler--lock] text-gray-400 size-5"></span>
                                            Security
                                        </span>
                                        <span class="icon-[tabler--chevron-right] text-gray-400 size-4"></span>
                                    </a>
                                    <div x-show="nestedOpen" x-transition
                                        id="nested-security-submenu"
                                        class="absolute top-0 left-full ml-1 w-64 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50">
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

                                <div x-data="{ open: false }" @click.outside="open = false" class="relative inline-flex">
                                    <button @click="open = !open" type="button" class="p-1 rounded-full hover:bg-gray-100 text-gray-500 transition" aria-haspopup="menu" :aria-expanded="open" aria-label="Item Options">
                                        <span class="icon-[tabler--dots] size-6"></span>
                                    </button>

                                    <ul x-show="open" x-transition class="absolute right-0 mt-8 rounded-xl shadow-lg border border-gray-100 bg-white w-56 py-2 z-50 origin-top-right" role="menu" aria-orientation="vertical">
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
                                        <li x-data="{ subOpen: false }" class="relative">
                                            <div @click="subOpen = !subOpen" class="flex items-center justify-between px-4 py-2 text-gray-600 text-sm cursor-pointer hover:bg-gray-50" aria-controls="security-submenu">
                                                <div class="flex items-center gap-4">
                                                    <span class="icon-[tabler--lock] size-5"></span>
                                                    Security
                                                </div>
                                                <span class="icon-[tabler--chevron-right] size-4 transition-transform" :class="subOpen ? 'rotate-90' : ''"></span>
                                            </div>
                                            <div x-show="subOpen" x-transition id="security-submenu" class="ml-8 mt-1 space-y-2 pb-2">
                                                <a href="#" class="block p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <div class="flex items-center gap-3">
                                                        <span class="icon-[tabler--lock-open] size-5 text-gray-500"></span>
                                                        <div><p class="text-xs font-semibold text-gray-700">KNOWLEDGE BASE PORTAL</p><p class="text-xs text-gray-500">Access control</p></div>
                                                    </div>
                                                </a>
                                                <a href="#" class="block p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <div class="flex items-center gap-3">
                                                        <span class="icon-[tabler--lock-open] size-5 text-gray-500"></span>
                                                        <div><p class="text-xs font-semibold text-gray-700">KNOWLEDGE BASE SITE</p><p class="text-xs text-gray-500">Access control</p></div>
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
            <div class="flex-1 flex flex-col overflow-y-auto bg-white">

                <header class="flex-shrink-0 bg-white border-b border-gray-200 shadow-sm h-16 flex items-center justify-between px-6">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-bold text-gray-900">new kb</h1>

                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            DRAFT
                        </span>

                        <a href="#" target="_blank" class="flex items-center space-x-1 text-sm text-gray-500 hover:text-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>Preview</span>
                        </a>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button type="button" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition" aria-label="More options">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                        </button>

                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-all">
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

                        <button type="button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add your first step
                        </button>
                    </div>
                </main>
            </div>
            </div>

            <!-- CREATE TREE MODAL -->
            <div
                x-show="showCreateTreeModal"
                x-transition.opacity
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            >
                <!-- Modal Box -->
                <div
                    x-show="showCreateTreeModal"
                    x-transition.scale
                    class="bg-white rounded-lg shadow-xl w-full max-w-md p-6"
                    @click.away="showCreateTreeModal = false"
                >
                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        Create New Interactive Decision Tree
                    </h2>

                    <!-- Title Input -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                            placeholder="Enter title"
                        >
                    </div>

                    <!-- Category Input -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                        >
                            <option value="">Select Category</option>
                            <option value="General">Interactive Decision Trees</option>
                            <option value="Technical">Technical</option>
                            <option value="Support">Support</option>
                            <option value="Troubleshooting">Troubleshooting</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-2">
                        <button
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg"
                            @click="showCreateTreeModal = false"
                        >
                            Cancel
                        </button>

                        <button
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            @click="showCreateTreeModal = false"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
