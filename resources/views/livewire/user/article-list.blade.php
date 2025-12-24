<div class="w-full">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 xl:gap-8">
        <!-- Left Column - Articles -->
        <div class="lg:col-span-2">
            <!-- Header Section -->
            <div class="mb-6 lg:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl xl:text-4xl font-bold text-gray-900 mb-2">Latest Articles</h1>
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

            <!-- Search Bar (Optional - Add if needed) -->
            <div class="mb-6 lg:mb-8">
            <div class="relative flex items-center">
                <!-- Search Icon -->
                <i class="fas fa-search absolute left-4 text-gray-400 pointer-events-none"></i>

                <!-- Input -->
                <input
                    wire:model.defer="search"
                    wire:keyup="resetPage"

                    type="text"
                    placeholder="Search articles..."
                    class="w-full pl-12 pr-24 py-3 lg:py-3.5 bg-white border border-gray-300 rounded-xl
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none
                        text-sm lg:text-base"
                />

                
            </div>
        </div>


            <!-- Articles List -->
            <div class="space-y-4 lg:space-y-6">
                @forelse($articles as $version)
                <div
                    wire:key="article-{{ $version->id }}"
                    class="group bg-white border border-gray-200 rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-sm hover:shadow-md transition-all duration-300"
                >
                    <div class="flex flex-col sm:flex-row gap-4 lg:gap-6">
                        <!-- Cover image -->
                        <div class="sm:w-32 lg:w-40 xl:w-48 flex-shrink-0">
                            <a href="{{ route('article.detail', $version->article->slug) }}" class="block">
                                <div class="relative overflow-hidden rounded-lg lg:rounded-xl aspect-[4/3] group-hover:scale-[1.02] transition-transform duration-300">
                                    <img
                                        src="{{ $version->article->article_image ? asset('storage/assets/article_image/' . basename($version->article->article_image)) : asset('images/default-article.jpg') }}"
                                        alt="{{ $version->article->title }}"
                                        class="w-full h-full object-cover"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                    @if($version->article->is_featured)
                                    <div class="absolute top-2 lg:top-3 left-2 lg:left-3">
                                        <span class="px-2 lg:px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-semibold rounded-full text-gray-800">
                                            Featured
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <!-- Author + date -->
                            <div class="flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                                <div class="relative flex-shrink-0">
                                    <img
                                        src="{{ optional($version->article->author)->avatar ?: 'https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png' }}"
                                        alt="{{ optional($version->article->author)->name }}"
                                        class="w-8 h-8 lg:w-10 lg:h-10 rounded-full ring-1 ring-gray-200"
                                        onerror="this.src='https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png'"
                                    />
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm lg:text-base truncate">
                                        {{ optional($version->article->author)->name ?? 'Unknown Author' }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-1 lg:gap-2 text-xs lg:text-sm text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="far fa-calendar text-xs"></i>
                                            Published On
                                            {{ $version->article->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-gray-300">•</span>
                                        <span>{{ $version->article->category->name ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg lg:text-xl xl:text-2xl font-bold text-gray-900 mb-2 lg:mb-3 leading-tight group-hover:text-blue-600 transition-colors duration-200">
                                <a href="{{ route('article.detail', $version->article->slug) }}" class="hover:text-blue-600">
                                    {{ $version->article->title }}
                                </a>
                            </h3>

                            <!-- Content Preview -->
                            <p class="text-gray-600 mb-3 lg:mb-4 leading-relaxed text-sm lg:text-base line-clamp-2 lg:line-clamp-3">
                                @php
                                    $content = $version->content;

                                    // If content is a string, try to decode it as JSON
                                    if (is_string($content)) {
                                        $decoded = json_decode($content, true);

                                        // Check if decoding was successful and has the expected structure
                                        if (json_last_error() === JSON_ERROR_NONE &&
                                            is_array($decoded) &&
                                            isset($decoded['blocks'])) {
                                            $excerpt = editorjs_text($decoded);
                                        } else {
                                            // If not valid EditorJS JSON, use the string as-is
                                            $excerpt = $content;
                                        }
                                    }
                                    // If content is already an array
                                    elseif (is_array($content) && isset($content['blocks'])) {
                                        $excerpt = editorjs_text($content);
                                    }
                                    // If content is null or empty
                                    else {
                                        $excerpt = '';
                                    }

                                    echo Str::limit(strip_tags($excerpt), 150);
                                @endphp
                            </p>

                            <!-- Tags -->
                            <div class="flex flex-wrap gap-1.5 lg:gap-2 mb-4 lg:mb-5">
                                @foreach($version->article->tags->take(2) as $tag)
                                <a href="#" class="px-2 lg:px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-md lg:rounded-lg transition-colors">
                                    #{{ $tag->name }}
                                </a>
                                @endforeach
                                @if($version->article->tags->count() > 2)
                                <span class="px-2 lg:px-3 py-1 text-gray-500 text-xs font-medium">
                                    +{{ $version->article->tags->count() - 2 }}
                                </span>
                                @endif
                            </div>

                            <!-- Meta Information -->
                            <div class="flex flex-col xs:flex-row xs:items-center justify-between gap-3 pt-3 lg:pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-4 lg:gap-6">
                                    <div class="flex items-center gap-1.5 text-gray-600 text-xs lg:text-sm">
                                        <i class="far fa-clock text-gray-400"></i>
                                        <span class="font-medium">{{ $version->read_time ?? 5 }} min</span>
                                    </div>

                                    <div class="flex items-center gap-3 lg:gap-4">
                                        <div class="flex items-center gap-1.5 text-gray-600 hover:text-blue-600 transition-colors cursor-pointer text-xs lg:text-sm">
                                            <i class="far fa-thumbs-up"></i>
                                            <span class="font-medium">{{ $version->likes ?? 0 }}</span>
                                        </div>

                                        <div class="flex items-center gap-1.5 text-gray-600 hover:text-green-600 transition-colors cursor-pointer text-xs lg:text-sm">
                                            <i class="far fa-comment"></i>
                                            <span class="font-medium">{{ $version->comments_count ?? 0 }}</span>
                                        </div>

                                        <div class="flex items-center gap-1.5 text-gray-600 hover:text-purple-600 transition-colors cursor-pointer text-xs lg:text-sm">
                                            <i class="far fa-eye"></i>
                                            <span class="font-medium">{{ $version->views ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 lg:gap-3">
                                    <button class="p-1.5 lg:p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition-all duration-200 group/bookmark">
                                        <i class="far fa-bookmark group-hover/bookmark:fa-solid text-sm lg:text-base"></i>
                                    </button>
                                    <a href="{{ route('article.detail', $version->article->slug) }}"
                                       class="px-3 lg:px-4 py-1.5 lg:py-2 bg-gradient-to-r from-blue-50 to-purple-50 text-blue-700 font-semibold text-sm lg:text-base rounded-lg hover:shadow-sm transition-all duration-200 flex items-center gap-1.5 lg:gap-2 group/readmore">
                                        Read
                                        <i class="fas fa-arrow-right text-xs lg:text-sm group-hover/readmore:translate-x-0.5 lg:group-hover/readmore:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Empty State -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 lg:p-12 text-center">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-newspaper text-2xl lg:text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg lg:text-xl font-semibold text-gray-900 mb-2">No articles found</h3>
                    <p class="text-gray-600 mb-6 text-sm lg:text-base">
                        @if($search)
                            No results for "{{ $search }}". Try different keywords.
                        @else
                            There are no published articles yet.
                        @endif
                    </p>
                    @if($search)
                    <button wire:click="$set('search', '')" class="px-4 lg:px-6 py-2 lg:py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:shadow-md transition-all duration-200 text-sm lg:text-base">
                        Clear Search
                    </button>
                    @endif
                </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-6 lg:mt-8">
                    {{ $articles->links() }}
                </div>

            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:sticky lg:top-6 lg:self-start">
            <!-- Top Authors Card -->
            <div class="bg-white border border-gray-200 rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-sm mb-6 lg:mb-8">
                <div class="flex items-center justify-between mb-4 lg:mb-6">
                    <h2 class="text-lg lg:text-xl font-bold text-gray-900 flex items-center gap-2 lg:gap-3">
                        <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-crown text-white text-sm lg:text-base"></i>
                        </div>
                        <span>Top Authors</span>
                    </h2>
                    <div class="text-xs text-gray-500 bg-gray-100 px-2 lg:px-3 py-1 rounded-full">
                        This Week
                    </div>
                </div>

                <div class="space-y-3 lg:space-y-4">
                    @foreach($topAuthors as $index => $author)
                    <a href="#" class="group block">
                        <div class="flex items-center justify-between p-3 lg:p-4 rounded-lg lg:rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 border border-transparent hover:border-blue-100">
                            <div class="flex items-center gap-3 lg:gap-4">
                                <div class="relative flex-shrink-0">
                                    @php
                                        $avatars = [
                                            'https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png',
                                            'https://cdn.flyonui.com/fy-assets/avatar/avatar-2.png',
                                            'https://cdn.flyonui.com/fy-assets/avatar/avatar-3.png',
                                            'https://cdn.flyonui.com/fy-assets/avatar/avatar-4.png',
                                            'https://cdn.flyonui.com/fy-assets/avatar/avatar-5.png',
                                        ];
                                    @endphp

                                    <img
                                        src="{{ $author->avatar ?: $avatars[$index] ?? $avatars[0] }}"
                                        alt="{{ $author->name }}"
                                        class="w-10 h-10 lg:w-12 lg:h-12 rounded-full ring-1 ring-gray-200"
                                        onerror="this.src='{{ $avatars[0] }}'"
                                    />

                                    <!-- Rank badge -->
                                    <div class="absolute -top-1 -right-1 w-5 h-5 lg:w-6 lg:h-6 rounded-full flex items-center justify-center text-xs font-bold text-white
                                        {{ $index === 0 ? 'bg-gradient-to-r from-yellow-500 to-orange-500' :
                                           ($index === 1 ? 'bg-gradient-to-r from-gray-400 to-gray-600' :
                                           ($index === 2 ? 'bg-gradient-to-r from-orange-400 to-red-500' : 'bg-gradient-to-r from-blue-400 to-purple-500')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                </div>

                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm lg:text-base truncate">{{ $author->name }}</p>
                                    <div class="flex items-center gap-1.5 lg:gap-2 mt-0.5">
                                        <span class="text-xs text-gray-500 flex items-center gap-1">
                                            <i class="far fa-newspaper text-xs"></i>
                                            {{ $author->articles_count ?? 0 }}
                                        </span>
                                        <span class="text-xs text-green-600 flex items-center gap-1">
                                            <i class="fas fa-heart text-xs"></i>
                                            {{ $author->total_likes ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 lg:gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-xs lg:text-sm font-semibold text-blue-600">
                                    View
                                </span>
                                <i class="fas fa-arrow-right text-blue-500 text-xs lg:text-sm"></i>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-4 lg:mt-6 pt-4 lg:pt-6 border-t border-gray-100">
                    <a href="#" class="flex items-center justify-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-xs lg:text-sm">
                        View All Authors
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Newsletter Card -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 border border-blue-100 rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-sm">
                <div class="text-center mb-4 lg:mb-6">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl lg:rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4">
                        <i class="fas fa-paper-plane text-lg lg:text-2xl text-white"></i>
                    </div>
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 mb-1 lg:mb-2">Stay Updated</h3>
                    <p class="text-gray-600 text-xs lg:text-sm">Get the latest articles in your inbox</p>
                </div>

                <div class="space-y-3 lg:space-y-4">
                    <input
                        type="email"
                        placeholder="Your email"
                        class="w-full px-3 lg:px-4 py-2.5 lg:py-3 bg-white border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm lg:text-base"
                    />
                    <button class="w-full py-2.5 lg:py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg lg:rounded-xl hover:shadow-md transition-all duration-200 text-sm lg:text-base">
                        Subscribe
                    </button>
                </div>

                <p class="text-xs text-gray-500 text-center mt-3 lg:mt-4">
                    No spam. Unsubscribe anytime.
                </p>
            </div>
        </div>
    </div>
    <style>
        .max-w-7xl {
            max-width: 120rem;
        }
    </style>
</div>