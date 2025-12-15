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

            <div class="sm:col-span-2">
                <x-select.styled
                    label="Category *"
                    :options="$categories"
                    wire:model.defer="category_id"
                    id="category"
                />
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
                        ['name' => 'Draft', 'id' => 'draft'],
                        ['name' => 'In Review', 'id' => 'in_review'],
                        ['name' => 'Published', 'id' => 'published'],
                    ]"
                    select="label:name|value:id"
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
                        'name' => $user->name,
                        'id'   => $user->id
                    ])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="author_id"
                    id="author"
                />
            </div>

            <!-- Editor -->
            <div>
                <x-select.styled
                    label="Editor (optional)"
                    :options="$users->map(fn($user) => [
                        'name' => $user->name,
                        'id'   => $user->id
                    ])->toArray()"
                    select="label:name|value:id"
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
</div>
