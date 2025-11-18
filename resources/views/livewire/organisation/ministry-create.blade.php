<div>
    <x-errors />

    <form wire:submit.prevent="create">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <!-- Ministry Name -->
            <div>
                <x-input label="Ministry Name *" wire:model.defer="name" />
            </div>

            <!-- Short Name -->
            <div>
                <x-input label="Short Name" wire:model.defer="short_name" />
            </div>

            <!-- Status -->
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
            <x-button type="submit" color="green" loading>Create Ministry</x-button>
        </div>
    </form>
</div>
