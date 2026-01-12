<div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column - Articles -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Header Section -->
            <div class="mb-6 lg:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-gray-900 mb-2">
                            Latest Articles
                        </h1>
                        <div class="flex flex-wrap items-center gap-2 lg:gap-3">
                            <span class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $articles->total() }}
                            </span>
                            <span class="text-gray-600 text-sm lg:text-base">Articles Published</span>
                            <div class="hidden sm:block w-1 h-4 lg:h-5 bg-gray-300"></div>
                            <span class="hidden sm:block text-xs lg:text-sm text-gray-500">Updated daily</span>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div x-data="{ active: '{{ $filter }}' }" class="bg-white rounded-lg lg:rounded-xl p-1 border border-gray-200 shadow-sm inline-flex">
                        <button
                            @click="$wire.setFilter('recent'); active = 'recent'"
                            :class="active === 'recent' ?
                                'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-700 border border-blue-100 shadow-sm' :
                                'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
                            class="px-3 lg:px-4 py-2 text-xs lg:text-sm font-semibold rounded-md lg:rounded-lg transition-all duration-200 flex items-center gap-1.5 lg:gap-2"
                        >
                            <i class="fas fa-clock text-xs lg:text-sm"></i>
                            <span class="hidden xs:inline">Recent</span>
                        </button>

                        <button
                            @click="$wire.setFilter('popular'); active = 'popular'"
                            :class="active === 'popular' ?
                                'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-700 border border-blue-100 shadow-sm' :
                                'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
                            class="px-3 lg:px-4 py-2 text-xs lg:text-sm font-semibold rounded-md lg:rounded-lg transition-all duration-200 flex items-center gap-1.5 lg:gap-2"
                        >
                            <i class="fas fa-fire text-xs lg:text-sm"></i>
                            <span class="hidden xs:inline">Popular</span>
                        </button>

                        <button
                            @click="$wire.setFilter('trending'); active = 'trending'"
                            :class="active === 'trending' ?
                                'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-700 border border-blue-100 shadow-sm' :
                                'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
                            class="px-3 lg:px-4 py-2 text-xs lg:text-sm font-semibold rounded-md lg:rounded-lg transition-all duration-200 flex items-center gap-1.5 lg:gap-2"
                        >
                            <i class="fas fa-chart-line text-xs lg:text-sm"></i>
                            <span class="hidden xs:inline">Trending</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-6 lg:mb-8">
                <div class="relative flex items-center">
                    <i class="fas fa-search absolute left-4 text-gray-400 pointer-events-none"></i>
                    <input
                        wire:model.defer="search"
                        wire:keyup="resetPage"
                        type="text"
                        placeholder="Search articles..."
                        class="w-full pl-12 pr-24 py-3 lg:py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm lg:text-base"
                    />
                </div>
            </div>

            <!-- Articles List -->
            <div class="space-y-3 lg:space-y-4 relative">

                <!-- Loader Overlay -->
                <div wire:loading wire:target="page" class="absolute inset-0 bg-white/60 flex items-center justify-center z-50">
                    <div class="animate-spin rounded-full h-10 w-10 border-t-4 border-blue-600"></div>
                </div>

                @forelse($articles as $version)

                    <div wire:key="article-{{ $version->id }}" class="group bg-white border border-gray-200 rounded-xl p-3 lg:p-4 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex flex-col sm:flex-row gap-3 lg:gap-4">

                            <!-- Cover image -->
                            <div class="sm:w-20 lg:w-28 xl:w-32 flex-shrink-0">
                                <a href="{{ route('article.detail', $version->article->slug) }}">
                                    <div class="relative overflow-hidden rounded-lg aspect-[16/10]">
                                        <img
                                            src="{{ $version->article->article_image ? asset('storage/assets/article_image/' . basename($version->article->article_image)) : asset('images/default-article.jpg') }}"
                                            class="w-full h-full object-cover"
                                        />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

                                        @if($version->article->is_featured)
                                            <span class="absolute top-1.5 left-1.5 px-2 py-0.5 bg-white/90 text-[10px] font-semibold rounded-full">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <!-- Author -->
                                <div class="flex items-center gap-2 mb-2">
                                    <img
                                        src="{{ optional($version->article->author)->avatar ?: 'https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png' }}"
                                        class="w-8 h-8 rounded-full ring-1 ring-gray-200"
                                    />
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold truncate">
                                            {{ optional($version->article->author)->name ?? 'Unknown Author' }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ $version->article->created_at->format('M d, Y') }} • {{ $version->article->category->name ?? 'General' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Title -->
                                <h3 class="text-base lg:text-lg font-bold text-gray-900 mb-1.5 leading-snug">
                                    <a href="{{ route('article.detail', $version->article->slug) }}" class="hover:text-blue-600">
                                        {{ $version->article->title }}
                                    </a>
                                </h3>

                                <!-- Content excerpt -->
                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                    @php
                                        $content = $version->content;
                                        if (is_string($content)) {
                                            $decoded = json_decode($content, true);
                                            $excerpt = (json_last_error() === JSON_ERROR_NONE && isset($decoded['blocks']))
                                                ? editorjs_text($decoded)
                                                : $content;
                                        } elseif (is_array($content) && isset($content['blocks'])) {
                                            $excerpt = editorjs_text($content);
                                        } else {
                                            $excerpt = '';
                                        }
                                        echo Str::limit(strip_tags($excerpt), 140);
                                    @endphp
                                </p>

                                <!-- Tags -->
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    @foreach($version->article->tags->take(2) as $tag)
                                        <span class="px-2 py-0.5 bg-gray-100 text-xs rounded-md">
                                            #{{ $tag->name }}
                                        </span>
                                    @endforeach
                                    @if($version->article->tags->count() > 2)
                                        <span class="text-xs text-gray-500">
                                            +{{ $version->article->tags->count() - 2 }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Meta -->
                                <div class="flex items-center justify-between pt-2 text-xs text-gray-600">
                                    <a href="{{ route('article.detail', $version->article->slug) }}" class="text-blue-600 font-semibold hover:text-blue-700">
                                        Read →
                                    </a>
                                    <div class="flex gap-4">
                                        <span><i class="far fa-thumbs-up"></i> {{ $version->article->likes_count }}</span>
                                        <span><i class="far fa-comment"></i> {{ $version->article->comments_count }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border rounded-xl p-8 text-center">
                        <i class="fas fa-newspaper text-3xl text-gray-400 mb-4"></i>
                        <h3 class="font-semibold text-lg">No articles found</h3>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articles->links() }}
                </div>

            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:sticky lg:top-6 lg:self-start mt-28">

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4 lg:mb-6">
                    <h2 class="text-lg lg:text-xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-crown text-white"></i>
                        </div>
                        <span>Top Articles</span>
                    </h2>
                    <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        This Week
                    </span>
                </div>

                <!-- Articles -->
                <div class="space-y-3 lg:space-y-4">
                    @foreach($topArticles as $index => $article)
                
                        <div class="flex items-center gap-3 lg:gap-4 p-3 lg:p-4 rounded-xl border border-transparent hover:border-blue-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200">
                            <!-- Rank -->
                            <div class="w-6 h-6 lg:w-7 lg:h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0
                                {{ $index === 0 ? 'bg-gradient-to-r from-yellow-500 to-orange-500' : ($index === 1 ? 'bg-gradient-to-r from-gray-400 to-gray-600' : ($index === 2 ? 'bg-gradient-to-r from-orange-400 to-red-500' : 'bg-gradient-to-r from-blue-400 to-purple-500')) }}">
                                {{ $index + 1 }}
                            </div>

                            <!-- Article image -->
                            
                            <img
                                src="{{ $article->article_image ? asset('storage/assets/article_image/' . basename($article->article_image)) : 'https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png' }}"
                                class="w-12 h-12 lg:w-14 lg:h-14 rounded-lg object-cover flex-shrink-0"
                                onerror="this.src='https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png'"
                            />
                                    </a>
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                           

                                {{ $article->title }}
                                </a>
                                <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-heart text-red-400"></i>
                                        {{ $article->likes_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-comment text-blue-400"></i>
                                        {{ $article->comments_count ?? 0 }}
                                    </span>
                                </div>
                             
                            </div>

                            <!-- Arrow -->
                            <i class="fas fa-arrow-right text-blue-500 text-xs lg:text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <style>
        .max-w-7xl {
            max-width: 120rem;
        }
    </style>
</div>
