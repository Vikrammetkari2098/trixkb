<div class="p-6 bg-white rounded-lg shadow-md">
    <x-errors />

    <form id="form-edit-unit" wire:submit.prevent="update">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Unit/Section Name -->
            <div class="sm:col-span-2">
                <x-input
                    label="Unit / Section Name *"
                    id="unit_name"
                    wire:model.defer="unit_name"
                    placeholder="Enter unit or section name"
                    invalidate
                />
            </div>

            <!-- Status -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Status *"
                    :options="[
                        ['name' => 'Active', 'id' => 1],
                        ['name' => 'Inactive', 'id' => 0]
                    ]"
                    select="label:name|value:id"
                    wire:model.defer="status"
                    id="status"
                    placeholder="Select status"
                />
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end mt-6 space-x-3">
            <x-button
                type="submit"
                color="green"
                loading
            >
                Update Unit
            </x-button>
        </div>
    </form>
</div>
