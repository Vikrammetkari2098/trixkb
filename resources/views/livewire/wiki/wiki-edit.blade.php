<div class="p-6 bg-white shadow rounded-lg">
    <x-errors />

    <form id="form-edit" wire:submit.prevent="update" enctype="multipart/form-data">
        @csrf

        <!-- Title / Category / Space -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Title -->
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
            <div x-data="dropdown(
                @js($categories->map(fn($i) => ['text' => $i->category_name, 'value' => $i->category_id])),
                @entangle('category_ids')
            )"
                 x-init="init()"
                 wire:ignore
            >
                <label class="block text-sm font-medium text-gray-700 mb-1">Quick Link / Category *</label>
                <select x-ref="select" multiple></select>
            </div>

            <!-- Spaces -->
            <div x-data="dropdown(
                @js($spaces->map(fn($i) => ['text' => $i->name, 'value' => $i->id])),
                @entangle('space_ids')
            )"
                 x-init="init()"
                 wire:ignore
            >
                <label class="block text-sm font-medium text-gray-700 mb-1">Space *</label>
                <select x-ref="select" multiple></select>
            </div>
        </div>

        <!-- Organisation -->
        <div class="mt-4">
            <div x-data="dropdown(
                @js($organisations->map(fn($i) => ['text' => $i->name, 'value' => $i->id])),
                @entangle('organisation_id')
            )"
                 x-init="init()"
                 wire:ignore
            >
                <label class="block text-sm font-medium text-gray-700 mb-1">Organisation *</label>
                <select x-ref="select"></select>
            </div>
        </div>

        <!-- Ministry / Department / Segment -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

            <!-- Ministry -->
            <div x-data="dropdown(
                @js($ministries->map(fn($i) => ['text' => $i->name, 'value' => $i->ministry_id])),
                @entangle('ministry_id')
            )"
                 x-init="init()"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ministry *</label>
                <select x-ref="select"></select>
            </div>

            <!-- Department -->
            <div x-data="dropdown(
                @js($departments->map(fn($i) => ['text' => $i->name, 'value' => $i->department_id])),
                @entangle('department_id')
            )"
                 x-init="init()"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select x-ref="select"></select>
            </div>

            <!-- Segment -->
            <div x-data="dropdown(
                @js($segments->map(fn($i) => ['text' => $i->name, 'value' => $i->segment_id])),
                @entangle('segment_id')
            )"
                 x-init="init()"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Division / Segment</label>
                <select x-ref="select"></select>
            </div>
        </div>

        <!-- Attachments -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

            <!-- Attachment 1 -->
            <div>
                <x-input type="file" label="Attachment 1" wire:model="appendix_1" />
                @if($existing_appendix_1)
                    <a href="{{ $existing_appendix_1 }}" class="text-blue-500 text-sm mt-1 block" target="_blank">
                        View Existing File
                    </a>
                @endif
            </div>

            <!-- Attachment 2 -->
            <div>
                <x-input type="file" label="Attachment 2" wire:model="appendix_2" />
                @if($existing_appendix_2)
                    <a href="{{ $existing_appendix_2 }}" class="text-blue-500 text-sm mt-1 block" target="_blank">
                        View Existing File
                    </a>
                @endif
            </div>

        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">

            <x-input label="Active Date *" wire:model="active_date" type="datetime-local" />
            <x-input label="Expiry Date" wire:model="expiry_date" type="datetime-local" />
            <x-input label="Start Date *" wire:model="start_date" type="datetime-local" />
            <x-input label="End Date *" wire:model="end_date" type="datetime-local" />

        </div>

        <!-- Calendar Checkbox -->
        <div class="mt-4 flex items-center">
            <input type="checkbox" id="is_calendar" wire:model="is_calendar" class="mr-2">
            <label for="is_calendar" class="font-medium text-gray-700">Display in Calendar</label>
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-textarea label="Description" wire:model.defer="description" rows="5" />
        </div>

        <!-- Submit -->
        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>Update Article</x-button>
        </div>

    </form>
</div>


<!-- TomSelect Alpine Component -->
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('refresh-tomselect', () => {
            document.querySelectorAll('[x-data^="dropdown"]').forEach((el) => {
                if (el.__x && el.__x.$data.tom) {
                    let tom = el.__x.$data.tom;

                    // Clear old values
                    tom.clear(true);

                    // Get latest Livewire-bound value
                    let boundVal = el.__x.$data.value;

                    if (Array.isArray(boundVal)) {
                        boundVal.forEach(v => tom.addItem(v));
                    } else if (boundVal) {
                        tom.addItem(boundVal);
                    }
                }
            });
        });
    });
</script>

