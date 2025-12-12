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

            <!-- Category -->
            <div x-data="createCategory()" class="sm:col-span-2 relative">

                <!-- Dropdown Button -->
                <button @click="open = !open" type="button"
                        class="w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer sm:text-sm">
                    <span x-text="selectedLabel || 'Select a category'"></span>

                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 3l5 5-1.4 1.4L10 5.4 6.4 9.7 5 8.3l5-5z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </span>
                </button>

                <!-- Dropdown Panel -->
                <div x-show="open" x-transition @click.away="open = false"
                     class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 max-h-60 overflow-auto">

                    <!-- Create Category -->
                    <div class="border-b border-gray-200 mb-1">
                        <button type="button"
                                class="w-full text-left text-blue-600 text-sm px-3 py-2 hover:underline"
                                @click="$modalOpen('modal-create-category')">
                            + Create Category
                        </button>
                    </div>

                    <!-- Category Options -->
                    <template x-for="option in categoriesOptions" :key="option.value">
                        <div @click="select(option)"
                             class="cursor-pointer py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                            <span x-text="option.label"
                                  :class="{'font-semibold': selectedValue === option.value}">
                            </span>
                        </div>
                    </template>
                </div>

                <!-- Hidden Input -->
                <input type="hidden" wire:model="category_id" :value="selectedValue">
            </div>

            <!-- Advanced Section -->
            <div class="sm:col-span-2">
                <details class="bg-gray-50 p-4 rounded-md border">
                    <summary class="cursor-pointer font-medium">Advanced Options</summary>

                    <div class="mt-4 space-y-3">

                        <!-- Editor Type -->
                        <div>
                            <label class="block text-sm font-medium">Editor Type</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" wire:model="editor_type" value="wysiwyg" class="form-radio">
                                    <span>Advanced WYSIWYG</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" wire:model="editor_type" value="markdown" class="form-radio">
                                    <span>Markdown</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium">Status</label>
                            <select wire:model="status"
                                    class="w-full mt-1 px-3 py-2 border rounded-md">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                        <!-- Published At -->
                        <div>
                            <label class="block text-sm font-medium">Published At</label>
                            <input type="datetime-local" wire:model="published_at"
                                   class="w-full mt-1 px-3 py-2 border rounded-md">
                        </div>

                        <!-- Order Index -->
                        <div>
                            <label class="block text-sm font-medium">Order (for sorting)</label>
                            <input type="number" wire:model="order_index"
                                   class="w-full mt-1 px-3 py-2 border rounded-md">
                        </div>

                        <!-- Pinned -->
                        <div class="flex items-center space-x-2 mt-2">
                            <input type="checkbox" wire:model="pinned">
                            <span>Pin this article</span>
                        </div>

                    </div>
                </details>
            </div>

            <!-- Content -->
            <div class="sm:col-span-2">
                <x-input label="Content *" id="content">
                    <textarea wire:model.defer="content"
                              class="w-full h-40 border-gray-300 rounded-md mt-2 focus:ring focus:border-indigo-500"></textarea>
                </x-input>
            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>
                Create Article
            </x-button>
        </div>
    </form>

    <!-- Modal: Create Category -->
    <x-modal id="modal-create-category" title="Create Category">
        <div class="p-6">

            <h2 class="text-xl font-semibold">Create New Category</h2>

            <!-- Name -->
            <div class="mt-6">
                <label class="block text-sm font-medium">Name</label>
                <input type="text" wire:model.defer="newCategory"
                       placeholder="Enter category name"
                       class="w-full mt-1 px-3 py-2 border rounded-md">
            </div>

            <!-- Parent Category -->
            <div class="mt-6">
                <label class="block text-sm font-medium">Parent Category</label>
                <select wire:model.defer="newCategoryParent"
                        class="w-full mt-1 px-3 py-2 border rounded-md">
                    <option value="">Root Level</option>
                    @foreach($categoriesOptions as $cat)
                        <option value="{{ $cat['value'] }}">{{ $cat['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type -->
            <div class="mt-6">
                <label class="block text-sm font-medium">Type <a href="#" class="text-blue-600 text-sm">Learn more</a></label>
                <div class="mt-3 grid grid-cols-4 gap-4">
                    <button type="button" class="border rounded-lg p-3 text-center hover:bg-gray-50"
                            wire:click.prevent="setCategoryType('folder')">
                        <div class="icon-[solar--folder-bold] size-10 text-gray-700"></div>
                        <div class="mt-2 text-sm">Folder</div>
                    </button>
                    <button type="button" class="border rounded-lg p-3 text-center hover:bg-gray-50"
                            wire:click.prevent="setCategoryType('index')">
                        <div class="icon-[solar--document-bold] size-10 text-gray-700"></div>
                        <div class="mt-2 text-sm">Index</div>
                    </button>
                    <button type="button" class="border rounded-lg p-3 text-center hover:bg-gray-50"
                            wire:click.prevent="setCategoryType('page')">
                        <div class="icon-[solar--document-add-bold] size-10 text-gray-700"></div>
                        <div class="mt-2 text-sm">Page</div>
                    </button>
                    <button type="button" class="border rounded-lg p-3 text-center hover:bg-gray-50"
                            wire:click.prevent="setCategoryType('github')">
                        <div class="text-gray-600 icon-[mdi--home] size-10"></div>
                        <div class="mt-2 text-sm">GitHub</div>
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 flex justify-between">
                <button type="button" class="px-4 py-2 border rounded-lg hover:bg-gray-100"
                        @click="$dispatch('close')">
                    ← Back to create article
                </button>
                <button wire:click="createCategory"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Create
                </button>
            </div>

        </div>
    </x-modal>
</div>

<!-- Alpine Data -->
<script>
function createCategory() {
    return {
        open: false,
        selectedValue: @entangle('category_id'),
        selectedLabel: '',
        categoriesOptions: @json($categoriesOptions),

        select(option) {
            this.selectedValue = option.value;
            this.selectedLabel = option.label;
            this.open = false;
        }
    }
}
</script>
