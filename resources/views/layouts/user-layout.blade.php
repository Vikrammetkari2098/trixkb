<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'DOCUMENT360')</title>

    {{-- TallStack UI --}}
    <tallstackui:script />

    {{-- Livewire --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 10">

    {{-- Enhanced Header --}}
    <header
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
    :class="scrolled ? 'bg-white shadow-lg' : 'bg-white/95 backdrop-blur-sm'"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
>

        <div class="mx-auto px-6 lg:px-8 max-w-full">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 text-2xl font-bold  bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text">
                        DOCUMENT360
                    </div>

                </div>

                {{-- Enhanced Desktop Nav --}}
                <nav
                    x-data="{ active: 'articles' }"
                    class="hidden lg:flex items-center space-x-1 text-lg font-medium"
                >
                    <a href="#" @click.prevent="active = 'features'"
                       :class="active === 'features' ?
                       'px-4 py-2 rounded-lg bg-gradient-to-r from-purple-50 to-blue-50 text-primary border border-purple-100 shadow-sm' :
                       'px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors'">
                        <i class="fas fa-star mr-2 text-sm"></i>Features
                    </a>
                    <a href="#" @click.prevent="active = 'pricing'"
                       :class="active === 'pricing' ?
                       'px-4 py-2 rounded-lg bg-gradient-to-r from-purple-50 to-blue-50 text-primary border border-purple-100 shadow-sm' :
                       'px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors'">
                        <i class="fas fa-tag mr-2 text-sm"></i>Pricing
                    </a>
                    <a href="#" @click.prevent="active = 'demo'"
                       :class="active === 'demo' ?
                       'px-4 py-2 rounded-lg bg-gradient-to-r from-purple-50 to-blue-50 text-primary border border-purple-100 shadow-sm' :
                       'px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors'">
                        <i class="fas fa-calendar-alt mr-2 text-sm"></i>Book a demo
                    </a>
                    <a href="#articles" @click="active = 'articles'"
                       :class="active === 'articles' ?
                       'px-4 py-2 rounded-lg bg-gradient-to-r from-purple-50 to-blue-50 text-primary border border-purple-100 shadow-sm' :
                       'px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors'">
                        <i class="fas fa-newspaper mr-2 text-sm"></i>Articles
                    </a>
                    <a href="#" @click.prevent="active = 'glossary'"
                       :class="active === 'glossary' ?
                       'px-4 py-2 rounded-lg bg-gradient-to-r from-purple-50 to-blue-50 text-primary border border-purple-100 shadow-sm' :
                       'px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-50 rounded-lg transition-colors'">
                        <i class="fas fa-book mr-2 text-sm"></i>Glossary
                    </a>

                    <div class="flex items-center space-x-3 ml-6 pl-6 border-l border-gray-200">
                        <div class="relative group">
                            <!-- Bell Icon -->
                            <button
                                class="relative text-gray-600 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition-colors"
                             >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM12 18a2 2 0 11-4 0h4z"></path>
                                </svg>

                                <!-- Red dot -->
                                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            </button>

                            <!-- Dropdown -->
                            <div class="absolute right-0 top-full mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 py-2
                                 opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                 transition-all duration-200 z-50"
                                  >
                               
                                <!-- Items -->
                                <a href="#"
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-newspaper mr-2 text-primary"></i>
                                    New article published
                                    
                                </a>

                                <a href="#"
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-edit mr-2 text-purple-500"></i>
                                    Article updated
                                    
                                </a>

                                <a href="#"
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                    Article approved
                                
                                </a>

                                
                            </div>
                        </div>


                            @php    
                                $user = Auth::user() ?? (object) ['name' => ''];
                                $initials = collect(explode(' ', $user->name))
                                                ->map(fn($w) => strtoupper(substr($w,0,1)))
                                                ->join('');
                            @endphp

                            <div class="relative group">
                                {{-- Avatar --}}
                                <div class="w-9 h-9 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 flex items-center justify-center font-semibold text-white text-sm cursor-pointer hover:shadow-lg transition-shadow">
                                    {{ $initials }}
                                </div>

                                {{-- Dropdown --}}
                                <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-user mr-2"></i>Profile
                                    </a>
                                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-cog mr-2"></i>Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>


                        <a href="#" @click.prevent="active = 'signup'"
                           class="ml-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg font-medium hover:shadow-lg hover:shadow-purple-200 transition-all duration-300 transform hover:-translate-y-0.5">
                            Get Started Free
                        </a>
                    </div>
                </nav>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = true" class="lg:hidden text-gray-600 hover:text-primary p-2 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Enhanced Hero Section --}}
    @if(request()->routeIs('articles.index') || request()->is('/') || request()->is('article-list'))
    <section class="relative overflow-hidden py-20 sm:py-28" style="background-image: linear-gradient(135deg, #A74E91 0%, #6A329D 100%);">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full translate-y-48 -translate-x-48"></div>

        <div class="relative mx-auto px-6 lg:px-8 max-w-6xl text-center">
            <div class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-6">
                ✨ New: AI-Powered Documentation
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                Welcome to
                <span class="relative">
                    <span class="relative z-10">Project Landing</span>
                    <span class="absolute bottom-2 left-0 w-full h-3 bg-yellow-400/30 -rotate-1 z-0"></span>
                </span>
            </h1>

            <p class="mt-6 text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                Comprehensive, AI-enhanced documentation platform to help your users get started with Project.
                Everything you need in one place.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-900 font-semibold rounded-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 group">
                    <i class="fas fa-book-open mr-3"></i>
                    Start Documentation
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 hover:border-white transition-all duration-300">
                    <i class="fas fa-play-circle mr-3"></i>
                    Watch Demo
                </a>
            </div>

            {{-- Enhanced Search Bar --}}
            <div class="mt-16 max-w-2xl mx-auto" x-data="{ search: '' }">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                    <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-200">
                        <div class="flex items-center px-6">
                            <span class="text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input
    type="search"
    placeholder="Search documentation, articles, guides..."
    x-model="search"
    class="flex-1 py-5 px-4 text-lg text-gray-800 focus:outline-none focus:border-0 placeholder-gray-400 rounded-none border-0"
    aria-label="Search documentation"
