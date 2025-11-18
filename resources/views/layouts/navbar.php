<header class="flex items-center justify-between h-[40px] px-4 bg-[black] text-gray-200 shadow-md">

    {{-- Left Side: Knowledge Base, Version, and Mobile Menu (Modified to fit new structure) --}}
    <div class="flex items-center space-x-3">

        {{-- Mobile Sidebar Toggle (Adapted from old navbar, using a generic icon here) --}}
        <button type="button" class="text-gray-200 sm:hidden hover:text-white"
            aria-haspopup="dialog" aria-expanded="false" aria-controls="with-navbar-sidebar" data-overlay="#with-navbar-sidebar">
            <i class="fas fa-bars text-lg"></i>
        </button>
        {{-- Logo/Branding --}}
        <a class="link no-underline flex items-center" href="#">
            <img src="{{ asset('media/DE.jpeg') }}" alt="TRIXCRM Logo" class="h-8">
        </a>
        <div class="vertical-separator hidden sm:block"></div>

        {{-- "Knowledge Base" and "v1" (From new structure) --}}
        <div class="hidden sm:flex items-center space-x-7">
            {{-- Original was <i class="fas fa-magic text-xl text-[#8a2be2]"></i> --}}
            <span class="font-semibold text-white">Dyn Edge</span>
        </div>
        <div class="vertical-separator hidden sm:block"></div>

        <div class="hidden sm:flex items-center text-sm space-x-1">
            <span class="flag-icon-container">
                <span class="flag-icon flag-icon-us rounded-full" style="border-radious: 15px;"></span>
            </span>
            <span class="font-medium">v1</span>
            <i class="fas fa-caret-down text-gray-400 text-xs ml-1"></i>
        </div>
        <div class="vertical-separator hidden sm:block"></div>
    </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-md flex items-center">
            Create
            <i class="fa-solid fa-chevron-down ml-2"></i>
        </button>

    {{-- Center: Search Bar (From new structure) --}}
    <div class="flex-grow max-w-xl px-2 sm:px-10">
        <div class="flex items-center bg-[#43434b] h-[28px] rounded-md px-3">
            <i class="fas fa-search text-gray-400 mr-2"></i>
            <input type="text" placeholder="Search"
                class="bg-transparent border-none text-gray-200 text-sm w-full focus:outline-none placeholder-gray-400">
        </div>
    </div>

    {{-- Right Side: Trial Button, Open Site, HELP, Notifications, User Menu (Logic from old navbar, styling from new) --}}
    @persist('navigation-elements')
    <div class="flex items-center space-x-4">

        {{-- Trial Button --}}
        <div class="hidden md:flex bg-yellow-400 text-black font-semibold rounded-md shadow px-2 py-1 items-center">
            <span class="main-text">TRIAL ENDS IN 10 DAYS</span>
            <span class="arrow-part ml-1">
                <i class="fas fa-caret-down text-sm"></i>
            </span>
        </div>

        {{-- Open Site Button (Styled to fit the dark theme) --}}
        <button class="open-site-button text-gray-200 hover:text-white bg-[#43434b] hover:bg-[#5a5a63] font-bold h-[32px] px-3 rounded-md text-xs cursor-pointer hidden lg:flex items-center space-x-1">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>OPEN SITE</span>
        </button>

        <div class="flex items-center space-x-4">
            {{-- Help Link (From new structure) --}}
            <span class="text-sm font-semibold cursor-pointer hidden lg:block">HELP</span>
            <i class="fas fa-question-circle text-lg cursor-pointer hidden md:block"></i>

            {{-- Notifications Dropdown (Logic from old navbar) --}}
            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                <button id="dropdown-scrollable" type="button"
                    class="dropdown-toggle text-gray-200 hover:text-white"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <div class="indicator relative cursor-pointer">
                        {{-- Indicator logic from old navbar --}}
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-600 rounded-full border border-[#313136]"></span>
                        <i class="fas fa-bell text-lg"></i> {{-- Icon from new structure --}}
                    </div>
                </button>
                {{-- Notifications Dropdown Menu (Full logic copied from old navbar, NOTE: requires DaisyUI/FlyonUI styles/JS to function correctly) --}}
                <div class="dropdown-menu dropdown-open:opacity-100 hidden" role="menu" aria-orientation="vertical"
                    aria-labelledby="dropdown-scrollable">
                    <div class="dropdown-header justify-center">
                        <h6 class="text-base-content text-base">Notifications</h6>
                    </div>
                    <div
                        class="overflow-y-auto overflow-x-auto text-base-content/80 max-h-56 overflow-auto max-md:max-w-60">
                        <div class="dropdown-item">
                            <div class="avatar avatar-away-bottom">
                                <div class="w-10 rounded-full">
                                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png"
                                        alt="avatar 1" />
                                </div>
                            </div>
                            <div class="w-60">
                                <h6 class="truncate text-base">Charles Franklin</h6>
                                <small class="text-base-content/50 truncate">Accepted your connection</small>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <div class="avatar">
                                <div class="w-10 rounded-full">
                                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-2.png"
                                        alt="avatar 2" />
                                </div>
                            </div>
                            <div class="w-60">
                                <h6 class="truncate text-base">Martian added moved Charts & Maps task to the done
                                    board.
                                </h6>
                                <small class="text-base-content/50 truncate">Today 10:00 AM</small>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <div class="avatar avatar-online-bottom">
                                <div class="w-10 rounded-full">
                                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-8.png"
                                        alt="avatar 8" />
                                </div>
                            </div>
                            <div class="w-60">
                                <h6 class="truncate text-base">New Message</h6>
                                <small class="text-base-content/50 truncate">You have new message from
                                    Natalie</small>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <div class="avatar avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-10 rounded-full p-2">
                                    <span class="icon-[tabler--user] size-full"></span>
                                </div>
                            </div>
                            <div class="w-60">
                                <h6 class="truncate text-base">Application has been approved 🚀</h6>
                                <small class="text-base-content/50 text-wrap">Your ABC project application has been
                                    approved.</small>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <div class="avatar">
                                <div class="w-10 rounded-full">
                                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-10.png"
                                        alt="avatar 10" />
                                </div>
                            </div>
                            <div class="w-60">
                                <h6 class="truncate text-base">New message from Jane</h6>
                                <small class="text-base-content/50 text-wrap">Your have new message from
                                    Jane</small>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <div class="avatar">
                                <div class="w-10 rounded-full">
                                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-3.png"
                                        alt="avatar 3" />
                                </div>
                            </div>
                            <div class="w-60">
                                <h6 class="truncate text-base">Barry Commented on App review task.</h6>
                                <small class="text-base-content/50 truncate">Today 8:32 AM</small>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="dropdown-footer justify-center gap-1">
                        <span class="icon-[tabler--eye] size-4"></span>
                        View all
                    </a>
                </div>
            </div>

            {{-- User Profile Dropdown (Logic from old navbar) --}}
            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                <button id="dropdown-avatar" type="button" class="dropdown-toggle flex items-center hover:bg-[#2c2c31] rounded-full p-1"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <div class="avatar">
                        <div class="size-7 rounded-full ring-1 ring-gray-600 bg-purple-700 flex items-center justify-center text-white font-bold text-sm">
                            @auth
                            {{-- This logic is only for placeholder 'A' in new design, using user image instead --}}
                            <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/img/avatars/avatar5.jpeg') }}" alt="User Avatar" />
                            @else
                            A
                            @endauth
                        </div>
                    </div>
                </button>
                {{-- User Dropdown Menu (Full logic copied from old navbar, NOTE: requires DaisyUI/FlyonUI styles/JS to function correctly) --}}
                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-avatar">
                    <li class="dropdown-header gap-2">
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/img/avatars/avatar5.jpeg') }}" alt="User Avatar" />
                            </div>
                        </div>
                        <div>
                            <h6 class="text-base-content text-base font-semibold">
                                @auth
                                    {{ auth()->user()->name }}
                                @endauth
                            </h6>
                            <small class="text-base-content/50">
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
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}" wire:navigate>
                            <span class="icon-[tabler--user]"></span>
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="icon-[tabler--settings]"></span>
                            Settings
                        </a>
                    </li>
                    @if(App\Services\RBACService::isSuperAdmin())
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings') }}" wire:navigate>
                            <span class="icon-[tabler--shield-check]"></span>
                            Admin Settings
                        </a>
                    </li>
                    @endif
                    <li class="dropdown-footer gap-2">
                        <div x-data>
                            <form x-ref="logoutForm" action="{{ route('logout') }}" method="POST"
                            class="hidden">
                            @csrf
                            </form>
                            <a class="btn btn-error btn-soft btn-block" @click.prevent="$refs.logoutForm.submit()">
                            <span class="icon-[tabler--logout]"></span>
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
