<div>
    <x-errors />

    <form id="form-edit-approval-flow" wire:submit.prevent="update">
        @csrf

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

            <!-- Flow Name (Read Only) -->
            <div class="sm:col-span-2">
                <x-input
                    label="Flow Name"
                    id="name"
                    wire:model="name"
                    readonly
                    disabled
                    class="bg-gray-100 cursor-not-allowed"
                />
            </div>

            <!-- Assign Roles -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Select Roles"
                    :options="$allRoles->map(fn($r) => [
                        'name' => $r->name,
                        'id'   => $r->id
                    ])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="roles"
                    multiple
                    placeholder="Select roles..."
                />
            </div>

        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" wire:loading.attr="disabled" loading>
                Update Flow
            </x-button>
        </div>
    </form>
</div>
