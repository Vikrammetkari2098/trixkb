<div class="p-6 bg-white rounded-xl shadow-md border border-gray-200">
    <x-errors />

    <form id="form-create" wire:submit.prevent='register' class="space-y-8">

        <input type="hidden" wire:model="wiki_type" value="{{ $wikiType ?? 'directory' }}" />

        <!-- Section: Name and Space -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input label="Name *" id="name" wire:model.defer="name" required class="h-11 rounded-lg" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Space-->
            <div x-data="dropdown(@js($spaces->map(fn($item) => ['text' => $item->name, 'value' => $item->id])->toArray()), @entangle('space_ids'))" x-init="init()" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-2">Space *</label>
                <select x-ref="select" multiple ></select>
                @error('space_ids') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Section: Directory Categorization -->
       <div class="p-4 rounded-xl border border-gray-200 bg-white space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Directory Categorization</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Ministry  -->
                <div x-data="dropdown(@js($ministries->map(fn($item) => ['text' => $item->name, 'value' => $item->ministry_id])->toArray()), @entangle('ministry_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ministry *</label>
                    <select x-ref="select"></select>
                    @error('ministry_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Department -->
                <div x-data="dropdown(@js($departments->map(fn($item) => ['text' => $item->name, 'value' => $item->department_id])->toArray()), @entangle('department_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select x-ref="select" ></select>
                </div>

                <!-- Division / Segment  -->
                <div x-data="dropdown(@js($segments->map(fn($item) => ['text' => $item->name, 'value' => $item->segment_id])->toArray()), @entangle('segment_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Division / Segment</label>
                    <select x-ref="select" ></select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                <!-- Unit/Section  -->
                <div x-data="dropdown(@js($units->map(fn($item) => ['text' => $item->name, 'value' => $item->unit_id])->toArray()), @entangle('unit_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit/Section</label>
                    <select x-ref="select" ></select>
                </div>

                <!-- Sub Unit/Sub Section  -->
                <div x-data="dropdown(@js($subUnits->map(fn($item) => ['text' => $item->name, 'value' => $item->sub_unit_id])->toArray()), @entangle('sub_unit_id'))" x-init="init()" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sub Unit/Sub Section</label>
                    <select x-ref="select" ></select>
                </div>
            </div>
        </div>



        <!-- Section: Directory Details -->
        <div class="p-4 rounded-xl border border-gray-200 bg-white space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Directory Details</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <x-input label="Dial Code" wire:model.defer="dial_code" class="h-11 rounded-lg" />
                <x-input type="number" label="Extension Number" wire:model.defer="extension_number" class="h-11 rounded-lg" />
                <x-input label="Office Number *" wire:model.defer="office_number" required class="h-11 rounded-lg" />
                @error('office_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <x-input label="Office Number 2" wire:model.defer="office_number_2" class="h-11 rounded-lg" />
                <x-input label="Office Number 3" wire:model.defer="office_number_3" class="h-11 rounded-lg" />
                <x-input label="Office Number 4" wire:model.defer="office_number_4" class="h-11 rounded-lg" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <x-input label="Mobile Number" wire:model.defer="mobile_number" class="h-11 rounded-lg" />
                <x-input label="Fax" wire:model.defer="fax" class="h-11 rounded-lg" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <x-input label="Designation" wire:model.defer="designation" class="h-11 rounded-lg" />
                <x-input label="Grade" wire:model.defer="grade" class="h-11 rounded-lg" />
                <x-input label="Job Scope" wire:model.defer="work_scope" class="h-11 rounded-lg" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <x-input type="email" label="Email" wire:model.defer="email" class="h-11 rounded-lg" />
                <x-textarea label="Address" wire:model.defer="address" class="rounded-lg" rows="3" />
                <x-textarea label="Remarks" wire:model.defer="remark" class="rounded-lg" rows="3" />
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading class="h-11 px-6">Save Directory</x-button>
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
                    onItemAdd: (val) => {
                        if(Array.isArray(this.value)){
                            this.value = [...this.value, val];
                        } else {
                            this.value = val;
                        }
                    },
                    onItemRemove: (val) => {
                        if(Array.isArray(this.value)) {
                            this.value = this.value.filter(v => v != val);
                        } else {
                            this.value = null;
                        }
                    },
                    maxItems: null, // allows multiple selection if needed
                    closeAfterSelect: false,
                    persist: false,
                    create: false
                });
            }
        }
    }
</script>
