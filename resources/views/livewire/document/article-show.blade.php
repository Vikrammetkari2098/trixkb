<div x-data="flyLayout" class="min-h-screen bg-gray-50">
    <!-- Main Layout -->
    <div class="bg-white flex flex-1 rounded-xl shadow-md border border-gray-200 flex flex-1 p-6 space-y-6">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 overflow-y-auto">

            <div class="flex space-x-2">
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="fas fa-list-check"></i></button>
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="far fa-clock"></i></button>
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="far fa-star"></i></button>
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded"><i class="fas fa-trash-can"></i></button>
            </div>
            <div class="p-4">
                <a href="{{ route('api.docs') }}"
                     class="flex items-center justify-between p-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
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

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen bg-white">
           <div class="join justify-end flex">
                <!-- Main Button -->
            <button x-on:click="$modalOpen('modal-create')" class="font-medium flex items-center btn btn-primary text-white px-4 py-2 rounded-l-lg hover:bg-indigo-700 transition duration-150">
                <span class="icon-[tabler--plus] size-4 mr-2"></span>
                Create Article
            </button>
                <!-- Dropdown Split -->
            <div class="dropdown relative inline-flex">
                <button id="dropdown-article" type="button" class="dropdown-toggle btn btn-square btn-primary join-item" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
                </button>

                <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-article">
                <li>
                    <a class="dropdown-item" href="#" @click="$dispatch('open-modal', 'modal-create-eddy')">
                    <span class="icon-[tabler--sparkles] mr-2"></span>
                    Create with Eddy AI
                    </a>
                </li>
                <li class="dropdown relative [--offset:15] [--placement:left-start] [--scope:window]">

                    <!-- Parent Button -->
                    <button id="nested-dropdown-article"
                            class="dropdown-toggle dropdown-item justify-between"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                        Article
                        <span class="icon-[tabler--chevron-left] size-4 rtl:rotate-180"></span>
                    </button>

                    <!-- Sub Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60"
                        role="menu" aria-orientation="vertical" aria-labelledby="nested-dropdown-article">
                        <li><a class="dropdown-item"
                            href="#"
                            @click="$dispatch('open-modal', 'modal-create-article')">
                            Blank
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">Form Template</a></li>
                        <li><a class="dropdown-item" href="#">Import Document</a></li>
                    </ul>
                </li>
                <li>
                    <a class="dropdown-item" href="#" @click="$dispatch('open-modal', 'modal-step-by-step')">
                    <span class="icon-[tabler--book] mr-2"></span>
                    Step by Step Guide
                    <span class="badge badge-success ml-auto">NEW</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" @click="$dispatch('open-modal', 'modal-sub-category')">
                    <span class="icon-[tabler--folders] mr-2"></span>
                    Sub Category
                    </a>
                </li>
                </ul>
            </div>
        </div>
           <!-- Article Content Section -->
            <div
                x-cloak
                x-show="tableArticleId !== null"
                x-transition
                class="flex-1"
            >
                <livewire:document.partial.article-open />
            </div>
            <livewire:document.article-delete />
            <!-- Table View Section - Shown by default or when tableArticleId is null -->
            <div x-show="!tableArticleId" x-transition class="flex-1 overflow-y-auto p-6 bg-white">
                <!-- Breadcrumb -->
                <div class="text-sm text-gray-500 mb-2" x-text="activeSelection.path"></div>

                <!-- Header -->
                <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="far fa-star text-yellow-500 mr-2"></i>
                    <span x-text="activeSelection.type === 'article' ? activeSelection.articleData.title : activeSelection.name"></span>
                </h1>

                <div class="bg-white min-h-screen antialiased p-6">

                        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">

                               <!-- LEFT : Quantity -->
                                <div x-data="{ open: false }" class="relative inline-block">
                                    <!-- Button -->
                                    <button @click="open = !open" class="btn btn-outline flex items-center gap-1 border border-gray-300 text-gray-700">
                                        {{ $quantity }}
                                        <span :class="{ 'rotate-180': open }" class="icon-[tabler--chevron-down] size-4 transition-transform duration-200"></span>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <ul x-show="open" @click.outside="open = false"
                                        x-transition
                                        class="absolute left-0 mt-1 w-24 bg-white border border-gray-300 rounded shadow z-50">
                                        @foreach ([5, 10, 25] as $q)
                                            <li>
                                                <button wire:click="setQuantity({{ $q }})" @click="open = false" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700">
                                                    {{ $q }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- RIGHT : Search -->
                            <div x-data="{ search: @entangle('search').live }">
                                <input
                                    type="text"
                                    x-model="search"
                                    placeholder="Search articles..."
                                    class="px-3 py-1 rounded-lg border border-gray-300
                                        focus:outline-none focus:ring-1 focus:ring-purple-500"
                                >
                                </div>
                        </div>
                       <div
                            x-data="{
                                selectedRows: [],

                                toggleAll(event) {
                                    if (event.target.checked) {
                                        this.selectedRows = [...document.querySelectorAll('.row-checkbox')]
                                            .map(cb => cb.value);
                                    } else {
                                        this.selectedRows = [];
                                    }
                                }
                            }"
                        >

                            <!-- Bulk Action Toolbar -->
                            <div
                                x-show="selectedRows.length > 0"
                                x-transition:enter="transition-all ease-out duration-300"
                                x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition-all ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                class="
                                    sticky top-0 z-20
                                    bg-white
                                    rounded-xl
                                    shadow-sm
                                    px-4 py-3
                                    flex flex-wrap items-center gap-4
                                    text-sm text-gray-700
                                "
                            >
                                <!-- Selected Count -->
                                <span class="font-semibold" x-text="selectedRows.length + ' selected'"></span>

                                <!-- Hide -->
                                <button class="flex items-center gap-1 text-gray-600 hover:text-indigo-600 transition">
                                    <i class="fas fa-eye-slash text-xs"></i>
                                    <span class="hidden sm:inline">Hide</span>
                                </button>

                                <!-- Delete -->
                                <button
                                @click="$dispatch('open-delete-dialog', selectedRows)"
                                    class="flex items-center gap-1 text-gray-600 hover:text-red-600 transition"
                                >
                                    <i class="fas fa-trash text-xs"></i>
                                    <span>Delete</span>
                                </button>

                                <!-- Unpublish -->
                                <button class="flex items-center gap-1 text-gray-600 hover:text-indigo-600 transition">
                                    <i class="fas fa-ban text-xs"></i>
                                    <span class="hidden sm:inline">Unpublish</span>
                                </button>

                                <!-- Move -->
                                <button class="flex items-center gap-1 text-gray-600 hover:text-indigo-600 transition">
                                    <i class="fas fa-arrows-alt text-xs"></i>
                                    <span class="hidden sm:inline">Move</span>
                                </button>

                                <!-- Star -->
                                <button class="flex items-center gap-1 text-gray-600 hover:text-yellow-500 transition">
                                    <i class="far fa-star text-xs"></i>
                                    <span class="hidden sm:inline">Star</span>
                                </button>

                                <!-- Labels -->
                                <button class="flex items-center gap-1 text-gray-600 hover:text-indigo-600 transition">
                                    <i class="far fa-bookmark text-xs"></i>
                                    <span class="hidden sm:inline">Labels</span>
                                </button>
                            </div>

                            <!-- Articles Table -->
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50 text-gray-500 text-xs tracking-wider">
                                        <tr>
                                            <!-- Select All -->
                                            <th class="px-6 py-3 text-left">
                                                <input
                                                    type="checkbox"
                                                    @change="toggleAll($event)"
                                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                >
                                            </th>

                                            <th class="px-4 py-3 text-left">Sr. no.</th>

                                            <th
                                                class="px-4 py-3 text-left cursor-pointer"
                                                wire:click="sortBy('title')"
                                            >
                                                Title
                                            </th>

                                            <th class="px-4 py-3 text-left">Tags</th>
                                            <th class="px-4 py-3 text-left">Labels</th>

                                            <th
                                                class="px-4 py-3 text-left cursor-pointer"
                                                wire:click="sortBy('status')"
                                            >
                                                Status
                                            </th>

                                            <th
                                                class="px-4 py-3 text-left cursor-pointer"
                                                wire:click="sortBy('updated_at')"
                                            >
                                                Updated At
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                        @forelse($rows as $index => $article)
                                            <tr
                                                wire:click.stop
                                                class="hover:bg-gray-50 transition duration-150
                                                {{ $articleId === $article->id ? 'bg-indigo-50' : '' }}"
                                            >
                                                <!-- Checkbox -->
                                                <td class="px-6 py-3">
                                                    <input
                                                        type="checkbox"
                                                        x-model="selectedRows"
                                                        value="{{ $article->id }}"
                                                        class="row-checkbox"
                                                    >

                                                </td>

                                                <!-- Index -->
                                                <td class="px-6 py-3 text-gray-500">
                                                    {{ $rows->firstItem() + $index }}
                                                </td>

                                                <!-- Title -->
                                                <td class="py-3 px-4">
                                                    <button
                                                        type="button"
                                                        @click="openArticleFromTable({
                                                            id: {{ $article->id }},
                                                            title: '{{ addslashes($article->title) }}'
                                                        })"
                                                        class="text-indigo-600 hover:text-indigo-800 flex items-center"
                                                    >
                                                        <i class="fas fa-clipboard text-yellow-500 mr-2"></i>
                                                        <span>{{ $article->title }}</span>
                                                    </button>
                                                </td>

                                                <!-- Tags -->
                                                <td class="px-4 py-3">
                                                    <div class="flex flex-wrap gap-1">
                                                        <span class="px-2 py-0.5 rounded-full text-xs bg-indigo-50 text-indigo-700">
                                                            Product
                                                        </span>
                                                        <span class="px-2 py-0.5 rounded-full text-xs bg-indigo-50 text-indigo-700">
                                                            Docs
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Labels -->
                                                <td class="px-4 py-3">
                                                    <div class="flex flex-wrap gap-1">
                                                        <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700">
                                                            Important
                                                        </span>
                                                        <span class="px-2 py-0.5 rounded-full text-xs bg-amber-50 text-amber-700">
                                                            Internal
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Status -->
                                                <td class="px-4 py-3 text-gray-600">
                                                    {{ ucfirst($article->status) }}
                                                </td>

                                                <!-- Updated -->
                                                <td class="px-4 py-3 text-gray-500">
                                                    {{ $article->updated_at->format('Y-m-d H:i') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="py-6 text-center text-gray-500">
                                                    No articles found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="p-4 relative z-30">
                                    {{ $rows->links() }}
                                </div>
                            </div>
                        </div>

                </div>
                <style>
                    [class*="icon-"] {
                        display: inline-block;
                        width: 1.25rem;
                        height: 1.25rem;
                        background-color: currentColor;
                        mask-repeat: no-repeat;
                        mask-size: cover;
                    }
                </style>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('flyLayout', () => ({
                selectedRows: [],
                tableArticleId: null, // Tracks which article is opened from table

                toggleAll(event) {
                    const checked = event.target.checked;
                    if (checked) {
                        // Get all article IDs from the current page
                        this.selectedRows = @json($rows->pluck('id')->toArray());
                    } else {
                        this.selectedRows = [];
                    }
                },

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
                        // Clear any opened article from table
                        this.tableArticleId = null;
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
                    // Clear opened article from table
                    this.tableArticleId = null;
                },

                // This is for sidebar article clicks - only updates selection, doesn't open article page
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

                    // Clear any opened article from table
                    this.tableArticleId = null;
                },

                // This is for table article title clicks - opens the article page
                openArticleFromTable(article) {
                    // Set the article ID to show the Livewire component
                    this.tableArticleId = article.id;
                    this.$dispatch('openArticle', { id: article.id });
                    window.dispatchEvent(new CustomEvent('load-article-title', {
        detail: { title: article.title }
    }));

                    // Also update the active selection for highlighting
                    const category = this.navItems.find(cat =>
                        cat.articles.some(a => a.id === article.id)
                    );

                    if (category) {
                        this.activeSelection = {
                            type: 'article',
                            name: article.title,
                            path: category.path,
                            articleData: article,
                            articles: category.articles
                        };
                    }
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
</div>