/>

                            <div class="flex items-center space-x-4">
                                <div class="hidden sm:block bg-gray-100 text-gray-700 text-sm font-mono py-2 px-3 rounded-lg whitespace-nowrap border border-gray-300">
                                    CTRL + K
                                </div>
                                <button class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg hover:shadow-lg transition-shadow">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-sm text-white/70 text-center">
                    Try searching for "getting started", "API reference", or "troubleshooting"
                </p>
            </div>
        </div>
    </section>
    @endif

    <!-- {{-- Stats Section --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">10K+</div>
                    <div class="text-gray-600 mt-2">Active Users</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">98%</div>
                    <div class="text-gray-600 mt-2">Satisfaction Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">24/7</div>
                    <div class="text-gray-600 mt-2">Support Available</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">5K+</div>
                    <div class="text-gray-600 mt-2">Docs Published</div>
                </div>
            </div>
        </div>
    </section> -->

    {{-- Main Content --}}
    <main class="min-h-screen">
        <x-toast />
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>
    {{-- Enhanced Footer --}}
    <footer class="bg-gray-900 text-white">
        <!-- Quick Links Section -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4">Get In Touch</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                        We're here to help you with any questions about our platform
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-800 p-10 rounded-2xl hover:bg-gray-700 transition-all duration-300 hover:-translate-y-2 group">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-orange-500 to-pink-500 rounded-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-comments text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4">Chat with us</h3>
                        <p class="text-gray-400 leading-relaxed">
                            Get instant answers from our AI assistant or connect with our support team in real-time.
                        </p>
                        <button class="mt-6 px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg font-medium transition-colors">
                            Start Chat <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>

                    <div class="bg-gray-800 p-10 rounded-2xl hover:bg-gray-700 transition-all duration-300 hover:-translate-y-2 group">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4">Email Support</h3>
                        <p class="text-gray-400 leading-relaxed">
                            Send us detailed queries and receive comprehensive solutions within 24 hours.
                        </p>
                        <div class="mt-6">
                            <a href="mailto:support@document360.com" class="text-blue-400 hover:text-blue-300 font-medium">
                                support@document360.com <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-800 p-10 rounded-2xl hover:bg-gray-700 transition-all duration-300 hover:-translate-y-2 group">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-phone-alt text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4">Telephone</h3>
                        <p class="text-gray-400 leading-relaxed">
                            Speak directly with our experts for personalized assistance and guidance.
                        </p>
                        <div class="mt-6">
                            <a href="tel:+11252250025" class="text-blue-400 hover:text-blue-300 font-medium">
                                +1 (125) 225-0025 <i class="fas fa-phone ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Footer Content -->
        <div class="border-t border-gray-800 pt-16 pb-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-6 gap-12">
                    <div class="col-span-2 lg:col-span-2">
                        <a href="#" class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent mb-6 block">
                            DOCUMENT360
                        </a>
                        <p class="text-gray-400 text-sm leading-relaxed pr-12">
                            The world's leading documentation platform that helps teams create, manage, and deliver beautiful documentation at scale.
                        </p>
                        <div class="mt-8">
                            <button class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg font-medium hover:shadow-lg transition-all">
                                <i class="fas fa-rocket mr-2"></i>Start Free Trial
                            </button>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-semibold text-white mb-6 text-lg">Products</h4>
                        <ul class="space-y-4 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Business</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Compare</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Features</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Mobile</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-semibold text-white mb-6 text-lg">Company</h4>
                        <ul class="space-y-4 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Blog</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Customers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Careers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors"><i class="fas fa-chevron-right text-xs mr-2"></i>Contact</a></li>
                        </ul>
                    </div>

                    <div class="lg:col-span-1">
                        <h4 class="font-semibold text-white mb-6 text-lg">Connect</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>

                        <div class="mt-8">
                            <h4 class="font-semibold text-white mb-4 text-lg">Subscribe</h4>
                            <div class="flex">
                                <input type="email" placeholder="Your email" class="flex-1 px-4 py-3 bg-gray-800 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button class="px-6 bg-gradient-to-r from-purple-600 to-blue-600 rounded-r-lg font-medium hover:opacity-90 transition-opacity">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t border-gray-800">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-gray-400 text-sm">
                            &copy; {{ date('Y') }} DOCUMENT360. All rights reserved.
                        </div>

                        <div class="flex space-x-8 mt-4 md:mt-0">
                            <div class="flex items-center space-x-2 text-gray-400">
                                <i class="fas fa-phone text-sm"></i>
                                <span>+1 (125) 225-0025</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-400">
                                <i class="fas fa-envelope text-sm"></i>
                                <span>support@document360.com</span>
                            </div>
                        </div>

                        <div class="flex space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">GDPR</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Sitemap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button x-data="{ show: false }"
            @scroll.window="show = window.scrollY > 500"
            x-show="show"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 z-40 flex items-center justify-center">
        <i class="fas fa-arrow-up"></i>
    </button>

<!-- External Resources -->


<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Poppins', 'system-ui', '-apple-system', 'sans-serif'],
                },
                colors: {
                    'dark-gray': '#374151',
                    'custom-purple': '#6842a2',
                },
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                },
                keyframes: {
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-20px)' },
                    }
                }
            }
        }
    }
</script>

<style>
    :root {
        --color-primary: #6366f1;
        --color-secondary: #f8fafc;
    }

    .bg-primary { background-color: var(--color-primary); }
    .text-primary { color: var(--color-primary); }
    .border-primary { border-color: var(--color-primary); }

    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #a855f7, #6366f1);
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #9333ea, #4f46e5);
    }

    /* Gradient text animation */
    .gradient-text {
        background: linear-gradient(45deg, #a855f7, #6366f1, #3b82f6);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: gradient 3s ease infinite;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

    @livewireScripts
</body>
</html>
