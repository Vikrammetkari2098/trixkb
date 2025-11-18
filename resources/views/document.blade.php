@extends('layouts.app')
@section('content')
    <div class="fly-layout-container" x-data="{
        // Data structure remains identical to the Tailwind version for functionality
        navItems: [
            {
                type: 'category',
                name: 'Getting started guides',
                icon: 'fa-regular fa-folder',
                path: '/getting-started-guides',
                isOpen: true, // Set to true to match the image's initial open state
                articles: [
                    { id: 1, title: 'New Article', status: 'Draft', tags: ['Draft'], updated: 'This Tuesday', type: 'article' },
                    { id: 2, title: 'Product Installation Steps', status: 'Draft', tags: ['Installation', 'Guide'], updated: 'This Tuesday', type: 'article' },
                    { id: 3, title: 'Initial Setup Guide', status: 'Draft', tags: ['Setup', 'Guide'], updated: 'This Tuesday', type: 'article' },
                ]
            },
            {
                type: 'category',
                name: 'FAQs',
                icon: 'fa-regular fa-folder',
                path: '/faqs',
                isOpen: false,
                articles: [
                    { id: 4, title: 'Common Questions', status: 'Published', tags: ['FAQ'], updated: 'Yesterday', type: 'article' },
                ]
            },
            {
                type: 'category',
                name: 'Blog',
                icon: 'fa-regular fa-folder',
                path: '/blog',
                isOpen: false,
                articles: [
                    { id: 5, title: 'Top 10 AI Tools for KM in 2025', status: 'Draft', tags: ['KM', 'AI', '2025'], updated: '17 hours ago', type: 'article' },
                ]
            }
        ],

        // Active selection initialized to the first item ('Getting started guides') and its first article ('New Article')
        activeSelection: { type: 'article', name: 'New Article', path: '/getting-started-guides', articleData: { id: 1, title: 'New Article', status: 'Draft', tags: ['Draft'], updated: 'This Tuesday', type: 'article' }, articles: [] },

        init() {
            // Set the initial active selection to the first article in the first category, matching the image.
            const initialCategory = this.navItems[0];
            const initialArticle = initialCategory.articles[0];

            initialCategory.isOpen = true;
            this.activeSelection = {
                type: 'article',
                name: initialArticle.title,
                path: initialCategory.path,
                articleData: initialArticle,
                articles: initialCategory.articles // Used for populating the table
            };
        },

        setActive(item, parentCategory = null) {
            // ... (Alpine.js logic to handle category toggle and active state remains the same)
            if (item.type === 'category') {
                item.isOpen = !item.isOpen;
                this.activeSelection = {
                    type: 'category',
                    name: item.name,
                    path: item.path,
                    articles: item.articles
                };
            } else if (item.type === 'article' && parentCategory) {
                this.navItems.forEach(cat => { cat.isOpen = (cat.name === parentCategory.name); }); // Ensure only the parent is open
                this.activeSelection = {
                    type: 'article',
                    name: item.title,
                    path: parentCategory.path,
                    articleData: item,
                    articles: parentCategory.articles // Still display all articles of the parent category in the main table
                };
            }
        },

        isActive(item, parentCategory = null) {
            if (item.type === 'category') {
                return this.activeSelection.type === 'category' && this.activeSelection.name === item.name;
            } else if (item.type === 'article' && parentCategory) {
                return this.activeSelection.type === 'article' && this.activeSelection.name === item.title;
            }
            return false;
        }
    }">

        <header class="fly-topbar fly-shadow-sm fly-bg-white">
            <div class="fly-topbar-left">
                <button class="fly-icon-button"><i class="fa-solid fa-list-check"></i></button>
                <button class="fly-icon-button"><i class="fa-regular fa-clock"></i></button>
                <button class="fly-icon-button"><i class="fa-regular fa-star"></i></button>
                <button class="fly-icon-button"><i class="fa-solid fa-trash-can"></i></button>
            </div>

           <div x-data="{ open: false }" class="relative">
                <button @click="open = ! open"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md flex items-center">
                    Create article
                    <i class="fa-solid fa-chevron-down ml-2"></i>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute mt-2 right-0 w-80 bg-white border border-gray-200 rounded-lg shadow-lg p-0">

                    <a href="#" class="flex items-center px-3 py-3 text-sm rounded-t-lg font-semibold text-gray-700">
                        <svg class="h-4 w-4 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4M17 17h4M19 6c0 1.657-3.582 3-8 3s-8-1.343-8-3 3.582-3 8-3 8 1.343 8 3zM17 14c0 1.657-3.582 3-8 3s-8-1.343-8-3 3.582-3 8-3 8 1.343 8 3z" />
                        </svg>
                        Article with AI
                    </a>

                    <a href="#" class="flex items-center justify-between px-3 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Article
                        </span>
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <hr class="border-gray-200 mx-3">

                    <a href="#" class="flex items-center justify-between px-3 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.466 9.475 5 8 5c-1.636 0-3.13 0.615-4.243 1.728S2 9.172 2 10.833c0 1.66 0.615 3.154 1.728 4.243S6.36 17.833 8 17.833c1.475 0 2.832-0.466 4-1.253M12 6.253c1.168 0.787 2.525 1.253 4 1.253 1.636 0 3.13-0.615 4.243-1.728S22 10.833 22 10.833s-0.615-3.154-1.728-4.243S17.636 5 16 5c-1.475 0-2.832 0.466-4 1.253" />
                            </svg>
                            Step by step guide
                        </span>
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">NEW</span>
                    </a>

                    <hr class="border-gray-200 mx-3">

                    <a href="#" class="flex items-center px-3 py-3 text-sm text-gray-700 hover:bg-gray-100 rounded-b-lg">
                        <svg class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        Sub category
                    </a>
                </div>
            </div>
        </header>

        <main class="fly-layout-main">
            <nav class="fly-sidebar-nav fly-bg-white fly-border-r">
                <div class="fly-sidebar-section">
                    <a href="#" class="fly-sidebar-link"><i class="fa-solid fa-building"></i> Site builder <i class="fa-solid fa-chevron-right fly-text-xs"></i></a>
                    <a href="#" class="fly-sidebar-link"><i class="fa-solid fa-screwdriver-wrench"></i> Content tools <i class="fa-solid fa-chevron-right fly-text-xs"></i></a>
                    <hr class="fly-divider fly-my-3">
                </div>

                <div class="fly-category-title">CATEGORIES & ARTICLES</div>

                <ul class="fly-nav-tree">
                    <template x-for="category in navItems" :key="category.name">
                        <li>
                            {{-- Category Item (Clickable to expand/collapse and set as active) --}}
                            <div
                                @click="setActive(category)"
                                class="fly-menu-item fly-menu-item--category"
                                :class="{
                                    'fly-menu-item--active fly-border-l-4 fly-border-primary': isActive(category) || (activeSelection.type === 'article' && category.name === activeSelection.articleData.parentName),
                                    'fly-menu-item--hover': !isActive(category)
                                }"
                            >
                                <i class="fa-solid fa-chevron-right fly-text-xs fly-w-4 fly-transition" :class="{'fly-rotate-90': category.isOpen}"></i>
                                <i :class="[category.icon, {'fly-text-primary': isActive(category) || category.isOpen}]"></i>
                                <span x-text="category.name"></span>
                            </div>

                            {{-- Nested Articles --}}
                            <ul x-show="category.isOpen" x-transition.slide.down class="fly-nav-tree-nested">
                                <template x-for="article in category.articles" :key="article.id">
                                    <li>
                                        <div
                                            @click="setActive(article, category)"
                                            class="fly-menu-item fly-menu-item--article"
                                            :class="{
                                                'fly-menu-item--active fly-border-l-4 fly-border-primary': isActive(article, category),
                                                'fly-menu-item--hover': !isActive(article, category)
                                            }"
                                        >
                                            <span class="fly-w-4"></span> {{-- Alignment spacer --}}
                                            <i class="fa-solid fa-file-lines fly-text-gray-500" :class="{'fly-text-primary': isActive(article, category)}"></i>
                                            <span x-text="article.title"></span>
                                            <i class="fa-solid fa-circle fly-text-warning fly-text-xxs" x-show="article.status === 'Draft'"></i>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </li>
                    </template>
                </ul>
            </nav>

            <section class="fly-main-panel fly-p-6">
                <div class="fly-path-title" x-text="activeSelection.path"></div>

                <h1 class="fly-section-header">
                    <i class="fa-regular fa-star fly-text-warning-500"></i>
                    <span x-text="activeSelection.type === 'article' ? activeSelection.articleData.title : activeSelection.name">New Article</span>
                </h1>

                <div class="fly-card fly-card--table">
                    <table class="fly-data-table">
                        <thead>
                            <tr class="fly-data-table-header">
                                <th class="fly-w-10"><input type="checkbox"></th>
                                <th class="fly-col-title">Title</th>
                                <th class="fly-w-24">Status</th>
                                <th>Tags</th>
                                <th class="fly-w-32">Updated on</th>
                                <th class="fly-w-20">Labels <i class="fa-solid fa-circle-info"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="article in activeSelection.articles" :key="article.id">
                                <tr class="fly-data-table-row" :class="{'fly-row--highlight': isActive(article, { name: 'Placeholder' })}">
                                    <td><input type="checkbox"></td>
                                    <td class="fly-text-title">
                                        <a href="#" class="fly-link fly-link--subtle fly-text-primary">
                                            <i class="fa-solid fa-clipboard fly-text-warning-500 fly-mr-2"></i>
                                            <span x-text="article.title"></span>
                                        </a>
                                    </td>
                                    <td class="fly-text-secondary" x-text="article.status"></td>
                                    <td>
                                        <div class="fly-tag-list" x-show="article.tags.length > 0">
                                            <span class="fly-tag fly-tag--neutral" x-text="article.tags[0] + '...'"></span>
                                            <span class="fly-tag-count" x-show="article.tags.length > 1" x-text="'+' + (article.tags.length - 1)"></span>
                                        </div>
                                    </td>
                                    <td class="fly-text-secondary" x-text="article.updated"></td>
                                    <td></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="fly-data-table-footer">
                    <span x-text="activeSelection.articles ? (activeSelection.articles.length > 0 ? '1 - ' + activeSelection.articles.length + ' of ' + activeSelection.articles.length + ' items' : '0 items') : '0 items'"></span>
                </div>
            </section>
        </main>
    </div>

    {{-- Custom styles to map to suggested Flyon-like class names (REMOVE if using actual Flyon CSS) --}}
    <style>
    /* --- Layout & Structure (Assumed Flyon classes) --- */
    .fly-layout-container { display: flex; flex-direction: column; min-height: 100vh; background-color: #f8f8f8; }
    .fly-topbar { display: flex; justify-content: space-between; align-items: center; padding: 10px 24px; border-bottom: 1px solid #e0e0e0; background-color: #ffffff; height: 56px; }
    .fly-topbar-left, .fly-topbar-right { display: flex; align-items: center; gap: 8px; }
    .fly-layout-main { display: flex; flex-grow: 1; overflow: hidden; }
    .fly-sidebar-nav { width: 300px; flex-shrink: 0; overflow-y: auto; background-color: #ffffff; border-right: 1px solid #e0eeef; }
    .fly-main-panel { flex-grow: 1; overflow-y: auto; }
    .fly-divider { border: 0; border-top: 1px solid #e0e0e0; margin: 16px 0; }
    .fly-w-10 { width: 40px; } .fly-w-24 { width: 96px; } .fly-w-32 { width: 128px; }

    /* --- Buttons & Icons --- */
    .fly-icon-button { background: none; border: none; color: #888; padding: 8px; cursor: pointer; }
    .fly-button { background-color: #5d3ebc; color: white; border: none; padding: 8px 15px; border-radius: 4px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; }
    .fly-button--split { position: relative; padding-right: 32px; }
    .fly-button--split i { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); padding-left: 10px; }
    .fly-button--split::after { content: ''; position: absolute; right: 35px; top: 0; bottom: 0; width: 1px; background-color: rgba(255, 255, 255, 0.3); }

    /* --- Sidebar Navigation --- */
    .fly-category-title { color: #888; font-size: 11px; text-transform: uppercase; padding: 15px 28px 5px; font-weight: 600; }
    .fly-sidebar-section { padding: 0 16px; }
    .fly-sidebar-link { display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; border-radius: 4px; cursor: pointer; font-weight: 400; font-size: 13px; text-decoration: none; color: #333; }
    .fly-nav-tree { list-style: none; padding: 0 0 0 16px; }
    .fly-nav-tree-nested { list-style: none; padding-left: 16px; margin-top: 4px; }
    .fly-menu-item { display: flex; align-items: center; padding: 6px 12px; margin: 2px 0; cursor: pointer; font-size: 13px; gap: 8px; transition: background-color 0.1s, border-left 0.1s; }
    .fly-menu-item--article { padding-left: 0; } /* Articles indented visually */
    .fly-menu-item--hover:hover { background-color: #f7f7f7; }

    /* Active/Selected State (Key to the visual) */
    .fly-menu-item--active { background-color: #e6e6ff; /* Light Purple */ color: #5d3ebc; /* Primary Purple */ font-weight: 700; border-left: 3px solid #5d3ebc; padding-left: 9px; }
    .fly-menu-item--active.fly-menu-item--category { border-left: 3px solid #5d3ebc; padding-left: 9px; }
    .fly-menu-item--active i:not(.fa-chevron-right) { color: #5d3ebc !important; }

    /* --- Main Panel --- */
    .fly-path-title { color: #888; font-size: 12px; margin-bottom: 5px; }
    .fly-section-header { display: flex; align-items: center; font-size: 20px; font-weight: 500; margin-bottom: 20px; color: #333; }
    .fly-section-header i { margin-right: 5px; color: #888; }
    .fly-text-warning-500 { color: #FFC107; }
    .fly-text-primary { color: #5d3ebc; }
    .fly-text-secondary { color: #888; }
    .fly-text-xxs { font-size: 0.5rem; }

    /* --- Table Styles --- */
    .fly-card { background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; }
    .fly-data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .fly-data-table-header th { color: #2a2246; font-size: 14px; font-weight: 530; border-bottom: 1px solid #e0e0e0; padding: 12px 10px 12px 0; text-align: left; }
    .fly-data-table-row td { padding: 10px 10px 10px 0; border-bottom: 1px solid #f5f5f5; }
    .fly-row--highlight { background-color: #faf7ff; } /* Light highlight for the active row if needed */
    .fly-data-table-footer { text-align: right; padding: 8px; font-size: 13px; color: #666; }

    /* Tags */
    .fly-tag { background-color: #f0f0f0; color: #333; padding: 2px 6px; border-radius: 4px; font-size: 12px; white-space: nowrap; }
    .fly-tag-list { display: flex; align-items: center; gap: 5px; }
    .fly-tag-count { color: #5d3ebc; font-size: 12px; }
    </style>
@endsection
