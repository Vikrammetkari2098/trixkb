<div class="min-h-screen bg-gray-50" x-data="{ openMobileMenu: false }">
    <header class="w-full border-b bg-white px-6 lg:px-12 py-3 flex items-center justify-between shadow-sm">
        <!-- LEFT LOGO -->
        <div class="flex items-center">
            <span class="text-xl font-extrabold text-[#6A1B9A] tracking-wide">DOCUMENT360</span>
        </div>
        <!-- RIGHT SIDE: MENU + SIGNUP + PROFILE -->
        <div class="flex items-center space-x-10">
            <!-- MENU (Right aligned) -->
            <nav class="hidden md:flex space-x-8 text-gray-600 text-sm font-medium">
            <a href="#" class="hover:text-black">Features</a>
            <a href="#" class="hover:text-black">Pricing</a>
            <a href="#" class="hover:text-black">Book a demo</a>
            <a href="#" class="hover:text-black">Glossary</a>
            </nav>

            <!-- SIGNUP BUTTON -->
            <button class="px-5 py-2 bg-[#0052CC] text-white rounded-md text-sm font-medium hover:bg-blue-700">
            Sign up
            </button>
            <span class="icon-[mdi--bullhorn] size-8"></span>
            <span class="icon-[fa6-solid--circle-half-stroke] size-6"></span>
            <!-- PROFILE ICON -->
            <div class="w-8 h-8 rounded-full bg-yellow-300 text-sm flex items-center justify-center font-semibold border-2 border-gray-300">
            JW
            </div>
        </div>
    </header>

    <div class="bg-gray-100 border-b border-gray-200">
        <div class="max-w-auto mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center text-sm text-gray-500">
        <nav class="flex items-center space-x-1.5">
            <a href="#" class="hover:text-gray-700 flex items-center">
               <span class="icon-[material-symbols--home-rounded] size-6"></span>
            </a>
            <span class="text-gray-400">/</span>
            <a href="#" class="text-gray-500 hover:text-gray-700">Documentation</a>
            <span class="text-gray-400">/</span>
            <a href="#" class="text-gray-500 hover:text-gray-700">Getting started guides</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-800">test category</span>
        </nav>

            <div class="hidden lg:flex relative items-center">
                <input type="text" placeholder="Search" class="pl-3 pr-16 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 w-64">
                <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3 text-xs text-gray-400 font-medium">
                    CTRL+K
                </span>
            </div>
        </div>
    </div>

    <main class="max-w-auto mx-auto px-4 sm:px-6 lg:px-8 flex">
        <aside class="w-64 xl:w-72 flex-shrink-0 border-r border-gray-200 py-6 pr-6 h-150 sticky top-0 overflow-y-auto sidebar-scroll hidden lg:block">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">EXPLORE ARTICLES</h3>
            <div x-data="{ open: true }" class="mb-4">
                <button @click="open = !open" class="flex justify-between items-center w-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900">
                    Getting started guides
                    <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
                <div x-show="open" class="space-y-1 pl-4 border-l border-gray-200">
                    <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md">Product Installation Steps</a>
                    <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md">Initial Setup Guide</a>
                    <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md">Initial Setup Guide</a>
                </div>
            </div>
            <div x-data="{ open: true }">
                <button @click="open = !open" class="flex justify-between items-center w-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900">
                    test category
                    <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
                <div x-show="open" class="space-y-1 pl-4 border-l border-gray-200">
                    <a href="#" class="sidebar-item active block px-3 py-2 text-sm rounded-md font-medium">Testing Article dfdfdfdf</a>
                </div>
            </div>
        </aside>
        <article class="flex-1 min-w-0 py-8 pl-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Testing Article dfdfdfdf</h1>
            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-6">
                <p>Updated on Dec 9, 2025</p>
                <span class="h-1 w-1 bg-gray-300 rounded-full"></span>
                <p>Published on Dec 9, 2025</p>
                <div class="flex items-center space-x-1 ml-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p>1 minute(s) read</p>
                    <span class="h-1 w-1 bg-gray-300 rounded-full"></span>
                    <p class="flex items-center space-x-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9c2.535 2.536 2.535 6.645 0 9.18" /></svg> Listen</p>
                </div>
            </div>
            <div class="flex justify-between items-center border-t border-b border-gray-200 py-3 mb-8">
                <div class="w-8 h-8 rounded-full bg-yellow-300 text-sm flex items-center justify-center font-semibold border-2 border-gray-300">
                    JW
                </div>
                <div class="flex items-center space-x-4">
                    <button class="flex items-center space-x-1 text-sm font-medium text-blue-600 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        <span>EDIT ARTICLE</span>
                    </button>
                    <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                       <span class="icon-[material-symbols--share] size-6"></span>
                    </button>
                    <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <span class="icon-[svg-spinners--3-dots-move] size-8"></span>
                </div>
            </div>
            <div class="prose max-w-none text-gray-700"></div>
            <div class="mt-12 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <p class="text-lg font-medium text-gray-700 mb-4">Was this article helpful?</p>
                <div class="flex space-x-4">
                    <button class="flex items-center space-x-2 px-6 py-2 rounded-lg border border-green-500 bg-green-50 text-green-700 font-semibold hover:bg-green-100 transition duration-150">
                        <span class="icon-[material-symbols--thumb-up-rounded] size-8"></span>
                        <span>Yes</span>
                    </button>
                    <button class="flex items-center space-x-2 px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-50 transition duration-150">
                       <span class="icon-[material-symbols--thumb-down-rounded] size-8"></span>
                        <span>No</span>
                    </button>
                </div>
            </div>
            <div class="mt-8">
                <a href="#" class="inline-flex items-center p-4 bg-gray-100 rounded-lg text-gray-700 hover:bg-gray-200 transition duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    <div>
                        <p class="text-sm text-gray-500">Previous article</p>
                        <p class="font-medium">Initial Setup Guide</p>
                    </div>
                </a>
            </div>
        </article>
    </main>
    <footer class="mt-3 border-t border-gray-200 bg-gray-100">
        <div class="max-w-auto mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-8">

                <div class="col-span-2 space-y-4">
                    <h3 class="text-xl font-bold text-indigo-600">DOCUMENT360</h3>
                    <p class="text-sm text-gray-600 max-w-xs">
                        Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.
                    </p>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-800">PRODUCTS</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Business</a></li>
                        <li><a href="#" class="hover:text-gray-900">Compare</a></li>
                        <li><a href="#" class="hover:text-gray-900">Features</a></li>
                        <li><a href="#" class="hover:text-gray-900">Pricing</a></li>
                        <li><a href="#" class="hover:text-gray-900">Mobile</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-800">COMPANY</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">About Us</a></li>
                        <li><a href="#" class="hover:text-gray-900">Blog</a></li>
                        <li><a href="#" class="hover:text-gray-900">Customers</a></li>
                        <li><a href="#" class="hover:text-gray-900">Careers</a></li>
                        <li><a href="#" class="hover:text-gray-900">Newsroom</a></li>
                        <li><a href="#" class="hover:text-gray-900">Contact Us</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-800">TOP FEATURES</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Ticketing</a></li>
                        <li><a href="#" class="hover:text-gray-900">Collaboration</a></li>
                        <li><a href="#" class="hover:text-gray-900">Automations</a></li>
                        <li><a href="#" class="hover:text-gray-900">Self Service</a></li>
                        <li><a href="#" class="hover:text-gray-900">Reporting & Analytics</a></li>
                        <li><a href="#" class="hover:text-gray-900">Customizations</a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-gray-800">SOLUTIONS</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Enterprise</a></li>
                        <li><a href="#" class="hover:text-gray-900">SMB</a></li>
                        <li><a href="#" class="hover:text-gray-900">E-commerce</a></li>
                        <li><a href="#" class="hover:text-gray-900">Healthcare</a></li>
                        <li><a href="#" class="hover:text-gray-900">Education</a></li>
                    </ul>
                    <h4 class="text-sm font-semibold text-gray-800 mt-6">EXISTING USERS</h4>
                    <button class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">LOGIN</button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-col space-y-3">
                    <h4 class="text-sm font-semibold text-gray-800">SALES AND SUPPORT</h4>
                    <p class="flex items-center text-sm text-gray-600 space-x-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.5l1.5 5.5-3 1.5a14.73 14.73 0 006 6l1.5-3 5.5 1.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                        <span>+1 (123) 225-0025</span>
                    </p>
                    <p class="flex items-center text-sm text-gray-600 space-x-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 4v7a2 2 0 002 2h14a2 2 0 002-2v-7" /></svg>
                        <span>support@document360.com</span>
                    </p>
                </div>
                <div class="md:text-right mt-6 md:mt-0">
                    <h4 class="text-sm font-semibold text-gray-800 mb-3">CONNECT WITH US</h4>
                    <div class="flex md:justify-end space-x-3">
                        <a href="#" class="flex items-center justify-center w-8 h-8 rounded-full border border-gray-300 text-gray-400 hover:text-gray-600 hover:border-gray-400">f</a>
                        <a href="#" class="flex items-center justify-center w-8 h-8 rounded-full border border-gray-300 text-gray-400 hover:text-gray-600 hover:border-gray-400">in</a>
                        <a href="#" class="flex items-center justify-center w-8 h-8 rounded-full border border-gray-300 text-gray-400 hover:text-gray-600 hover:border-gray-400">x</a>
                        <a href="#" class="flex items-center justify-center w-8 h-8 rounded-full border border-gray-300 text-gray-400 hover:text-gray-600 hover:border-gray-400">yt</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <div class="flex space-x-4 mb-2 md:mb-0">
                    <a href="#" class="hover:text-gray-700">Terms on Services</a>
                    <span class="text-gray-300">•</span>
                    <a href="#" class="hover:text-gray-700">Privacy Policy</a>
                    <span class="text-gray-300">•</span>
                    <a href="#" class="hover:text-gray-700">GDPR</a>
                    <span class="text-gray-300">•</span>
                    <a href="#" class="hover:text-gray-700">Site Map</a>
                </div>
                <p>Copyright © Abc Inc. All rights reserved.</p>
            </div>
        </div>
        <button class="fixed bottom-4 right-4 bg-gray-600 p-3 rounded-full text-white shadow-lg hover:bg-gray-700 transition duration-150">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
        </button>
    </footer>
    <style>
        /* Custom scrollbar style for the sidebar to match the image */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #e5e7eb; /* Gray-200 */
            border-radius: 2px;
        }
        /* Custom hover for sidebar item to match the image (light blue background) */
        .sidebar-item:hover {
            background-color: #f3f4f6; /* Gray-100 */
        }
        .sidebar-item.active {
            background-color: #e0f2f7; /* Light Blue/Cyan (adjust to match your primary color) */
            color: #0c4a6e; /* Darker text */
        }
    </style>
</div>
