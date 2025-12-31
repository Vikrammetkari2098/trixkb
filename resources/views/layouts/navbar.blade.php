<header class="flex items-center justify-between h-[45px] px-6 bg-[#18181b] text-gray-100 shadow-xl border-b border-[#374151] z-50 sticky top-0">
    <div class="flex items-center space-x-4">
        <button type="button" class="text-gray-300 lg:hidden hover:text-white transition duration-200 p-1 -ml-1 rounded-md hover:bg-[#374151]"
            aria-haspopup="dialog" aria-expanded="false" aria-controls="with-navbar-sidebar" data-overlay="#with-navbar-sidebar">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <a class="link no-underline flex items-center space-x-1" href="#">
            <img src="{{ asset('image/kblogo.png') }}" alt="KB Logo" class="h-8 transition duration-200 hover:scale-105">
            <span class="font-extrabold text-white text-lg hidden sm:block">KB</span>
        </a>

        <div class="h-6 w-[1px] bg-gray-600 hidden sm:block"></div>

       <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-start] hidden sm:flex items-center space-x-1">
            <button id="kb-version-switcher" type="button"
                    class="dropdown-toggle flex items-center space-x-1 p-2 rounded-lg hover:bg-[#374151] transition duration-200 text-sm"
                    aria-haspopup="menu" aria-expanded="false" aria-label="KB Version Switcher">

                <span class="flag-icon-container opacity-80">
                    <span class="flag-icon flag-icon-us rounded-md" style="border-radius: 4px;"></span>
                </span>

               <span class="font-bold text-white group-hover:text-white">All Workspace</span>

                <i class="fas fa-chevron-down text-gray-500 text-xs ml-1 transition dropdown-open:rotate-180"></i>
            </button>

            <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-48 bg-white dark:bg-[#2c3644] shadow-lg rounded-md"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="kb-version-switcher">

                <li>
                    <a class="dropdown-item flex items-center justify-between text-indigo-600 dark:text-indigo-400 font-bold bg-gray-50 dark:bg-[#374151]" href="#">
                        <span>v1 (Live)</span>
                        <span class="icon-[tabler--check] size-5"></span>
                    </a>
                </li>

                <li><hr class="border-gray-200 dark:border-gray-700 my-1"></li>

                <li>
                    <a class="dropdown-item flex items-center text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#374151]" href="#">
                        <span class="icon-[tabler--flask] size-5 mr-2"></span>
                        v2 (Beta)
                    </a>
                </li>

                <li>
                    <a class="dropdown-item flex items-center text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#374151]" href="#">
                        <span class="icon-[tabler--archive] size-5 mr-2"></span>
                        v0 (Archive)
                    </a>
                </li>

                <li>
                    <a class="dropdown-item flex items-center text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#374151]" href="#">
                        <span class="icon-[tabler--language] size-5 mr-2"></span>
                        Switch Language
                    </a>
                </li>
            </ul>
        </div>
        <div class="h-6 w-[1px] bg-gray-600 hidden sm:block"></div>
    </div>

    <div class="flex-grow max-w-2xl px-2 mx-auto hidden md:block">
    <div class="flex items-center bg-[#3e3e46] h-10 rounded-full px-4 shadow-inner border border-gray-400
                focus-within:border-white/90 transition-all duration-300">

        <div class="flex items-center mr-3 pr-3 space-x-2 border-r border-white/40">
            <i class="fas fa-search text-gray-300"></i>

            <span class="text-xs font-bold text-teal-400 bg-teal-900/50 px-2 py-0.5 rounded-full uppercase tracking-wider border border-teal-600/50 shadow-inner">
                AI
            </span>
        </div>

        <input type="text" placeholder="Search"
            class="bg-transparent border-none text-gray-100 text-sm w-full placeholder-gray-300
                   focus:outline-none focus:ring-0 focus:border-none"
            aria-label="AI Search">
    </div>
</div>


    @persist('navigation-elements')
    <div class="flex items-center space-x-5">
       <div class="dropdown relative inline-flex">
           
            <!-- Dropdown Menu -->
            <div
                class="dropdown-menu dropdown-open:opacity-100 hidden min-w-96 origin-top-right rounded-lg shadow-2xl bg-white dark:bg-[#2c3644] ring-1 ring-gray ring-opacity-5 z-50 p-4"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="dropdown-create-article"
            >
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">
                Create New Article
                </h3>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Article Title
                        </label>
                        <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="How to use the new feature..."
                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#374151] text-gray-900 dark:text-gray-100 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <div class="mb-4">
                        <label for="prompt" class="block text-sm font-medium text-indigo-600 dark:text-indigo-400">
                        AI Prompt (What do you want to write about?)
                        </label>
                        <textarea
                        id="prompt"
                        name="prompt"
                        rows="3"
                        placeholder="Generate an article about..."
                        class="mt-1 block w-full rounded-md border border-indigo-300 dark:border-indigo-600 bg-white dark:bg-[#374151] text-gray-900 dark:text-gray-100 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                        ></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-[#4b5563] transition duration-150">
                        Cancel
                        </button>
                        <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 shadow-md"
                        >
                        Start AI Draft
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <button
                onclick="window.location.href='{{ route('articles.index') }}'"
                class="flex items-center gap-2 px-3 py-1.5 rounded-md font-semibold text-white border border-white/40 hover:border-teal-400 hover:text-teal-300 hover:shadow-[0_0_10px_rgba(0,255,200,0.6)] transition duration-300"
            >
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>OPEN SITE</span>
            </button>

           <button
                onclick="window.location.href='{{ route('internal.articles') }}'"
                class="flex items-center gap-2 px-3 py-1.5 rounded-md font-semibold text-white
                    border border-white/40 hover:border-teal-400 hover:text-teal-300
                    hover:shadow-[0_0_10px_rgba(0,255,200,0.6)]
                    transition duration-300"
                >
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>INTERNAL ARTICLE</span>
            </button>

        <div class="flex items-center space-x-3 sm:space-x-4">

            <i class="fas fa-question-circle text-xl text-gray-300 cursor-pointer hover:text-white transition duration-200 hidden md:block" title="Help Documentation"></i>

            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:12] [--placement:bottom-end]">
                <button id="dropdown-scrollable" type="button"
                    class="dropdown-toggle text-gray-300 hover:text-white p-2 rounded-full hover:bg-[#374151] transition duration-200"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Notifications">
                    <div class="indicator relative cursor-pointer">
                        <span class="absolute -top-0 -right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-[#1f2937] animate-pulse"></span>
                        <i class="fas fa-bell text-xl"></i>
                    </div>
                </button>
                <div class="dropdown-menu dropdown-open:opacity-100 hidden min-w-80 bg-white dark:bg-[#374151] shadow-xl rounded-lg" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-scrollable">
                    <div class="dropdown-header justify-center bg-gray-50 dark:bg-[#2c3644] border-b border-gray-200 dark:border-[#374151]">
                        <h6 class="text-base font-semibold text-gray-800 dark:text-gray-100">Notifications</h6>
                    </div>
                    <div
                        class="overflow-y-auto overflow-x-auto text-gray-700 dark:text-gray-300 max-h-56">
                        <div class="dropdown-item flex items-start p-3 hover:bg-gray-100 dark:hover:bg-[#4b5563] transition duration-150 border-b border-gray-100 dark:border-[#2c3644]">
                            <div class="avatar avatar-away-bottom mr-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden">
                                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png" alt="avatar 1" />
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h6 class="truncate text-base font-medium text-gray-900 dark:text-gray-100">Charles Franklin</h6>
                                <small class="text-gray-500 dark:text-gray-400 block mt-0.5">Accepted your connection</small>
                            </div>
                        </div>
                        </div>
                    <a href="#" class="dropdown-footer justify-center gap-1 block p-2 text-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:bg-[#2c3644] dark:text-indigo-400 transition rounded-b-lg">
                        <span class="icon-[tabler--eye] size-4 inline-block align-middle"></span>
                        View all
                    </a>
                </div>
            </div>

            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:12] [--placement:bottom-end]">
                <button id="dropdown-avatar" type="button" class="dropdown-toggle flex items-center p-1 rounded-full hover:bg-[#374151] transition duration-200"
                    aria-haspopup="menu" aria-expanded="false" aria-label="User Menu">
                    <div class="avatar">
                        <div class="size-9 rounded-full ring-2 ring-indigo-500 bg-purple-700 flex items-center justify-center text-white font-bold text-base overflow-hidden">
                            @auth
                            <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/img/avatars/avatar5.jpeg') }}" alt="User Avatar" class="object-cover w-full h-full" />
                            @else
                            A
                            @endauth
                        </div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60 bg-white dark:bg-[#374151] shadow-xl rounded-lg" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-avatar">
                    <li class="dropdown-header gap-2 flex items-center p-3 border-b border-gray-200 dark:border-[#2c3644]">
                        <div class="avatar">
                            <div class="w-10 rounded-full overflow-hidden">
                                <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/img/avatars/avatar5.jpeg') }}" alt="User Avatar" />
                            </div>
                        </div>
                        <div>
                            <h6 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                @auth
                                    {{ auth()->user()->name }}
                                @endauth
                            </h6>
                            <small class="text-gray-500 dark:text-gray-400">
                                @auth
                                    @php
                                        $userRole = auth()->user()->roles->first();
                                        $roleName = $userRole ? str_replace('_', ' ', ucwords($userRole->name, '_')) : 'No Role';
                                    @endphp
                                    {{ $roleName }}
                                @endauth
                            </small>
                        </div>
                    </li>
                    <li class="p-1">
                        <a class="dropdown-item flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-[#4b5563] rounded-md transition duration-150" href="{{ route('profile') }}" wire:navigate>
                            <span class="icon-[tabler--user] w-5 h-5 mr-3"></span>
                            My Profile
                        </a>
                    </li>
                    <li class="p-1">
                        <a class="dropdown-item flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-[#4b5563] rounded-md transition duration-150" href="#">
                            <span class="icon-[tabler--settings] w-5 h-5 mr-3"></span>
                            Settings
                        </a>
                    </li>
                    @if(App\Services\RBACService::isSuperAdmin())
                    <li class="p-1">
                        <a class="dropdown-item flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-indigo-100 dark:hover:bg-[#4b5563] rounded-md transition duration-150" href="{{ route('admin.settings') }}" wire:navigate>
                            <span class="icon-[tabler--shield-check] w-5 h-5 mr-3"></span>
                            Admin Settings
                        </a>
                    </li>
                    @endif
                    <li class="dropdown-footer gap-2 p-3 border-t border-gray-200 dark:border-[#2c3644]">
                        <div x-data>
                            <form x-ref="logoutForm" action="{{ route('logout') }}" method="POST"
                            class="hidden">
                            @csrf
                            </form>
                            <a class="btn bg-red-600 hover:bg-red-700 active:bg-red-800 text-white w-full py-2 rounded-lg flex items-center justify-center font-medium transition duration-200" @click.prevent="$refs.logoutForm.submit()">
                            <span class="icon-[tabler--logout] w-5 h-5 mr-2"></span>
                            Sign out
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endpersist
</header>
