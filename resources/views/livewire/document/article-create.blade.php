<div>
    <x-errors />

    <form id="form-create-article" wire:submit.prevent="save">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <!-- Title -->
            <div class="sm:col-span-2">
                <x-input
                    label="Title *"
                    id="title"
                    wire:model.defer="title"
                    invalidate
                />
            </div>

            <!-- Slug -->
            <div class="sm:col-span-2">
                <x-input
                    label="Slug (optional)"
                    id="slug"
                    wire:model.defer="slug"
                />
            </div>

            <!-- Category with Add Button -->
            <div class="sm:col-span-2">
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <x-select.styled
                            label="Category *"
                            :options="$categories"
                            wire:model.defer="category_id"
                            id="category"
                        />
                    </div>
                    <button
                        type="button"
                        wire:click="$set('showCategoryModal', true)"
                        class="flex-shrink-0 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    >
                        + Add
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Can't find your category? Click "Add" to create a new one.</p>
            </div>

            <!-- Tags -->
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium mb-1">Tags</label>
                <select
                    wire:model.defer="tags"
                    multiple
                    class="w-full px-3 py-2 border rounded-md"
                >
                    @foreach ($allTags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <x-select.styled
                    label="Status"
                    :options="[
                        ['label' => 'Draft', 'value' => 'draft'],
                        ['label' => 'In Review', 'value' => 'in_review'],
                        ['label' => 'Published', 'value' => 'published'],
                    ]"
                    select="label:label|value:value"
                    wire:model.defer="status"
                    id="status"
                />
            </div>

            <!-- Published At -->
            <div>
                <x-input
                    type="datetime-local"
                    label="Published At"
                    id="published_at"
                    wire:model.defer="published_at"
                />
            </div>

            <!-- Author -->
            <div>
                <x-select.styled
                    label="Author *"
                    :options="$users->map(fn($user) => [
                        'label' => $user->name,
                        'value' => $user->id
                    ])->toArray()"
                    select="label:label|value:value"
                    wire:model.defer="author_id"
                    id="author"
                />
            </div>

            <!-- Editor -->
            <div>
                <x-select.styled
                    label="Editor (optional)"
                    :options="$users->map(fn($user) => [
                        'label' => $user->name,
                        'value' => $user->id
                    ])->toArray()"
                    select="label:label|value:value"
                    wire:model.defer="editor_id"
                    id="editor"
                />
            </div>

            <!-- Featured -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <input
                    type="checkbox"
                    wire:model.defer="is_featured"
                    class="rounded border-gray-300"
                />
                <span class="text-sm">Featured</span>
            </div>

            <!-- Content -->
            <div class="sm:col-span-2">
                <label class="block font-medium">Content *</label>
                <textarea
                    wire:model.defer="content"
                    class="w-full h-60 border rounded-md p-3 mt-2"
                ></textarea>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>
                Create Article
            </x-button>
        </div>
    </form>

    <!-- Add Category Modal -->
    <div x-cloak>
        <!-- Modal Backdrop -->
        <div
            x-show="$wire.showCategoryModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            x-on:keydown.escape.window="$wire.set('showCategoryModal', false)"
            style="display: none;"
        >
            <!-- Modal Content -->
            <div
                x-show="$wire.showCategoryModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                x-on:click.away="$wire.set('showCategoryModal', false)"
                class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden"
            >
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Create New Category</h3>
                    <button
                        x-on:click="$wire.set('showCategoryModal', false)"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-5 space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="newCategory.name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter category name"
                        />
                        @error('newCategory.name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Location</label>
                        <div class="relative">
                            <select
                                wire:model.defer="newCategory.location"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none"
                            >
                                <option value="getting_started">Getting Started</option>
                                <option value="documentation">Documentation</option>
                                <option value="advanced">Advanced</option>
                                <option value="tutorials">Tutorials</option>
                                <option value="api">API Reference</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Type -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium text-gray-600">Category Type</label>
                            <a href="#" class="text-sm text-blue-500 hover:underline hover:text-blue-600 transition-colors duration-200">
                                Learn more
                            </a>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <!-- Folder Type -->
                            <button
                                type="button"
                                wire:click="$set('newCategory.type', 'folder')"
                                :class="$wire.newCategory.type === 'folder'
                                    ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50'
                                    : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                class="flex flex-col items-center p-3 border rounded-lg transition-all duration-200"
                            >
                                <div :class="$wire.newCategory.type === 'folder' ? 'bg-blue-100' : 'bg-gray-50'" class="p-2 rounded-md mb-1">
                                    <svg class="w-6 h-6" :class="$wire.newCategory.type === 'folder' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium" :class="$wire.newCategory.type === 'folder' ? 'text-blue-600' : 'text-gray-500'">
                                    Folder
                                </span>
                            </button>

                            <!-- Index Type -->
                            <button
                                type="button"
                                wire:click="$set('newCategory.type', 'index')"
                                :class="$wire.newCategory.type === 'index'
                                    ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50'
                                    : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                class="flex flex-col items-center p-3 border rounded-lg transition-all duration-200"
                            >
                                <div :class="$wire.newCategory.type === 'index' ? 'bg-blue-100' : 'bg-gray-50'" class="p-2 rounded-md mb-1">
                                    <svg class="w-6 h-6" :class="$wire.newCategory.type === 'index' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium" :class="$wire.newCategory.type === 'index' ? 'text-blue-600' : 'text-gray-500'">
                                    Index
                                </span>
                            </button>

                            <!-- Page Type -->
                            <button
                                type="button"
                                wire:click="$set('newCategory.type', 'page')"
                                :class="$wire.newCategory.type === 'page'
                                    ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50'
                                    : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                class="flex flex-col items-center p-3 border rounded-lg transition-all duration-200"
                            >
                                <div :class="$wire.newCategory.type === 'page' ? 'bg-blue-100' : 'bg-gray-50'" class="p-2 rounded-md mb-1">
                                    <svg class="w-6 h-6" :class="$wire.newCategory.type === 'page' ? 'text-blue-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium" :class="$wire.newCategory.type === 'page' ? 'text-blue-600' : 'text-gray-500'">
                                    Page
                                </span>
                            </button>

                            <!-- GitHub Type -->
                            <button
                                type="button"
                                wire:click="$set('newCategory.type', 'github')"
                                :class="$wire.newCategory.type === 'github'
                                    ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50'
                                    : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                class="flex flex-col items-center p-3 border rounded-lg transition-all duration-200"
                            >
                                <div :class="$wire.newCategory.type === 'github' ? 'bg-blue-100' : 'bg-gray-50'" class="p-2 rounded-md mb-1">
                                    <svg class="w-6 h-6" :class="$wire.newCategory.type === 'github' ? 'text-blue-600' : 'text-gray-400'" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium" :class="$wire.newCategory.type === 'github' ? 'text-blue-600' : 'text-gray-500'">
                                    GitHub
                                </span>
                            </button>
                        </div>
                        @error('newCategory.type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 p-4 bg-gray-50 border-t border-gray-100">
                    <button
                        type="button"
                        wire:click="$set('showCategoryModal', false)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        wire:click="createCategory"
                        :disabled="!$wire.newCategory.name.trim()"
                        :class="!$wire.newCategory.name.trim() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    >
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
