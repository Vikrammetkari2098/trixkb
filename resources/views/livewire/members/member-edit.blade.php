<div>
    <x-errors />

    <form id="form-edit-member" wire:submit.prevent="update">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <!-- First Name -->
            <div>
                <x-input label="First Name *" id="first_name" wire:model.defer="first_name" invalidate />
            </div>

            <!-- Last Name -->
            <div>
                <x-input label="Last Name *" id="last_name" wire:model.defer="last_name" invalidate />
            </div>

            <!-- Email -->
            <div class="sm:col-span-2">
                <x-input type="email" label="Email *" id="email" wire:model.defer="email" invalidate />
            </div>

            <!-- Role -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Role *"
                    :options="$roles->map(fn($role) => ['name' => str_replace('_', ' ', ucwords($role->name)), 'id' => $role->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="role"
                />
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>
                Update Member
            </x-button>
        </div>
    </form>
</div>
