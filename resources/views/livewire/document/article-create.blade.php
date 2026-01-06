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

            <!-- Article Image -->
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Article Image
                </label>

                <input
                    type="file"
                    wire:model="article_image"
                    accept="image/*"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100"
                />

                <!-- Preview -->
                @if ($article_image)
                    <div class="mt-3">
                        <img
                            src="{{ $article_image->temporaryUrl() }}"
                            class="h-40 rounded-lg object-cover border"
                        />
                    </div>
                @endif

                @error('article_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                        class="btn btn-soft btn-primary waves waves-primary"
                    >
                        + Add
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Can't find your category? Click "Add" to create a new one.
                </p>
            </div>

            <!-- Advanced Section -->
            <div class="sm:col-span-2 mt-4">
                <div x-data="{ open: false }" class="sm:col-span-2 mt-4">
                    <!-- Header -->
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center font-medium text-gray-700"
                    >
                        <span
                            class="transition-transform mr-2"
                            :class="{ 'rotate-180': open }"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                            </svg>
                        </span>
                        Advanced
                    </button>

                    <!-- Content -->
                    <div
                        x-show="open"
                        x-transition
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6"
                    >
                       <!-- Tags -->
                            <div
                                class="w-full"
                                wire:ignore
                                x-data
                                x-init="
                                    new TomSelect($refs.tags, {
                                        plugins: ['remove_button'],
                                        create: true,
                                        persist: false,
                                        placeholder: 'Search or create tags',
                                        valueField: 'value',
                                        labelField: 'text',
                                        searchField: 'text',

                                        load(query, callback) {
                                            if (!query.length) return callback();
                                            $wire.call('searchTags', query).then(callback);
                                        },

                                        onChange(values) {
                                            $wire.set('tags', values);
                                        }
                                    });
                                "
                            >
                                <!-- TallStack-style label -->
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tags
                                </label>

                                <!-- TallStack-style wrapper -->
                                <div class="relative">
                                    <select
                                        x-ref="tags"
                                        multiple
                                        class="
                                            block w-full rounded-md border-gray-300
                                            focus:border-blue-500 focus:ring-blue-500
                                            min-h-[38px]
                                        "
                                    ></select>
                                </div>

                                @error('tags')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        <!-- Labels -->
                            <div
                                class="w-full"
                                wire:ignore
                                x-data
                                x-init="
                                    new TomSelect($refs.labels, {
                                        plugins: ['remove_button'],
                                        create: true,
                                        persist: false,
                                        placeholder: 'Search or create labels',
                                        valueField: 'value',
                                        labelField: 'text',
                                        searchField: 'text',

                                        load(query, callback) {
                                            if (!query.length) return callback();
                                            $wire.call('searchLabels', query).then(callback);
                                        },

                                        onChange(values) {
                                            $wire.set('labels', values);
                                        }
                                    });
                                "
                            >
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Labels
                                </label>

                                <div class="relative">
                                    <select
                                        x-ref="labels"
                                        multiple
                                        class="
                                            block w-full rounded-md border-gray-300
                                            focus:border-blue-500 focus:ring-blue-500
                                            min-h-[38px]
                                        "
                                    ></select>
                                </div>

                                @error('labels')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <!-- Status -->
                        <x-select.styled
                            label="Status"
                            :options="[
                                ['label' => 'Draft', 'value' => 'draft'],
                                ['label' => 'In Review', 'value' => 'in_review'],
                                ['label' => 'Published', 'value' => 'published'],
                            ]"
                            select="label:label|value:value"
                            wire:model.defer="status"
                        />

                        <!-- Author -->
                        <x-select.styled
                            label="Author *"
                            :options="$users->map(fn($user) => ['label' => $user->name, 'value' => $user->id])->toArray()"
                            select="label:label|value:value"
                            wire:model.defer="author_id"
                        />
                        <!-- KB Type -->
                        <x-select.styled
                            label="KB Type"
                            :options="[
                                ['label' => 'Article', 'value' => 'article'],
                                ['label' => 'Directory', 'value' => 'directory'],
                            ]"
                            select="label:label|value:value"
                            wire:model.defer="kb_type"
                        />

                        <!-- Visibility -->
                        <x-select.styled
                            label="Visibility"
                            :options="[
                                ['label' => 'Public', 'value' => 'public'],
                                ['label' => 'Internal', 'value' => 'internal'],
                            ]"
                            select="label:label|value:value"
                            wire:model.defer="visibility"
                        />
                    </div>
                </div>
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
                        <select
                            wire:model.defer="newCategory.location"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="getting_started">Getting Started</option>
                            <option value="documentation">Documentation</option>
                            <option value="advanced">Advanced</option>
                            <option value="tutorials">Tutorials</option>
                            <option value="api">API Reference</option>
                        </select>
                    </div>

                    <!-- Category Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Category Type</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach(['folder','index','page','github'] as $type)
                                <button
                                    type="button"
                                    wire:click="$set('newCategory.type', '{{ $type }}')"
                                    :class="$wire.newCategory.type === '{{ $type }}' ? 'border-blue-600 ring-2 ring-blue-200 bg-blue-50' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                    class="flex flex-col items-center p-3 border rounded-lg transition-all duration-200"
                                >
                                    <span class="text-xs font-medium">{{ ucfirst($type) }}</span>
                                </button>
                            @endforeach
                        </div>
                        @error('newCategory.type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 p-4 bg-gray-50 border-t border-gray-100">
                    <button
                        type="button"
                        wire:click="$set('showCategoryModal', false)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        wire:click="createCategory"
                        :disabled="!$wire.newCategory.name.trim()"
                        :class="!$wire.newCategory.name.trim() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md"
                    >
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
