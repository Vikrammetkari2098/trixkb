<div wire:model="open" title="Department Details" width="md">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Department Name</label>
            <p class="mt-1 text-gray-800">{{ $name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Short Name</label>
            <p class="mt-1 text-gray-800">{{ $short_name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <p class="mt-1 text-gray-800">
                {{ $status == 1 ? 'Active' : 'Inactive' }}
            </p>
        </div>

        <div class="flex justify-end mt-4">
            <x-button color="gray" wire:click="$set('open', false)">Close</x-button>
        </div>
    </div>
</div>
