<div>
    <x-errors />
        <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <!-- Status Name -->
            <div>
                <x-input label="Status Name *" wire:model.defer="status_name" />
            </div>

            <!-- Checkboxes -->
            <div class="sm:col-span-2 flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.defer="is_default" class="form-checkbox" />
                    Is Default
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.defer="is_private" class="form-checkbox" />
                    Is Private
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model.defer="is_public" class="form-checkbox" />
                    Is Public
                </label>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>Update Status</x-button>
        </div>
    </form>
</div>
