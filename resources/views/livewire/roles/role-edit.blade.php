<div>
    <x-errors />

    <form id="form-edit-role" wire:submit.prevent="update">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <!-- Role Name -->
            <div class="sm:col-span-2">
                <x-input
                    label="Role Name *"
                    id="name"
                    wire:model.defer="name"
                    invalidate
                    required
                />
            </div>

            <!-- Assign Users -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Assign Users"
                    :options="$allUsers ? $allUsers->map(fn($u) => ['name' => $u->name, 'id' => $u->id])->toArray() : []"
                    select="label:name|value:id"
                    wire:model.defer="users"
                    multiple
                    placeholder="Select users..."
                />
            </div>

            <!-- Assign Permissions -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Assign Permissions"
                    :options="$allPermissions->map(fn($perm) => ['name' => Str::title(str_replace('_', ' ', $perm->name)), 'id' => $perm->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="permissions"
                    multiple
                    placeholder="Select permissions..."
                />
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" wire:loading.attr="disabled" loading>
                Update Role
            </x-button>
        </div>
    </form>
</div>
