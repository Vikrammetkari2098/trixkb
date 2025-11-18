<div>
    <x-errors />

    <form wire:submit.prevent="create">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

            <!-- Case Category Name -->
            <div>
                <x-input
                    label="Case Category Name *"
                    wire:model.defer="name"
                    placeholder="Enter Case Category Name"
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
                />
            </div>

        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>
                Create Case Category
            </x-button>
        </div>
    </form>
</div>
