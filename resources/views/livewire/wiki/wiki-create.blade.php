<div class="p-6 bg-white shadow rounded-lg">
    <x-errors />

    <form id="form-create" wire:submit.prevent="register" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input
                    label="Title *"
                    id="name"
                    wire:model.defer="name"
                    required
                    placeholder="Enter article title"
                />
            </div>

            <!-- Categories -->
            <div x-data="dropdown(@js($categories->map(fn($item) => ['text' => $item->category_name, 'value' => $item->category_id])->toArray()), @entangle('category_ids'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quick Link / Category *</label>
                <select x-ref="select" multiple class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Spaces  -->
            <div x-data="dropdown(@js($spaces->map(fn($item) => ['text' => $item['name'], 'value' => $item['id']])->toArray()), @entangle('space_ids'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Space *</label>
                <select x-ref="select" multiple class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>
        </div>

        <!-- Organisation  -->
        <div class="grid grid-cols-1 gap-6 mt-4">
            <div x-data="dropdown(@js($organisations->map(fn($item) => ['text' => $item->name, 'value' => $item->id])->toArray()), @entangle('organisation_id'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Organisation *</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>
        </div>

        <!-- Ministry / Department / Division -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
            <!-- Ministry -->
            <div x-data="dropdown(@js($ministries->map(fn($item) => ['text' => $item['name'], 'value' => $item->ministry_id])->toArray()), @entangle('ministry_id'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ministry *</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Department -->
            <div x-data="dropdown(@js($departments->map(fn($item) => ['text' => $item['name'], 'value' => $item->department_id])->toArray()), @entangle('department_id'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Division / Segment -->
            <div x-data="dropdown(@js($segments->map(fn($item) => ['text' => $item['name'], 'value' => $item->segment_id])->toArray()), @entangle('segment_id'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Division / Segment</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>
        </div>

        <!-- Attachments -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div>
                <x-input type="file" label="Attachment 1" id="appendix_1" wire:model="appendix_1" />
            </div>
            <div>
                <x-input type="file" label="Attachment 2" id="appendix_2" wire:model="appendix_2" />
            </div>
        </div>

        <!-- Dates & Calendar -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
            <x-input label="Active Date *" wire:model="active_date" type="datetime-local" id="active_date" />
            <x-input label="Expiry Date" wire:model="expiry_date" type="datetime-local" id="expiry_date" />
            <x-input label="Start Date *" wire:model="start_date" type="datetime-local" id="start_date" />
            <x-input label="End Date *" wire:model="end_date" type="datetime-local" id="end_date" />

            <div class="flex items-center mt-2">
                <input type="checkbox" id="is_calendar" wire:model="is_calendar" class="form-check-input mr-2" />
                <label for="is_calendar" class="form-check-label font-medium text-gray-700">Display in Calendar</label>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-textarea label="Description" id="description" wire:model.defer="description" placeholder="Enter wiki description..." rows="5" />
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>Save Article</x-button>
        </div>
    </form>
</div>

<script>
    function dropdown(options, boundValue) {
        return {
            tom: null,
            options: options,
            value: boundValue,
            init() {
                this.tom = new TomSelect(this.$refs.select, {
                    options: this.options,
                    valueField: 'value',
                    labelField: 'text',
                    searchField: ['text'],
                    items: Array.isArray(this.value) ? this.value : (this.value ? [this.value] : []),
                    onItemAdd: (val) => this.value = Array.isArray(this.value) ? [...this.value, val] : val,
                    onItemRemove: (val) => {
                        if(Array.isArray(this.value)) {
                            this.value = this.value.filter(v => v != val);
                        } else {
                            this.value = null;
                        }
                    },
                    maxItems: null, // allow multiple selection if needed
                    closeAfterSelect: false,
                    persist: false
                });
            }
        }
    }
</script>
