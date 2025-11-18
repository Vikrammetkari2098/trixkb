<div>
    <x-errors />

    <form wire:submit.prevent="register">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">

            <!-- Role Name -->
            <div>
                <x-input label="Role Name *" id="name" wire:model.defer="name" invalidate />
            </div>

            <!-- Select Permissions -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Select Permissions"
                    :options="$allPermissions->map(fn($perm) => ['name'=>$perm->name,'id'=>$perm->id])->toArray()"
                    select="label:name|value:id"
                    multiple
                    wire:model.defer="permissions"
                    id="permissions"
                />
            </div>

            <!-- Select Members -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Select Members"
                    :options="$allUsers->map(fn($u) => ['name'=>$u->name,'id'=>$u->id])->toArray()"
                    select="label:name|value:id"
                    multiple
                    wire:model.defer="users"
                    id="users"
                />
            </div>

        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>
                Create Role
            </x-button>
        </div>
    </form>
</div>
