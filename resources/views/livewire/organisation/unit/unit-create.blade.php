<div class="p-6 bg-white rounded-lg shadow-md">
    <x-errors />

    <form wire:submit.prevent="save" id="form-create-unit">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <!-- Unit Name -->
            <div class="sm:col-span-2">
                <x-input
                    label="Unit / Section Name *"
                    id="name"
                    wire:model.defer="name"
                    name="name"
                    placeholder="Enter unit or section name"
                    required
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
                    name="status"
                    placeholder="Select status"
                />
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end mt-6 space-x-3">
            <x-button type="submit" color="green" loading>
                Create Unit
            </x-button>
        </div>
    </form>
</div>
