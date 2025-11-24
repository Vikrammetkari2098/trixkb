<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6">
    <x-errors />

    <form wire:submit.prevent="save" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Ministry -->
            <div x-data="dropdown(@js($ministries), @entangle('ministry_id'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ministry *</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Department -->
            <div x-data="dropdown(@js($departments), @entangle('department_id'))"
                 x-init="init()"
                 @departments-updated.window="updateOptions(@js($departments))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select x-ref="select" :disabled="!$wire.ministry_id" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Case Category -->
            <div x-data="dropdown(@js($caseCategories), @entangle('case_category_id'))"
                 x-init="init()"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Case Category *</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Sub Case Category 1 -->
            <div x-data="dropdown(@js($subCaseCategories1), @entangle('sub_case_category_1_id'))"
                 x-init="init()"
                 @subcase1-updated.window="updateOptions(@js($subCaseCategories1))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Case Category 1</label>
                <select x-ref="select"
                        :disabled="!$wire.case_category_id"
                        class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Sub Case Category 2 -->
            <div x-data="dropdown(@js($subCaseCategories2), @entangle('sub_case_category_2_id'))"
                 x-init="init()"
                 @subcase2-updated.window="updateOptions(@js($subCaseCategories2))"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Case Category 2</label>
                <select x-ref="select"
                        :disabled="!$wire.sub_case_category_1_id"
                        class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

            <!-- Status -->
            <div x-data="dropdown(@js($statusOptions), @entangle('status'))"
                 x-init="init()"
                 wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select x-ref="select" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
            </div>

        </div>

        <div class="flex justify-end pt-6 border-t">
            <x-button type="submit" color="green" loading>Save Category Matrix</x-button>
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

                window.addEventListener('reset-tomselect', () => {
                    this.tom.clear(true);
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
