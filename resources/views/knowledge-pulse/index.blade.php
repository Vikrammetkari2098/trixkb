@extends('layouts.app')
@section('content')

<div class="min-h-screen pt-10 bg-gray-50">
    <div class="px-10">
        <header class="mb-8">
            <h1 class="text-3xl font-bold flex items-center text-gray-800">
                Knowledge pulse
                <div class="ml-4 space-x-4 text-sm text-blue-600 font-medium">
                    <div class="flex items-center gap-6 text-blue-600 text-sm font-medium">

                        <a href="#" class="btn btn-soft btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="#3b82f6"
                                 stroke-width="1.5"
                                 class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      fill="#3b82f6"
                                      d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                            </svg>
                            How to
                        </a>

                        <a href="#" class="btn btn-soft btn-primary">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            Docs
                        </a>

                    </div>
                </div>
            </h1>
            <p class="text-gray-600 mt-2 text-lg">
                Knowledge pulse is a unified dashboard that brings together all project-level scans.
                It provides a single place to review scan reports and explore insights across your documentation.
            </p>
        </header>

        <div class="bg-white rounded-xl shadow-2xl p-8 border border-gray-100">

            <div class="flex justify-between items-start">

                <div class="flex items-start flex-grow">
                    <div class="mr-6 m-6 flex-shrink-0">
                        <img src="{{ asset('image/knowledge.png') }}"
                             class="w-24 h-24 object-contain">
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold mb-2 text-gray-900">
                            Duplicate content detection
                        </h2>

                    </div>

                </div>
                <div class="flex space-x-2 items-center">
                    <button class="animated-gradient-btn flex items-center gap-2 px-6 py-2 rounded-full
                        text-black font-bold text-lg shadow-md hover:shadow-lg transition">
                        <span class="fa-eddy-icon fa-kit fal text-pink-600"></span>
                        Scan again
                    </button>
                    <button class="bg-gray-200 text-white hover:bg-gray-300 px-3 py-1 rounded-md text-sm font-semibold flex items-center space-x-1 transition duration-150 shadow-sm">
                        <span>View report</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </div>
            {{-- METRICS SECTION --}}
            <div class="grid grid-cols-4 gap-8 -mt-20 pl-8 ml-28">
                <div>
                    <p class="text-sm text-gray-500 mb-0">Articles analyzed</p>
                    <p class="text-2xl font-bold text-gray-900">2</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Articles with impact</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Duplicate text blocks</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-0">Snippet suggestions</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
            {{-- FOOTER ROW --}}
            <div class="flex space-x-6 mt-8 text-sm text-gray-600">
                <p>Last scan: <span class="font-semibold text-gray-800">20 hours ago</span></p>
                <p>Next scan scheduled at: <span class="font-semibold text-gray-800">Jan 01, 2026</span></p>
            </div>
        </div>
    </div>
</div>
<style>
   .animated-gradient-btn {
        background: linear-gradient(
            90deg,
            #facc15,  /* yellow */
            #f97316,  /* orange */
            #ec4899,  /* pink */
            #3b82f6,  /* blue */
            #facc15   /* yellow again to loop smoothly */
        );
        background-size: 400% 400%;
        animation: gradientFlow 5s ease infinite;
    }
    @keyframes gradientFlow {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

</style>
@endsection
