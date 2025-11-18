<div wire:model="open" title="Create Department" width="md">

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Department Name</label>
            <x-input wire:model="name" placeholder="Enter department name" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Short Name</label>
            <x-input wire:model="short_name" placeholder="Enter short name" />
            @error('short_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="status"
                :options="[
                    ['value' => 1, 'label' => 'Active'],
                    ['value' => 0, 'label' => 'Inactive']
                ]"
            />
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-2 mt-4">

            <x-button color="green" type="submit" loading>Save Department</x-button>
        </div>
    </form>

</div>
