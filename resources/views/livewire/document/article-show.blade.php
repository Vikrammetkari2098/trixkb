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
        <div class="flex-1 flex flex-col min-h-screen">
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
            <!-- Article Content Section - Only shown when tableArticleId is set -->
            <div x-show="tableArticleId" x-transition class="flex-1">
                <!-- Livewire Component for Article Content -->
                <livewire:document.partial.article-open />
            </div>

            <!-- Table View Section - Shown by default or when tableArticleId is null -->
            <div x-show="!tableArticleId" x-transition class="flex-1 overflow-y-auto p-6 bg-white">
                <!-- Breadcrumb -->
                <div class="text-sm text-gray-500 mb-2" x-text="activeSelection.path"></div>



                <!-- Header -->
                <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="far fa-star text-yellow-500 mr-2"></i>
                    <span x-text="activeSelection.type === 'article' ? activeSelection.articleData.title : activeSelection.name"></span>
                </h1>
                 <!-- Bulk Action Toolbar -->
                <div
                    x-show="selectedRows.length > 0"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="flex items-center space-x-4 text-sm text-gray-700 py-2 px-2 border-b border-gray-200 bg-gray-50 rounded-md shadow-sm"
                >
                    <span class="font-medium" x-text="selectedRows.length + ' selected'"></span>

                    <!-- Hide Button -->
                    <button class="flex items-center space-x-1 hover:text-indigo-600">
                        <i class="fas fa-eye-slash text-xs"></i>
                        <span>Hide</span>
                    </button>

                    <!-- Delete Button -->
                    <button
                        x-data
                        @click="$dispatch('open-delete-dialog')"
                        class="flex items-center space-x-1 hover:text-red-600"
                    >
                        <i class="fas fa-trash text-xs"></i>
                        <span>Delete</span>
                    </button>

                    <!-- Unpublish -->
                    <button class="flex items-center space-x-1 hover:text-indigo-600">
                        <i class="fas fa-ban text-xs"></i><span>Unpublish</span>
                    </button>

                    <!-- Move -->
                    <button class="flex items-center space-x-1 hover:text-indigo-600">
                        <i class="fas fa-arrows-alt text-xs"></i><span>Move</span>
                    </button>

                    <!-- Add to starred -->
                    <button class="flex items-center space-x-1 hover:text-yellow-600">
                        <i class="far fa-star text-xs"></i><span>Star</span>
                    </button>

                    <!-- Add labels -->
                    <button class="flex items-center space-x-1 hover:text-indigo-600">
                        <i class="far fa-bookmark text-xs"></i><span>Labels</span>
                    </button>
                </div>
                <!-- Table -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left"><input type="checkbox"
                                    @change="toggleAll($event)"
                                    :checked="selectedRows.length === activeSelection.articles.length && activeSelection.articles.length > 0">
                                </th>
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
                                    <td class="py-3 px-4"><input type="checkbox"
                                        :value="article.id"
                                        @change="toggleRow(article.id, $event.target.checked)"
                                        :checked="selectedRows.includes(article.id)">
                                    </td>
                                    <td class="py-3 px-4">
                                        <button @click="openArticleFromTable(article)"
                                            class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                            <i class="fas fa-clipboard text-yellow-500 mr-2"></i>
                                            <span x-text="article.title"></span>
                                        </button>
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
            </div>
        </div>
    </div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('flyLayout', () => ({
            selectedRows: [],
            tableArticleId: null, // Tracks which article is opened from table

            toggleRow(id, checked) {
                if (checked) {
                    if (!this.selectedRows.includes(id)) {
                        this.selectedRows.push(id);
                    }
                } else {
                    this.selectedRows = this.selectedRows.filter(rowId => rowId !== id);
                }
            },

            toggleAll(event) {
                const checked = event.target.checked;
                this.selectedRows = checked ? this.activeSelection.articles.map(a => a.id) : [];
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
