<div>
    <x-errors />

    <form id="form-create-article" wire:submit.prevent="save">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

            <!-- Title -->
            <div class="sm:col-span-2">
                <x-input label="Title *" id="title" wire:model.defer="title" />
            </div>

            <!-- Slug -->
            <div class="sm:col-span-2">
                <x-input label="Slug (optional)" id="slug" wire:model.defer="slug" />
            </div>

            <!-- Category -->
            <div x-data="createCategory()" class="sm:col-span-2 relative">
                <button @click="open = !open" type="button"
                        class="w-full bg-white border rounded-md pl-3 pr-10 py-2 text-left">
                    <span x-text="selectedLabel || 'Select a category'"></span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3l5 5-1.4 1.4L10 5.4 6.4 9.7 5 8.3l5-5z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </button>

                <div x-show="open" x-transition @click.away="open = false"
                     class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 max-h-60 overflow-auto">
                    <template x-for="option in categoriesOptions" :key="option.value">
                        <div @click="select(option)" class="cursor-pointer py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                            <span x-text="option.label" :class="{'font-semibold': selectedValue === option.value}"></span>
                        </div>
                    </template>
                </div>

                <input type="hidden" wire:model="category_id" :value="selectedValue">
            </div>

            <!-- Tags -->
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium">Tags</label>
                <select wire:model="tags" multiple class="w-full mt-1 px-3 py-2 border rounded-md">
                    @foreach($allTags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Advanced Options -->
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
                            <select wire:model="status" class="w-full mt-1 px-3 py-2 border rounded-md">
                                <option value="draft">Draft</option>
                                <option value="in_review">In Review</option>
                                <option value="published">Published</option>
                            </select>
                        </div>

                        <!-- Published At -->
                        <div>
                            <label class="block text-sm font-medium">Published At</label>
                            <input type="datetime-local" wire:model="published_at" class="w-full mt-1 px-3 py-2 border rounded-md">
                        </div>

                        <!-- Featured -->
                        <div class="flex items-center space-x-2 mt-2">
                            <input type="checkbox" wire:model="is_featured">
                            <span>Featured</span>
                        </div>

                    </div>
                </details>
            </div>

            <!-- Author / Editor -->
            <div class="sm:col-span-2 grid grid-cols-2 gap-4">
                <div>
                    <label>Author</label>
                    <select wire:model="author_id" class="w-full border rounded-md px-3 py-2">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Editor (optional)</label>
                    <select wire:model="editor_id" class="w-full border rounded-md px-3 py-2">
                        <option value="">-- None --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Content -->
            <div class="sm:col-span-2">
                <label class="block font-medium">Content *</label>
                <textarea wire:model.defer="content" class="w-full h-60 border rounded-md p-3 mt-2"></textarea>
                @error('content')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>Create Article</x-button>
        </div>
    </form>
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
