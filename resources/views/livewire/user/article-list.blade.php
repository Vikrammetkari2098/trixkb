<div class="max-w-full mx-auto px-2 sm:px-3 lg:px-16 py-16 ">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Left Column - Articles -->
    <div class="lg:col-span-2 space-y-8 ">
              <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Articles</h1>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-bold text-blue-600">{{ $articles->total() }}</span>
                        <span class="text-gray-600">Articles</span>
                    </div>
                </div>
        <!-- Header buttons (Recent/Popular/Trending) -->
        <div x-data="{ active: '{{ $filter }}' }" class="flex items-center justify-end p-3 border-b border-gray-200 bg-white shadow-sm mb-6">
            <div class="flex space-x-1.5 sm:space-x-2">
                <button @click="$wire.setFilter('recent'); active = 'recent'" :class="active==='recent' ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-3 sm:px-4 py-1.5 text-sm font-semibold rounded-md">Recent</button>
                <button @click="$wire.setFilter('popular'); active = 'popular'" :class="active==='popular' ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-3 sm:px-4 py-1.5 text-sm font-semibold rounded-md">Popular</button>
                <button @click="$wire.setFilter('trending'); active = 'trending'" :class="active==='trending' ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-3 sm:px-4 py-1.5 text-sm font-semibold rounded-md">Trending</button>
            </div>
        </div>

        <!-- Articles List -->
        <div class="space-y-6">
            @foreach($articles as $article)
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-4">
                    <div class="hidden sm:block flex-shrink-0">
                        <img src="{{ $article->cover_image ?? 'https://via.placeholder.com/150x100' }}" alt="{{ $article->title }}" class="w-32 h-24 object-cover rounded-lg">
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                            <img src="{{ $article->author->avatar ?? 'https://via.placeholder.com/30' }}" class="w-6 h-6 rounded-full">
                            <span class="font-semibold">{{ $article->author->name }}</span>
                            <span class="text-gray-400">•</span>
                            <span>published on {{ $article->published_at->format('d M. Y') }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $article->title }}</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit(strip_tags($article->content), 160) }}</p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-6">
                                <span class="text-sm text-gray-500"><i class="far fa-clock mr-1"></i> {{ $article->read_time ?? 5 }} min read</span>
                                <span class="text-sm text-gray-500"><i class="far fa-thumbs-up mr-1 text-blue-500"></i> {{ $article->likes_count ?? 0 }}</span>
                                <span class="text-sm text-gray-500"><i class="far fa-comment mr-1"></i> {{ $article->comments_count ?? 0 }}</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-gray-400 hover:text-blue-500"><i class="far fa-bookmark"></i></button>
                                <button class="p-2 text-gray-400 hover:text-gray-600"><i class="fas fa-share-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-[6.5rem]">
                <p class="text-sm text-gray-600">
                    Showing <span class="font-medium">{{ $articles->firstItem() }}</span> to
                    <span class="font-medium">{{ $articles->lastItem() }}</span> of
                    <span class="font-medium">{{ $articles->total() }}</span> results
                </p>

                <nav class="inline-flex items-center rounded-lg border border-gray-300 bg-white shadow-sm overflow-hidden">
                    {{ $articles->links() }}
                </nav>
            </div>
        </div>
        
    </div>

   <!-- Right Column - Top Authors -->
        <div class="space-y-8 mt-[12rem]">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <i class="fas fa-crown text-yellow-500"></i>
                    Top Authors
                </h2>

                @php
                    $avatars = [
                        'https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png',
                        'https://cdn.flyonui.com/fy-assets/avatar/avatar-2.png',
                        'https://cdn.flyonui.com/fy-assets/avatar/avatar-3.png',
                        'https://cdn.flyonui.com/fy-assets/avatar/avatar-4.png',
                        'https://cdn.flyonui.com/fy-assets/avatar/avatar-5.png',
                    ];
                @endphp

                <div class="space-y-3">
                    @foreach($topAuthors as $index => $author)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ $avatars[$index] ?? $avatars[0] }}"
                                alt="avatar"
                                class="w-10 h-10 rounded-full ring-2
                                {{ $index==0?'ring-yellow-400':($index==1?'ring-gray-300':($index==2?'ring-orange-300':'ring-gray-200')) }}">

                            <div>
                                <p class="font-semibold text-gray-900">{{ $author->name }}</p>
                                <p class="text-xs text-gray-500">{{ $author->articles_count }} Articles</p>
                            </div>
                        </div>

                  <div class="flex items-center gap-3">
                    <span class="w-7 h-7 bg-gray-100 text-gray-700 text-sm font-bold rounded-full flex items-center justify-center">
                        {{ $index+1 }}
                    </span>
                    <i class="fa-solid fa-trophy text-yellow-500"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

        </div>
    </div>
</div>
