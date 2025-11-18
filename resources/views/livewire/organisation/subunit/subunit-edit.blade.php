<div class="p-6 bg-white rounded-lg shadow-md">
    <x-errors />

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-input
                    label="Sub Unit / Section Name *"
                    id="name"
                    wire:model.defer="name"
                    placeholder="Enter sub unit name"
                />
            </div>

            <div class="sm:col-span-2">
                <x-select.styled
                    label="Status *"
                    :options="$subUnitStatus"
                    wire:model.defer="status"
                    placeholder="Select status"
                />
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-3">
            <x-button type="submit" color="green" loading>
                Update Sub Unit
            </x-button>
        </div>
    </form>
</div>
