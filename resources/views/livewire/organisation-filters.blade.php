<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6">
    <x-errors />

    <form wire:submit.prevent="applySearch" class="space-y-6">

        <!-- Row 1: Ministry & Department -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Ministry -->
            <div x-data="dropdown(@js($ministries_list), @entangle('ministryFilter'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ministry</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Department -->
            <div x-data="dropdown(@js($departments_list), @entangle('departmentFilter'))"
                 x-init="init()"
                 @departments-updated.window="updateOptions(@js($departments_list))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select x-ref="select" :disabled="!$wire.ministryFilter" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>
        </div>

        <!-- Row 2: Division & Unit -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Segment -->
            <div x-data="dropdown(@js($segments_list), @entangle('segmentFilter'))"
                 x-init="init()"
                 @segments-updated.window="updateOptions(@js($segments_list))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Division/Segment</label>
                <select x-ref="select" :disabled="!$wire.departmentFilter" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Unit -->
            <div x-data="dropdown(@js($units_list), @entangle('unitFilter'))"
                 x-init="init()"
                 @units-updated.window="updateOptions(@js($units_list))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit/Section</label>
                <select x-ref="select" :disabled="!$wire.segmentFilter" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>
        </div>

        <!-- Row 3: Sub Unit & Search -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Sub Unit -->
            <div x-data="dropdown(@js($sub_units_list), @entangle('subUnitFilter'))"
                 x-init="init()"
                 @subunits-updated.window="updateOptions(@js($sub_units_list))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Unit/Sub Section</label>
                <select x-ref="select" :disabled="!$wire.unitFilter" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       wire:model.defer="searchTerm"
                       placeholder="Enter name..."
                       class="rounded-md border-gray-300 w-full h-11 px-3 focus:ring focus:ring-indigo-200">
            </div>
        </div>

        <!-- Checkbox -->
        <div class="flex items-center">
            <x-checkbox
                label="Include child data?"
                wire:model="childDataIncluded"
            />
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t">
            <!-- Reset Button -->
            <button
                type="button"
                wire:click="resetFilters"
                class="btn btn-outline btn-error"
            >
                Reset
            </button>

            <!-- Search Button -->
            <button
                type="submit"
                class="btn btn-outline btn-success"
                wire:loading.attr="disabled"
            >
                Search
            </button>
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
                    items: this.value ? [this.value] : [],
                    onItemAdd: (val) => this.value = val,
                    onItemRemove: () => this.value = null,
                });

                // Listen for reset event from Livewire
                window.addEventListener('reset-tomselect', () => {
                    this.tom.clear(true); // true = do not trigger onChange
                    this.value = null;
                });
            },
            updateOptions(newOptions) {
                if (this.tom) {
                    this.tom.clearOptions();
                    this.tom.addOptions(newOptions);
                }
            }
        }
    }
</script>
