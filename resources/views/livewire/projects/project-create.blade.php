<div>
    <x-errors />
    <form id="form-create" wire:submit.prevent='register'>
        @csrf
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <x-input label="Title *" id="title" wire:model.defer="title" invalidate />
            </div>

            <div>
                <x-textarea label="Description *" id="description" wire:model.defer="description" invalidate />
            </div>

            <div class="sm:col-span-2">
                <x-select.styled label="Priority *"
                    :options="$priorities->map(fn($priority) => ['name' => $priority->name, 'id' => $priority->id])->toArray()"
                    select="label:name|value:id"
                    wire:model.defer="priority" id="priority" />
            </div>

            <div>
                <x-input type="datetime-local" label="Start Time *" wire:model.defer="start_time" id="start_time" invalidate />
            </div>

            <div>
                <x-input type="datetime-local" label="End Time *" wire:model.defer="end_time" id="end_time" invalidate />
            </div>

            <div class="sm:col-span-2">
                <x-select.styled label="Modules *"
                    :options="$moduleAll->map(fn($module) => ['name' => $module->name, 'id' => $module->id])->toArray()"
                    select="label:name|value:id"
                    multiple
                    wire:model.defer="modules"
                    id="modules"
                />
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <x-button type="submit" color="green" loading>
                Create Project
            </x-button>
        </div>
    </form>
</div>
