<div>
    <x-modal title="Edit Matrix" id="modal-edit-matrix" size="xl">
        <x-errors />

        <form wire:submit.prevent="update" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                <!-- Matrix Name -->
                <div>
                    <x-input label="Matrix Name *" wire:model.defer="name" />
                </div>

                <!-- Category -->
                <div class="sm:col-span-1">
                    <x-select.styled
                        label="Category *"
                        :options="[
                            ['id' => 1, 'name' => 'Kementerian'],
                            ['id' => 2, 'name' => 'Jabatan/Agensi'],
                            ['id' => 3, 'name' => 'Division'],
                            ['id' => 4, 'name' => 'Unit/Section/Cawangan'],
                            ['id' => 5, 'name' => 'Sub Unit/Sub Section/Sub Cawangan'],
                        ]"
                        select="label:name|value:id"
                        wire:model.defer="category"
                    />
                </div>

                <!-- Ministry -->
                <div x-data="dropdown(@js($ministries_list), @entangle('ministry_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ministry</label>
                    <select x-ref="select" placeholder="Select Ministry" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
                </div>

                <!-- Department -->
                <div x-data="dropdown(@js($departments_list), @entangle('department_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select x-ref="select" placeholder="Select Department" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
                </div>

                <!-- Segment -->
                <div x-data="dropdown(@js($segments_list), @entangle('segment_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Division / Segment</label>
                    <select x-ref="select" placeholder="Select Segment" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
                </div>

                <!-- Unit -->
                <div x-data="dropdown(@js($units_list), @entangle('unit_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit / Section</label>
                    <select x-ref="select" placeholder="Select Unit" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
                </div>

                <!-- Sub Unit -->
                <div x-data="dropdown(@js($sub_units_list), @entangle('sub_unit_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub Unit / Sub Section</label>
                    <select x-ref="select" placeholder="Select Sub Unit" class="rounded-md border-gray-300 w-full h-11 px-3"></select>
                </div>

                <!-- Status -->
                <div class="sm:col-span-1">
                    <x-select.styled
                        label="Status *"
                        :options="[
                            ['name' => 'Active', 'id' => 1],
                            ['name' => 'Inactive', 'id' => 0]
                        ]"
                        select="label:name|value:id"
                        wire:model.defer="status"
                    />
                </div>
            </div>

            <div class="flex justify-end mt-6 gap-3">
                <x-button flat wire:click="$dispatch('close-modal-edit-matrix')" label="Cancel" />
                <x-button type="submit" color="indigo" loading>Update Matrix</x-button>
            </div>
        </form>
    </x-modal>

    <script>
        function dropdown(options, boundValue) {
            return {
                tom: null,
                options: options.map(o => ({
                    value: o.value ?? o.id,
                    text: o.text ?? o.name
                })),
                value: boundValue,
                init() {
                    this.tom = new TomSelect(this.$refs.select, {
                        options: this.options,
                        valueField: 'value',
                        labelField: 'text',
                        searchField: ['text'],
                        allowEmptyOption: true,
                        placeholder: "Select an option",
                        items: this.value ? [this.value] : [],
                        onItemAdd: val => this.value = val,
                        onItemRemove: () => this.value = null,
                    });

                    this.$watch('value', (val) => {
                        if (val && !this.tom.items.includes(val)) {
                            this.tom.addItem(val, true);
                        }
                    });
                }
            }
        }
    </script>
</div>
