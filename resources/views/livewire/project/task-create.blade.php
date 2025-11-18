<div>
    <x-errors class="mb-4" />

    <form wire:submit.prevent="register" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Title *" wire:model.defer="title" invalidate />

            <x-select.styled
                label="Project *"
                wire:model.defer="project_id"
                :options="collect($projects)->map(fn($p) => ['name' => $p['title'], 'id' => $p['id']])->toArray()"
                select="label:name|value:id"
                placeholder="Select project"
                :disabled="(bool)$projectId"
            />

            <x-select.styled
                label="Assign To *"
                wire:model.defer="assigned_to"
                :options="collect($users)->map(fn($u) => ['name' => $u['name'], 'id' => (string)$u['id']])->toArray()"
                select="label:name|value:id"
                placeholder="Select user"
                :disabled="count($users) === 1"
            />

            <x-select.styled
                label="Priority *"
                wire:model.defer="priority_id"
                :options="$priorities->map(fn($p) => ['name' => ucfirst($p->name), 'id' => $p->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select priority"
            />

            <x-select.styled
                label="Status *"
                wire:model.defer="status"
                :options="$statuses->map(fn($s) => ['name' => $s->name, 'id' => $s->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select status"
            />

             <x-select.styled
                label="Task Type *"
                wire:model.defer="task_type_id"
                :options="$taskTypes->map(fn($t) => ['name' => ucfirst($t->name), 'id' => $t->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select task type"
            />

             <x-input
                label="Start Time *"
                type="datetime-local"
                wire:model.defer="start_time"
                id="start_time"
                invalidate
            />

            <x-input
                label="End Time *"
                type="datetime-local"
                wire:model.defer="end_time"
                id="end_time"
                invalidate
            />
        </div>

        <div class="mt-4">
            <x-textarea
                label="Description *"
                wire:model.defer="description"
                rows="4"
                invalidate
            />
        </div>

        <div class="text-right mt-6">
            <x-button type="submit" color="green" loading>
                Create Task
            </x-button>
        </div>
    </form>
</div>
