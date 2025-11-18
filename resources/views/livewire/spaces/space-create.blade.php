<div class="p-6 bg-white rounded-lg shadow-md">
    <x-errors />

    <form id="form-create-space" wire:submit.prevent="register">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <!-- Space Name -->
            <div class="sm:col-span-2">
                <x-input
                    label="Space Name *"
                    id="name"
                    wire:model.defer="name"
                    placeholder="Enter space name"
                    invalidate
                />
            </div>

            <!-- Matrix / Organisation -->
            <div class="sm:col-span-2">
                <x-select.styled
                    label="Matrix *"
                    :options="$organisations->map(fn($org) => ['name' => $org->name, 'id' => $org->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="organisation_id"
                    id="organisation_id"
                    placeholder="Select organisation"
                />
            </div>

            <!-- Outline -->
            <div class="sm:col-span-2">
                <x-textarea
                    label="Outline"
                    id="outline"
                    wire:model.defer="outline"
                    :value="$outline ?? $name"
                    placeholder="Enter outline (defaults to Space Name)"
                    rows="4"
                />
            </div>

        </div>

        <!-- Buttons -->
        <div class="flex justify-end mt-6 space-x-3">
            <x-button type="submit" color="green" loading>
                Create Space
            </x-button>
        </div>
    </form>
</div>
