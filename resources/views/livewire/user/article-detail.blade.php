<div class="w-full bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <header class="p-6 sm:p-10 border-b border-gray-50">
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-6">
                    {{ $article->title }}
                </h1>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="avatar bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold shadow-md">
                            {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-lg">{{ $article->author->name ?? 'Author' }}</p>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">{{ \Carbon\Carbon::parse($article->created_at)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="relative" x-data="{ shareOpen: false }">
                        {{-- Main Share Button --}}
                        <button @click="shareOpen = !shareOpen" 
                                class="p-3 rounded-full bg-gray-50 hover:bg-gray-100 text-gray-600 transition duration-300 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M15.75 4.5a3 3 0 11.825 2.066l-8.421 4.679a3.002 3.002 0 010 1.51l8.421 4.679a3 3 0 11-.729 1.31l-8.421-4.678a3 3 0 110-4.132l8.421-4.679a3 3 0 01-.096-.755z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="shareOpen" 
                            @click.outside="shareOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 p-2"
                            style="display: none;">
                            
                            <div class="text-xs font-bold text-gray-400 px-3 py-2 uppercase tracking-wider">Share to</div>

                            {{-- 1. WhatsApp --}}
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" 
                            target="_blank"
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-green-50 text-gray-700 hover:text-green-600 transition group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <span class="font-medium text-sm">WhatsApp</span>
                            </a>

                            {{-- 2. Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                            target="_blank"
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="font-medium text-sm">Facebook</span>
                            </a>

                            {{-- 3. Twitter / X --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                            target="_blank"
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-black transition group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                <span class="font-medium text-sm">X (Twitter)</span>
                            </a>

                            {{-- 4. LinkedIn --}}
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                            target="_blank"
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                <span class="font-medium text-sm">LinkedIn</span>
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            {{-- 5. Copy Link (Livewire Action) --}}
                            <button wire:click="shareArticle" 
                                    @click="shareOpen = false"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-indigo-600 transition group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5" />
                                </svg>
                                <span class="font-medium text-sm">Copy Link</span>
                            </button>

                        </div>
                    </div>
                </div>
            </header>

            <div class="p-6 sm:p-10">
                <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                    @if(isset($articleContent['blocks']) && is_array($articleContent['blocks']))
                        @foreach($articleContent['blocks'] as $block)

                            {{-- 1. HEADER --}}
                            @if($block['type'] == 'header')
                                @php
                                    $level = $block['data']['level'] ?? 2;
                                    $class = match($level) {
                                        1 => 'text-4xl font-extrabold mt-8 mb-4 text-gray-900',
                                        2 => 'text-3xl font-bold mt-6 mb-4 text-gray-900 border-b pb-2 border-gray-200',
                                        3 => 'text-2xl font-bold mt-6 mb-3 text-gray-800',
                                        4 => 'text-xl font-semibold mt-4 mb-2 text-gray-800',
                                        default => 'text-base font-bold mt-2 mb-1',
                                    };
                                    $text = $block['data']['text'] ?? '';
                                @endphp
                                <h{{ $level }} class="{{ $class }}">
                                    {!! is_array($text) ? ($text['text'] ?? '') : $text !!}
                                </h{{ $level }}>

                            {{-- 2. PARAGRAPH (येथे जास्त शक्यता असते एररची) --}}
                            @elseif($block['type'] == 'paragraph')
                                @php $text = $block['data']['text'] ?? ''; @endphp
                                <p class="mb-4 text-lg text-gray-700 leading-7">
                                    {!! is_array($text) ? ($text['text'] ?? '') : $text !!}
                                </p>

                            {{-- 3. LIST --}}
                            @elseif($block['type'] == 'list')
                                @php
                                    $style = $block['data']['style'] ?? 'unordered';
                                    $tag = $style === 'ordered' ? 'ol' : 'ul';
                                    $listClass = $style === 'ordered' ? 'list-decimal' : 'list-disc';
                                    $items = $block['data']['items'] ?? [];
                                @endphp
                                <{{ $tag }} class="{{ $listClass }} pl-8 mb-6 space-y-2 text-gray-700 text-lg">
                                    @if(is_array($items))
                                        @foreach($items as $item)
                                            <li class="pl-1">
                                                {{-- Safe Check for List Items --}}
                                                {!! is_array($item) ? ($item['content'] ?? ($item['text'] ?? '')) : $item !!}
                                            </li>
                                        @endforeach
                                    @endif
                                </{{ $tag }}>

                            {{-- 4. IMAGE --}}
                            @elseif($block['type'] == 'image')
                                @php
                                    $url = $block['data']['file']['url'] ?? '';
                                    $caption = $block['data']['caption'] ?? '';
                                    $withBorder = $block['data']['withBorder'] ?? false;
                                    $withBackground = $block['data']['withBackground'] ?? false;
                                    $stretched = $block['data']['stretched'] ?? false;
                                @endphp
                                <div class="my-8 {{ $stretched ? 'w-full' : '' }} {{ $withBackground ? 'bg-gray-100 p-4 rounded-lg' : '' }}">
                                    @if(!empty($url))
                                        <img src="{{ $url }}" 
                                            alt="{{ is_string($caption) ? strip_tags($caption) : 'Image' }}" 
                                            class="rounded-lg shadow-sm {{ $withBorder ? 'border-2 border-gray-200 p-1' : '' }} w-full h-auto">
                                    @endif
                                    @if(!empty($caption))
                                        <div class="text-center text-sm text-gray-500 mt-2 italic">
                                            {!! is_array($caption) ? ($caption['text'] ?? '') : $caption !!}
                                        </div>
                                    @endif
                                </div>

                            {{-- 5. TABLE --}}
                            @elseif($block['type'] == 'table')
                                @php
                                    $content = $block['data']['content'] ?? [];
                                    $withHeadings = $block['data']['withHeadings'] ?? false;
                                @endphp
                                @if(is_array($content) && count($content) > 0)
                                <div class="overflow-x-auto my-8">
                                    <table class="w-full border-collapse border border-gray-300 rounded-lg text-left">
                                        @if($withHeadings)
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    @foreach($content[0] as $heading)
                                                        <th class="border border-gray-300 px-4 py-2 font-semibold text-gray-700">
                                                            {!! is_array($heading) ? ($heading['content'] ?? '') : $heading !!}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(array_slice($content, 1) as $row)
                                                    <tr class="odd:bg-white even:bg-gray-50">
                                                        @foreach($row as $cell)
                                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                                {!! is_array($cell) ? ($cell['content'] ?? '') : $cell !!}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <tbody>
                                                @foreach($content as $row)
                                                    <tr class="odd:bg-white even:bg-gray-50">
                                                        @foreach($row as $cell)
                                                            <td class="border border-gray-300 px-4 py-2 text-gray-700">
                                                                {!! is_array($cell) ? ($cell['content'] ?? '') : $cell !!}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                                @endif

                            {{-- 6. CHECKLIST --}}
                            @elseif($block['type'] == 'checklist')
                                <div class="space-y-3 mb-6">
                                    @php $items = $block['data']['items'] ?? []; @endphp
                                    @if(is_array($items))
                                        @foreach($items as $item)
                                            <div class="flex items-start p-2 rounded hover:bg-gray-50 transition">
                                                <div class="flex items-center h-6">
                                                    <input type="checkbox" disabled {{ ($item['checked'] ?? false) ? 'checked' : '' }} 
                                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 disabled:opacity-50">
                                                </div>
                                                <div class="ml-3 text-lg">
                                                    <span class="{{ ($item['checked'] ?? false) ? 'line-through text-gray-400' : 'text-gray-700' }}">
                                                        {!! $item['text'] ?? '' !!}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                            {{-- 7. QUOTE --}}
                            @elseif($block['type'] == 'quote')
                                @php 
                                    $text = $block['data']['text'] ?? '';
                                    $caption = $block['data']['caption'] ?? '';
                                @endphp
                                <figure class="my-8 pl-6 border-l-4 border-indigo-500 bg-gray-50 py-4 pr-4 rounded-r-lg">
                                    <blockquote class="italic text-xl text-gray-800 leading-relaxed">
                                        "{!! is_array($text) ? ($text['text'] ?? '') : $text !!}"
                                    </blockquote>
                                    @if(!empty($caption))
                                        <figcaption class="mt-2 text-sm text-gray-600 font-semibold text-right">
                                            — {!! is_array($caption) ? ($caption['text'] ?? '') : $caption !!}
                                        </figcaption>
                                    @endif
                                </figure>

                            {{-- 8. CODE --}}
                            @elseif($block['type'] == 'code')
                                <div class="my-6 bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                                    <pre class="p-4 overflow-x-auto"><code class="font-mono text-sm text-green-400">{!! htmlspecialchars($block['data']['code'] ?? '') !!}</code></pre>
                                </div>

                            {{-- 9. RAW HTML --}}
                            @elseif($block['type'] == 'raw')
                                <div class="my-6">
                                    {!! $block['data']['html'] ?? '' !!}
                                </div>

                            @endif

                        @endforeach
                    @endif
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 flex items-center space-x-8">
                    <button wire:click="toggleLike" 
                            class="group flex items-center space-x-3 transition-all duration-300 ease-in-out focus:outline-none
                            {{ $hasLiked ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                        
                        <div class="relative w-10 h-10 flex items-center justify-center rounded-full transition-colors group-hover:bg-red-50">
                            @if($hasLiked)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 transform transition-transform duration-300 hover:scale-110">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 transform transition-transform duration-300 group-hover:scale-110">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            @endif
                        </div>
                        
                        <span class="font-bold font-arial tracking-tight {{ $hasLiked ? 'text-gray-900' : 'text-gray-500' }}">
                            {{ $likeCount }} <span class="text-sm font-sans font-medium ml-1">Likes</span>
                        </span>
                    </button>

                    <div class="flex items-center space-x-2 text-gray-500 group cursor-default">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-50 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-600">{{ $commentCount }} Comments</span>
                    </div>
                </div>
            </div>
        </article>

        <section class="mt-16 bg-white rounded-2xl p-6 sm:p-10 shadow-sm border border-gray-100">
            <h2 class="text-2xl font-black mb-8 flex items-center">
                <span class="bg-indigo-600 w-1.5 h-8 mr-3 rounded-full"></span>
                   Comments ({{ $commentCount }})
            </h2>

            <div class="mb-12">
                <textarea wire:model="newComment" rows="3" class="w-full p-5 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition outline-none resize-none" placeholder="What are your thoughts?"></textarea>
                <div class="flex justify-end mt-3">
                    <button wire:click.prevent="postComment()" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">Post Comment</button>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($comments as $comment)
                    <div class="flex space-x-4 animate-fade-in-up" wire:key="comment-{{ $comment->id }}">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center font-bold text-indigo-600 border-2 border-white shadow-sm ring-2 ring-indigo-50">
                                {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-1 bg-gray-50 rounded-2xl p-6 shadow-sm border border-gray-100/50">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $comment->user->name ?? 'User' }}</h4>
                                    <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            {{-- EDIT MODE CHECK --}}
                            @if($editingCommentId === $comment->id)
                                <div class="mt-2">
                                    <textarea wire:model="editingCommentText" class="w-full p-3 border border-indigo-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm bg-white" rows="2"></textarea>
                                    <div class="flex space-x-2 mt-2 justify-end">
                                        <button wire:click="cancelEdit" class="text-gray-500 px-3 py-1 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Cancel</button>
                                        <button wire:click="updateComment" class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm">Save Changes</button>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-700 leading-relaxed">{{ $comment->comment }}</p>
                            @endif
                            
                            <div class="mt-4 flex items-center space-x-4">
                                {{-- Reply Button --}}
                                <button wire:click="toggleReplyForm({{ $comment->id }})" class="group flex items-center space-x-1 text-sm font-bold text-gray-500 hover:text-indigo-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    <span>Reply</span>
                                </button>

                                {{-- EDIT & DELETE BUTTONS (Only for Owner) --}}
                                @if(auth()->id() === $comment->user_id && $editingCommentId !== $comment->id)
                                    <button wire:click="editComment({{ $comment->id }})" class="text-gray-400 hover:text-green-600 transition">
                                        {{-- Heroicon: Pencil Square --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                        </svg>
                                    </button>

                                    <button wire:click="deleteComment({{ $comment->id }})" 
                                            wire:confirm="Are you sure you want to delete this comment?"
                                            class="text-gray-400 hover:text-red-600 transition">
                                        {{-- Heroicon: Trash --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            @if($showReplyForm == $comment->id)
                                <div class="mt-4 p-4 bg-white rounded-xl shadow-sm border border-indigo-50 animate-fade-in">
                                    <textarea wire:model="replyText.{{ $comment->id }}" class="w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 outline-none" placeholder="Write a reply..."></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button wire:click="postComment({{ $comment->id }})" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm">Submit Reply</button>
                                    </div>
                                </div>
                            @endif

                            @if($comment->replies && count($comment->replies) > 0)
                                <div class="mt-6 space-y-4">
                                    @foreach($comment->replies as $reply)
                                        <div class="flex space-x-3 items-start p-4 bg-white rounded-xl shadow-sm border border-gray-100 relative">
                                            <div class="absolute -left-6 top-6 w-6 h-6 border-b-2 border-l-2 border-gray-200 rounded-bl-xl"></div>
                                            
                                            <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-[10px] font-bold text-purple-600 ring-2 ring-white">
                                                {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-bold text-gray-900">{{ $reply->user->name ?? 'User' }}</span>
                                                    <span class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600 mt-1">{{ $reply->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- See All / Show Less Button --}}
            @if($commentCount > 3)
                <div class="mt-10 text-left border-t border-gray-100 pt-8">
                    <button wire:click="toggleCommentsView" 
                            class="inline-flex items-start px-6 py-2.5 border border-gray-200 shadow-sm text-sm font-bold rounded-full text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                        
                        @if($showAllComments)
                            <span>Show Less</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            </svg>
                        @else
                            <span>See All Comments ({{ $commentCount }})</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        @endif
                        
                    </button>
                </div>
            @endif

        </section>
    </div>
</div>