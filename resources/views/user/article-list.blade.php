@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT : ARTICLES -->
            <div class="lg:col-span-2 space-y-6">

                <!-- HEADER -->
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold">Articles</h1>
                    <span class="text-gray-600">
                        {{ $articles->total() }} Articles
                    </span>
                </div>

                <!-- FILTER -->
                <div x-data="{ active: 'recent' }" class="flex gap-2 bg-white p-3 rounded-lg shadow">
                    @foreach (['recent','popular','trending'] as $filter)
                        <button
                            @click="active='{{ $filter }}'"
                            :class="active==='{{ $filter }}'
                                ? 'bg-indigo-100 text-indigo-700'
                                : 'text-gray-600 hover:bg-gray-100'"
                            class="px-4 py-2 rounded-md font-semibold text-sm">
                            {{ ucfirst($filter) }}
                        </button>
                    @endforeach
                </div>

                <!-- ARTICLES LOOP -->
                @foreach ($articles as $article)
                    <div class="bg-white rounded-xl border p-6 hover:shadow-md transition">
                        <div class="flex gap-4">
                            <img
                                src="{{ $article->image ?? 'https://via.placeholder.com/150' }}"
                                class="w-32 h-24 rounded-lg object-cover hidden sm:block">

                            <div class="flex-1">
                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                                    <img src="{{ $article->author->avatar ?? 'https://via.placeholder.com/40' }}"
                                         class="w-6 h-6 rounded-full">
                                    <span class="font-semibold">
                                        {{ $article->author->name }}
                                    </span>
                                    •
                                    <span>{{ $article->created_at->format('d M Y') }}</span>
                                </div>

                                <h3 class="text-xl font-bold mb-2">
                                    {{ $article->title }}
                                </h3>

                                <p class="text-gray-600 mb-4">
                                    {{ Str::limit($article->description, 140) }}
                                </p>

                                <div class="flex justify-between items-center border-t pt-3">
                                    <div class="flex gap-5 text-sm text-gray-500">
                                        <span><i class="far fa-clock"></i> {{ $article->read_time ?? 5 }} min</span>
                                        <span><i class="far fa-thumbs-up text-blue-500"></i> {{ $article->likes ?? 0 }}</span>
                                        <span><i class="far fa-comment"></i> {{ $article->comments ?? 0 }}</span>
                                    </div>

                                    <div class="flex gap-2">
                                        <button class="p-2 hover:text-blue-600">
                                            <i class="far fa-bookmark"></i>
                                        </button>
                                        <button class="p-2 hover:text-gray-700">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- PAGINATION -->
                <div class="mt-6">
                    {{ $articles->links() }}
                </div>
            </div>

            <!-- RIGHT : TOP AUTHORS -->
            <div class="space-y-4">
                <div class="bg-white rounded-xl p-6 shadow">
                    <h2 class="text-xl font-bold mb-4">
                        <i class="fas fa-crown text-yellow-500"></i> Top Authors
                    </h2>

                    @foreach ($authors as $index => $author)
                        <div class="flex justify-between items-center p-3 rounded-lg hover:bg-gray-50">
                            <div class="flex gap-3 items-center">
                                <img src="{{ $author->avatar ?? 'https://via.placeholder.com/40' }}"
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold">{{ $author->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $author->articles_count }} Articles
                                    </p>
                                </div>
                            </div>

                            <span class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
