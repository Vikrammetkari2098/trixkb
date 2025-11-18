<div>
    <x-errors />

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">
            <div>
                <x-input label="Sub Case Category Name *" wire:model.defer="name" />
            </div>

            <div class="sm:col-span-2">
                <x-select.styled
                    label="Status *"
                    :options="[
                        ['name' => 'Active','id'=>1],
                        ['name' => 'Inactive','id'=>0]
                    ]"
                    select="label:name|value:id"
                    wire:model.defer="status"
                />
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>Save Sub Case Category</x-button>
        </div>
    </form>
</div>
