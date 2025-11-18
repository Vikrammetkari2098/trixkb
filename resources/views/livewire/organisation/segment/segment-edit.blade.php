<div class="p-6 bg-white rounded-lg shadow-md">
    <x-errors />

    <form id="form-edit-segment" wire:submit.prevent="update">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Division Name -->
            <div class="sm:col-span-2">
                <x-input
                    label="Division Name *"
                    id="name"
                    wire:model.defer="name"
                    placeholder="Enter division name"
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
            <x-button type="submit" color="green" loading>
                Update Division
            </x-button>
        </div>
    </form>
</div>
