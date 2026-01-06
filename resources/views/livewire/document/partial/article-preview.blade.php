<div x-data="{ open: @entangle('isOpen') }" 
     x-show="open" 
     x-cloak 
     style="display: none;" 
        class="fixed inset-0 z-50 overflow-y-auto bg-white"
     role="dialog" 
     aria-modal="true">

    <div class="min-h-screen bg-gray-50" x-data="{
        sidebarOpen: {
            guides: true,
            category: true
        },
        searchQuery: '',
        isHelpful: null,
        showFeedback: false
    }">
        <div class="bg-gray-100 border-b border-gray-200 sticky top-0 z-20">
            <div class="max-w-auto mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center text-sm text-gray-500">
                <nav class="flex items-center space-x-1.5">
                    <button wire:click="close" class="hover:text-red-600 flex items-center font-bold text-gray-700 mr-4">
                        <span class="material-symbols-rounded text-xl mr-1">close</span>
                    </button>
                    <span class="text-gray-300">|</span>
                    <a href="#" class="hover:text-gray-700 flex items-center ml-4">
                        <span class="material-symbols-rounded text-xl">home</span>
                    </a>
                    <span class="text-gray-400">/</span>
                    <a href="#" class="text-gray-500 hover:text-gray-700">Documentation</a>
                    <span class="text-gray-400">/</span>
                    <a href="#" class="text-gray-500 hover:text-gray-700">Getting started guides</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800">{{ $title ?: 'Untitled Article' }}</span>
                </nav>

                <div class="hidden lg:flex relative items-center">
                    <input
                        type="text"
                        x-model="searchQuery"
                        placeholder="Search"
                        class="pl-3 pr-16 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 w-64"
                        @keydown.ctrl.k.prevent="searchQuery = ''"
                    >
                    <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3 text-xs text-gray-400 font-medium">
                        CTRL+K
                    </span>
                </div>
            </div>
        </div>

        <main class="max-w-auto mx-auto px-4 sm:px-6 lg:px-8 flex">
            <aside class="w-64 xl:w-72 flex-shrink-0 border-r border-gray-200 py-6 pr-6 h-[calc(100vh-80px)] sticky top-14 overflow-y-auto sidebar-scroll hidden lg:block">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">EXPLORE ARTICLES</h3>

                <div class="mb-4">
                    <button
                        @click="sidebarOpen.guides = !sidebarOpen.guides"
                        class="flex justify-between items-center w-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900"
                    >
                        Getting started guides
                        <svg
                            class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-90': sidebarOpen.guides }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div
                        x-show="sidebarOpen.guides"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="space-y-1 pl-4 border-l border-gray-200 mt-2"
                    >
                        <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-100 transition-colors duration-150">
                            Product Installation Steps
                        </a>
                        <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-100 transition-colors duration-150">
                            Initial Setup Guide
                        </a>
                        <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-100 transition-colors duration-150">
                            Configuration Tutorial
                        </a>
                    </div>
                </div>

                <div>
                    <button
                        @click="sidebarOpen.category = !sidebarOpen.category"
                        class="flex justify-between items-center w-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900"
                    >
                        test category
                        <svg
                            class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-90': sidebarOpen.category }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div
                        x-show="sidebarOpen.category"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="space-y-1 pl-4 border-l border-gray-200 mt-2"
                    >
                        <a href="#" class="sidebar-item active block px-3 py-2 text-sm rounded-md font-medium bg-blue-50 text-blue-700">
                            Testing Article dfdfdfdf
                        </a>
                        <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-100 transition-colors duration-150">
                            Advanced Testing
                        </a>
                        <a href="#" class="sidebar-item block px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-100 transition-colors duration-150">
                            Troubleshooting Guide
                        </a>
                    </div>
                </div>
            </aside>

            <article class="flex-1 min-w-0 py-8 lg:pl-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $title ?: 'Untitled Article' }}</h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                    <p>Updated on {{ now()->format('M d, Y') }}</p>
                    <span class="h-1 w-1 bg-gray-300 rounded-full hidden sm:inline"></span>
                    <p>Published on {{ now()->format('M d, Y') }}</p>
                    <div class="flex items-center gap-1 sm:ml-4">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>1 minute(s) read</p>
                        <span class="h-1 w-1 bg-gray-300 rounded-full hidden sm:inline"></span>
                        <p class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9c2.535 2.536 2.535 6.645 0 9.18" />
                            </svg>
                            Listen
                        </p>
                    </div>
                </div>

                <div class="flex justify-between items-center border-t border-b border-gray-200 py-3 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-300 text-sm flex items-center justify-center font-semibold border-2 border-gray-300">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Current User' }}</p>
                            <p class="text-xs text-gray-500">Author</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center space-x-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-150">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>EDIT ARTICLE</span>
                        </button>
                        <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors duration-150">
                            <span class="material-symbols-rounded">share</span>
                        </button>
                        <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors duration-150">
                            <span class="material-symbols-rounded">more_vert</span>
                        </button>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-700">
                    @if(!empty($content['blocks']) && is_array($content['blocks']))
                        @foreach($content['blocks'] as $block)
                            @php 
                                $type = $block['type'] ?? '';
                                $data = $block['data'] ?? [];
                            @endphp

                            @if($type === 'header')
                                <h{{ $data['level'] ?? 2 }} class="font-bold text-gray-900 mt-8 mb-4">
                                    {!! $data['text'] ?? '' !!}
                                </h{{ $data['level'] ?? 2 }}>

                            @elseif($type === 'paragraph')
                                <p class="mb-4 leading-relaxed">
                                    {!! $data['text'] ?? '' !!}
                                </p>

                            @elseif($type === 'list')
                                @php $tag = ($data['style'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul'; @endphp
                                <{{ $tag }} class="pl-5 mb-4 space-y-2 {{ $tag === 'ol' ? 'list-decimal' : 'list-disc' }}">
                                    @foreach($data['items'] ?? [] as $item)
                                        <li>{!! is_array($item) ? ($item['content'] ?? '') : $item !!}</li>
                                    @endforeach
                                </{{ $tag }}>

                            @elseif($type === 'image')
                                <div class="my-6">
                                    <img src="{{ $data['file']['url'] ?? '' }}" class="rounded-lg w-full h-auto border border-gray-100">
                                    @if(!empty($data['caption']))
                                        <p class="text-center text-sm text-gray-500 mt-2 italic">{!! $data['caption'] !!}</p>
                                    @endif
                                </div>

                            @elseif($type === 'code')
                                <div class="my-6 bg-gray-900 rounded-lg p-5 overflow-x-auto">
                                    <pre><code class="font-mono text-sm text-green-400">{!! htmlspecialchars($data['code'] ?? '') !!}</code></pre>
                                </div>

                            @elseif($type === 'warning' || $type === 'quote')
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 my-6 rounded-r">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <span class="material-symbols-rounded text-blue-500">lightbulb</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                {!! $data['message'] ?? ($data['text'] ?? '') !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-10 border-2 border-dashed rounded-lg">
                            <p class="text-gray-400">Content is empty. Please write something and save.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-12 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <p class="text-lg font-medium text-gray-700 mb-4">Was this article helpful?</p>
                    <div class="flex flex-wrap gap-4">
                        <button
                            @click="isHelpful = true; showFeedback = true"
                            :class="isHelpful === true ? 'bg-green-100 border-green-600 text-green-700' : 'border-green-500 text-green-700 hover:bg-green-50'"
                            class="flex items-center space-x-2 px-6 py-2 rounded-lg border bg-white font-semibold transition-all duration-150"
                        >
                            <span class="material-symbols-rounded">thumb_up</span>
                            <span>Yes</span>
                        </button>
                        <button
                            @click="isHelpful = false; showFeedback = true"
                            :class="isHelpful === false ? 'bg-red-100 border-red-600 text-red-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'"
                            class="flex items-center space-x-2 px-6 py-2 rounded-lg border bg-white font-semibold transition-all duration-150"
                        >
                            <span class="material-symbols-rounded">thumb_down</span>
                            <span>No</span>
                        </button>
                    </div>

                    <div x-show="showFeedback" x-transition:enter="transition ease-out duration-300" class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-3">Thanks for your feedback! Can you tell us more?</p>
                        <textarea
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                            rows="3"
                            placeholder="What could be improved? (Optional)"
                        ></textarea>
                        <div class="flex justify-end mt-3">
                            <button
                                @click="showFeedback = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-150"
                            >
                                Cancel
                            </button>
                            <button
                                class="ml-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-150"
                            >
                                Submit Feedback
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#" class="inline-flex items-center p-4 bg-gray-100 rounded-lg text-gray-700 hover:bg-gray-200 transition-all duration-150">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Previous article</p>
                            <p class="font-medium">Initial Setup Guide</p>
                        </div>
                    </a>

                    <a href="#" class="inline-flex items-center p-4 bg-gray-100 rounded-lg text-gray-700 hover:bg-gray-200 transition-all duration-150 justify-end text-right md:text-left md:flex-row-reverse">
                        <svg class="w-5 h-5 ml-3 md:ml-0 md:mr-3 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Next article</p>
                            <p class="font-medium">Advanced Configuration</p>
                        </div>
                    </a>
                </div>
            </article>
        </main>

        <button
            @click="$dispatch('toggle-sidebar')"
            class="lg:hidden fixed bottom-4 right-4 z-50 p-3 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-colors duration-150"
        >
            <span class="material-symbols-rounded">menu</span>
        </button>
    </div>
</div>