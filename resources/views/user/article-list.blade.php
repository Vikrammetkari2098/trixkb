@extends('layouts.app')
@section('content')



<body class="bg-gray-50 text-gray-800 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column - Articles -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Articles</h1>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-bold text-blue-600">188</span>
                            <span class="text-gray-600">Articles</span>
                        </div>
                    </div>

                    <div class="w-auto mx-auto">
                        <div x-data="{ active: 'recent' }" class="flex items-center justify-end p-3 border-b border-gray-200 bg-white shadow-sm">
                            <div class="flex space-x-1.5 sm:space-x-2">
                                <button
                                    @click="active = 'recent'"
                                    :class="active === 'recent' ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100'"
                                    class="px-3 sm:px-4 py-1.5 text-sm font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                    Recent
                                </button>

                                <button
                                    @click="active = 'popular'"
                                    :class="active === 'popular' ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100'"
                                    class="px-3 sm:px-4 py-1.5 text-sm font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                    Popular
                                </button>

                                <button
                                    @click="active = 'trending'"
                                    :class="active === 'trending' ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100'"
                                    class="px-3 sm:px-4 py-1.5 text-sm font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                    Trending
                                </button>
                            </div>

                            <button class="ml-3 flex items-center px-4 py-1.5 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <span>Tag Filter</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h4a1 1 0 011 1v4a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1z
                                           M17 7h.01M17 3h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Articles List -->
                <div class="space-y-6">

                    <!-- Article 1 -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:block flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=150&h=100&fit=crop&crop=center"
                                    alt="PHP Code"
                                    class="w-32 h-24 object-cover rounded-lg">
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=30&h=30&fit=crop&crop=face"
                                        alt="ash-jc-slim"
                                        class="w-6 h-6 rounded-full">
                                    <span class="font-semibold">ash-jc-slim</span>
                                    <span class="text-gray-400">•</span>
                                    <span>published on 24 Nov. 2025</span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-3">The Difference Between ?: and ?? in PHP</h3>

                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Introduction in PHP, I often see the ternary operator (?:) and null coalescing operator (??) being used interchangeably, but they have important differences...
                                </p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-6">
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-clock mr-1"></i> 5 min read
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-thumbs-up mr-1 text-blue-500"></i> 3
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-comment mr-1"></i> 245
                                        </span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="p-2 text-gray-400 hover:text-blue-500">
                                            <i class="far fa-bookmark"></i>
                                        </button>
                                        <button class="p-2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article 2 -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:block flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=150&h=100&fit=crop&crop=center"
                                    alt="Date Picker"
                                    class="w-32 h-24 object-cover rounded-lg">
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=30&h=30&fit=crop&crop=face"
                                        alt="ash-jc-slim"
                                        class="w-6 h-6 rounded-full">
                                    <span class="font-semibold">ash-jc-slim</span>
                                    <span class="text-gray-400">•</span>
                                    <span>published on 20 Nov. 2025</span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-3">Immutable and Mutable Dates in PHP</h3>

                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Introduction When working with dates in PHP, it's important to understand the difference between mutable and immutable date objects...
                                </p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-6">
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-clock mr-1"></i> 6 min read
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-thumbs-up mr-1 text-blue-500"></i> 3
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-comment mr-1"></i> 245
                                        </span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="p-2 text-gray-400 hover:text-blue-500">
                                            <i class="far fa-bookmark"></i>
                                        </button>
                                        <button class="p-2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article 3 -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start gap-4">
                            <div class="hidden sm:block flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1605379399642-870262d3d051?w=150&h=100&fit=crop&crop=center"
                                    alt="Laravel"
                                    class="w-32 h-24 object-cover rounded-lg">
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=30&h=30&fit=crop&crop=face"
                                        alt="ash-jc-slim"
                                        class="w-6 h-6 rounded-full">
                                    <span class="font-semibold">ash-jc-slim</span>
                                    <span class="text-gray-400">•</span>
                                    <span>published on 17 Nov. 2025</span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-3">Email Utilities for Laravel v1.0 Released!</h3>

                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    Introduction A common feature I often need to build for public-facing forms is to prevent users from submitting too many requests...
                                </p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-6">
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-clock mr-1"></i> 4 min read
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-thumbs-up mr-1 text-blue-500"></i> 3
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-comment mr-1"></i> 245
                                        </span>
                                    </div>
                                    <div class="flex gap-2">

                                        <button class="p-2 text-gray-400 hover:text-blue-500">
                                            <i class="far fa-bookmark"></i>
                                        </button>
                                        <button class="p-2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center justify-between mt-[6.5rem]">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-medium">1</span> to
                            <span class="font-medium">10</span> of
                            <span class="font-medium">188</span> results
                        </p>

                        <nav class="inline-flex items-center rounded-lg border border-gray-300 bg-white shadow-sm overflow-hidden">
                            <button class="px-3 py-2 text-gray-500 hover:bg-gray-100">‹</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">1</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">2</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">3</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">4</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">5</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">6</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">7</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">8</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">9</button>
                            <button class="px-3 py-2 text-sm hover:bg-gray-100">10</button>
                            <button class="px-3 py-2 text-gray-500 hover:bg-gray-100">›</button>
                        </nav>
                    </div>

                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-8 mt-[6.5rem]">

                <!-- Top Authors -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <i class="fas fa-crown text-yellow-500"></i>
                        Top Authors
                    </h2>

                    <div class="space-y-3">
                        <!-- Author 1 -->
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=40&h=40&fit=crop&crop=face"
                                    class="w-10 h-10 rounded-full ring-2 ring-yellow-400" />
                                <div>
                                    <p class="font-semibold text-gray-900">ash-jc-slim</p>
                                    <p class="text-xs text-gray-500">20 Articles</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-gray-100 text-gray-700 text-sm font-bold rounded-full flex items-center justify-center">1</span>
                                <i class="fa-solid fa-trophy text-yellow-500"></i>

                            </div>
                        </div>

                        <!-- Author 2 -->
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=40&h=40&fit=crop&crop=face"
                                    class="w-10 h-10 rounded-full ring-2 ring-gray-300" />
                                <div>
                                    <p class="font-semibold text-gray-900">mho</p>
                                    <p class="text-xs text-gray-500">2 Articles</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-gray-100 text-gray-700 text-sm font-bold rounded-full flex items-center justify-center">2</span>
                                <i class="fa-solid fa-trophy text-yellow-500"></i>

                            </div>
                        </div>

                        <!-- Author 3 -->
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=40&h=40&fit=crop&crop=face"
                                    class="w-10 h-10 rounded-full ring-2 ring-orange-300" />
                                <div>
                                    <p class="font-semibold text-gray-900">karandakwan82</p>
                                    <p class="text-xs text-gray-500">2 Articles</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-gray-100 text-gray-700 text-sm font-bold rounded-full flex items-center justify-center">3</span>
                                <i class="fa-solid fa-trophy text-yellow-500"></i>

                            </div>
                        </div>

                        <!-- Author 4 -->
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face"
                                    class="w-10 h-10 rounded-full" />
                                <div>
                                    <p class="font-semibold text-gray-900">itskufriokidions</p>
                                    <p class="text-xs text-gray-500">2 Articles</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-gray-100 text-gray-700 text-sm font-bold rounded-full flex items-center justify-center">4</span>
                                <i class="fa-solid fa-trophy text-yellow-500"></i>

                            </div>
                        </div>

                        <!-- Author 5 -->
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=40&h=40&fit=crop&crop=face"
                                    class="w-10 h-10 rounded-full" />
                                <div>
                                    <p class="font-semibold text-gray-900">joshcitre</p>
                                    <p class="text-xs text-gray-500">1 Article</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 bg-gray-100 text-gray-700 text-sm font-bold rounded-full flex items-center justify-center">5</span>
                                <i class="fa-solid fa-trophy text-yellow-500"></i>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Like buttons
            document.querySelectorAll('.fa-heart').forEach(heart => {
                heart.addEventListener('click', function() {
                    this.classList.toggle('far');
                    this.classList.toggle('fas');
                    this.classList.toggle('text-red-600');
                });
            });

            // Bookmark buttons
            document.querySelectorAll('.fa-bookmark').forEach(bookmark => {
                bookmark.addEventListener('click', function() {
                    this.classList.toggle('far');
                    this.classList.toggle('fas');
                    this.classList.toggle('text-blue-600');
                });
            });
        });
    </script>
</body>
@endsection
