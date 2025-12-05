@extends('layouts.app')
@section('content')
<div x-data="flyLayout" class="min-h-screen bg-gray-50">
    <!-- Top Header -->
    <header class="flex items-center justify-between px-6 py-3 bg-white shadow-sm ">
        <!-- Left buttons -->
        <div class="flex space-x-2">
            <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="fas fa-list-check"></i></button>
            <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="far fa-clock"></i></button>
            <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="far fa-star"></i></button>
            <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="fas fa-trash-can"></i></button>
        </div>

        <!-- Create Article Button with Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="btn btn-primary text-white px-4 py-2 rounded-md flex items-center">
                Create article
                <i class="fas fa-chevron-down ml-2"></i>
            </button>

            <div x-show="open" @click.away="open = false"
                 class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-1 z-10">
                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-magic text-indigo-500 mr-3"></i>
                    Article with AI
                </a>
                <a href="#" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <span class="flex items-center">
                        <i class="far fa-file-alt text-gray-500 mr-3"></i>
                        Article
                    </span>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
                <a href="#" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <span class="flex items-center">
                        <i class="fas fa-list-ol text-gray-500 mr-3"></i>
                        Step by step guide
                    </span>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">NEW</span>
                </a>

                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="far fa-folder text-gray-500 mr-3"></i>
                    Sub category
                </a>
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="bg-white flex flex-1 rounded-xl shadow-md border border-gray-200 flex flex-1 p-6 space-y-6">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 overflow-y-auto">
            <div class="p-4">
                <a href="#" class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                    <span class="flex items-center">
                        <i class="fas fa-building mr-3 text-gray-500"></i>
                        Site builder
                    </span>
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
                <a href="#" class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                    <span class="flex items-center">
                        <i class="fas fa-tools mr-3 text-gray-500"></i>
                        Content tools
                    </span>
                    <i class="fas fa-chevron-right text-xs"></i>
                </a>
                <hr class="my-3 border-gray-200">
            </div>

            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">CATEGORIES & ARTICLES</h3>
            </div>

            <!-- Navigation Tree -->
            <nav class="px-2">
                <template x-for="category in navItems" :key="category.name">
                    <div>
                        <!-- Category Item -->
                        <button @click="toggleCategory(category)"
                                :class="{
                                    'bg-indigo-50 text-indigo-600 border-l-3 border-indigo-600': isCategoryActive(category),
                                    'hover:bg-gray-50': !isCategoryActive(category)
                                }"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium rounded transition-colors">
                            <i class="fas fa-chevron-right text-xs w-4 transition-transform"
                               :class="{'rotate-90': category.isOpen}"></i>
                            <i :class="[category.icon, 'mr-3', {'text-indigo-500': isCategoryActive(category)}]"></i>
                            <span x-text="category.name" class="flex-1 text-left"></span>
                        </button>

                        <!-- Nested Articles -->
                        <div x-show="category.isOpen" x-transition class="ml-4 pl-4 border-l border-gray-200">
                            <template x-for="article in category.articles" :key="article.id">
                                <button @click="setActiveArticle(article, category)"
                                        :class="{
                                            'bg-indigo-50 text-indigo-600': isArticleActive(article),
                                            'hover:bg-gray-50': !isArticleActive(article)
                                        }"
                                        class="w-full flex items-center px-3 py-2 text-sm rounded transition-colors">
                                    <i class="far fa-file-alt mr-3 text-gray-500"
                                       :class="{'text-indigo-500': isArticleActive(article)}"></i>
                                    <span x-text="article.title" class="flex-1 text-left"></span>
                                    <i x-show="article.status === 'Draft'"
                                       class="fas fa-circle text-xs text-yellow-500"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-white min-h-screen">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-2" x-text="activeSelection.path"></div>

            <!-- Header -->
            <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="far fa-star text-yellow-500 mr-2"></i>
                <span x-text="activeSelection.type === 'article' ? activeSelection.articleData.title : activeSelection.name"></span>
            </h1>

            <!-- Table -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-left"><input type="checkbox"></th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Title</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Tags</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Updated on</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Labels</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="article in activeSelection.articles" :key="article.id">
                            <tr :class="{'bg-indigo-50': isArticleActive(article)}" class="hover:bg-gray-50">
                                <td class="py-3 px-4"><input type="checkbox"></td>
                                <td class="py-3 px-4">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                        <i class="fas fa-clipboard text-yellow-500 mr-2"></i>
                                        <span x-text="article.title"></span>
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-gray-600" x-text="article.status"></td>
                                <td class="py-3 px-4">
                                    <div x-show="article.tags.length > 0" class="flex items-center">
                                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded mr-1">
                                            <span x-text="article.tags[0]"></span>...
                                        </span>
                                        <span x-show="article.tags.length > 1"
                                              class="text-indigo-600 text-xs">
                                              +<span x-text="article.tags.length - 1"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-600" x-text="article.updated"></td>
                                <td class="py-3 px-4"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Table Footer -->
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 text-sm text-gray-600">
                    <span x-text="activeSelection.articles ? '1 - ' + activeSelection.articles.length + ' of ' + activeSelection.articles.length + ' items' : '0 items'"></span>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('flyLayout', () => ({
        navItems: [
            {
                type: 'category',
                name: 'Getting started guides',
                icon: 'far fa-folder',
                path: '/getting-started-guides',
                isOpen: true,
                articles: [
                    { id: 1, title: 'New Article', status: 'Draft', tags: ['Draft'], updated: 'This Tuesday' },
                    { id: 2, title: 'Product Installation Steps', status: 'Draft', tags: ['Installation', 'Guide'], updated: 'This Tuesday' },
                    { id: 3, title: 'Initial Setup Guide', status: 'Draft', tags: ['Setup', 'Guide'], updated: 'This Tuesday' },
                ]
            },
            {
                type: 'category',
                name: 'FAQs',
                icon: 'far fa-folder',
                path: '/faqs',
                isOpen: false,
                articles: [
                    { id: 4, title: 'Common Questions', status: 'Published', tags: ['FAQ'], updated: 'Yesterday' },
                ]
            },
            {
                type: 'category',
                name: 'Blog',
                icon: 'far fa-folder',
                path: '/blog',
                isOpen: false,
                articles: [
                    { id: 5, title: 'Top 10 AI Tools for KM in 2025', status: 'Draft', tags: ['KM', 'AI', '2025'], updated: '17 hours ago' },
                ]
            }
        ],

        activeSelection: {
            type: 'article',
            name: 'New Article',
            path: '/getting-started-guides',
            articleData: null,
            articles: []
        },

        init() {
            // Set initial active item
            const firstCategory = this.navItems[0];
            this.setActiveArticle(firstCategory.articles[0], firstCategory);
        },

        toggleCategory(category) {
            category.isOpen = !category.isOpen;
            if (category.isOpen) {
                this.setActiveCategory(category);
            }
        },

        setActiveCategory(category) {
            this.activeSelection = {
                type: 'category',
                name: category.name,
                path: category.path,
                articleData: null,
                articles: category.articles
            };
        },

        setActiveArticle(article, category) {
            // Close all categories except the active one
            this.navItems.forEach(cat => {
                cat.isOpen = cat.name === category.name;
            });

            this.activeSelection = {
                type: 'article',
                name: article.title,
                path: category.path,
                articleData: article,
                articles: category.articles
            };
        },

        isCategoryActive(category) {
            return this.activeSelection.type === 'category' &&
                   this.activeSelection.name === category.name;
        },

        isArticleActive(article) {
            return this.activeSelection.type === 'article' &&
                   this.activeSelection.articleData?.id === article.id;
        }
    }));
});
</script>
@endsection
