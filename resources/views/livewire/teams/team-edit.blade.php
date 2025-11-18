<div>
    <x-errors />

    <form id="form-edit-team" wire:submit.prevent='update'>
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
            <div>
                <x-input label="Email *" id="email" wire:model.defer="email" invalidate />
            </div>

            <!-- New Password -->
            <div>
                <x-input label="New Password" id="password" wire:model.defer="password" type="password" invalidate />
            </div>

            <!-- Confirm New Password -->
            <div>
                <x-input label="Confirm New Password" id="password_confirmation" wire:model.defer="password_confirmation" type="password" invalidate />
            </div>

            <!-- Assign to Team -->
            <div>
                <x-select.styled
                    label="Assign to Team *"
                    :options="$teams->map(fn($team) => ['name' => $team->name, 'id' => $team->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="selectedTeamId"
                    id="team"
                    invalidate
                />
            </div>

            <!-- Role -->
            <div>
                <x-select.styled
                    label="Role *"
                    :options="$roles->map(fn($role) => ['name' => $role->name, 'id' => $role->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="role"
                    id="role"
                    invalidate
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
