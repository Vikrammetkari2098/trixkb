<div>
    <x-errors />
    <form wire:submit="update" class="space-y-6">
        
        <!-- Title Field -->
        <x-input 
            label="Meeting Title *" 
            wire:model="title" 
            placeholder="Enter meeting title"
            id="title"
            invalidate
        />

        <!-- Description Field -->
        <x-textarea 
            label="Description" 
            wire:model="description" 
            placeholder="Meeting description (optional)"
            rows="3"
            id="description"
            invalidate
        />

        <!-- Agenda Field -->
        <x-textarea 
            label="Agenda" 
            wire:model="agenda" 
            placeholder="Meeting agenda (optional) - e.g., Introduction • Project Overview • Q&A"
            rows="3"
            id="agenda"
            invalidate
        />

        <!-- Date and Time Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-input 
                label="Start Time *" 
                wire:model="start_time" 
                type="datetime-local"
                id="start_time"
                invalidate
            />
            
            <x-input 
                label="End Time *" 
                wire:model="end_time" 
                type="datetime-local"
                id="end_time"
                invalidate
            />
        </div>

        <!-- Meeting Type and Status Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-select.styled 
                label="Meeting Type *" 
                wire:model="meeting_type_id" 
                :options="$meetingTypes->map(fn($type) => ['name' => $type->name, 'id' => $type->id])->toArray()"
                select="label:name|value:id"
                id="meeting_type_id"
                invalidate
            />

            <x-select.styled 
                label="Status *" 
                wire:model="status_id" 
                :options="$meetingStatuses->map(fn($status) => ['name' => $status->name, 'id' => $status->id])->toArray()"
                select="label:name|value:id"
                id="status_id"
                invalidate
            />
        </div>

        <!-- Platform Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-select.styled 
                label="Platform" 
                wire:model="platform_id" 
                :options="$platforms->map(fn($platform) => ['name' => $platform->name, 'id' => $platform->id])->toArray()"
                select="label:name|value:id"
                id="platform_id"
                placeholder="Select platform"
                invalidate
            />
            
            <x-input 
                label="Meeting Link" 
                wire:model="meeting_link" 
                placeholder="https://..."
                type="url"
                id="meeting_link"
                invalidate
            />
        </div>

        <!-- Location Field -->
        <x-input 
            label="Location" 
            wire:model="location" 
            placeholder="Physical location or meeting room"
            id="location"
            invalidate
        />

        <!-- Project Selection -->
        <x-select.styled 
            label="Project (Optional)" 
            wire:model="project_id" 
            :options="$projects->map(fn($project) => ['name' => $project->title, 'id' => $project->id])->toArray()"
            select="label:name|value:id"
            id="project_id"
            invalidate
        />

        <!-- Participants Selection -->
        <x-select.styled 
            label="Participants" 
            wire:model="user_ids" 
            :options="$users->map(fn($user) => ['name' => $user->name, 'id' => $user->id])->toArray()"
            select="label:name|value:id"
            multiple
            id="user_ids"
            invalidate
        />

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t">
            <x-button 
                color="slate" 
                outline 
                x-on:click="$modalClose('modal-edit')"
            >
                Cancel
            </x-button>
            
            <x-button 
                type="submit" 
                color="green"
                loading
            >
                Update Meeting
            </x-button>
        </div>
    </form>
</div>
