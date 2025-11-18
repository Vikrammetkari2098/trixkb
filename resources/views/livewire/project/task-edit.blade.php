<div>
    <x-errors class="mb-4" />

    @if($taskId)
        <!-- DEBUG: canEdit={{ $canEdit ? 'true' : 'false' }}, userID={{ auth()->id() }}, assignedTo={{ $assigned_to ?? 'null' }} -->
        
        <form id="form-edit" wire:submit.prevent="update">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input 
                    label="Title *" 
                    wire:model.defer="title" 
                    required 
                    :disabled="!$canEdit" 
                />

                <x-select.styled
                    label="Project *"
                    wire:model.defer="project_id"
                    :options="collect($projects ?? [])->map(fn($p) => ['name' => $p['title'], 'id' => $p['id']])->toArray()"
                    select="label:name|value:id"
                    placeholder="Select project"
                :disabled="!$canEdit"
            />

            <x-select.styled
                label="Assign To *"
                wire:model.defer="assigned_to"
                :options="collect($users ?? [])->map(fn($u) => ['name' => $u['name'], 'id' => (string)$u['id']])->toArray()"
                select="label:name|value:id"
                placeholder="Select user"
                :disabled="!$canEdit"
            />

                        <x-select.styled
                label="Priority *"
                wire:model.defer="priority_id"
                :options="$priorities->map(fn($p) => ['name' => ucfirst($p->name), 'id' => $p->id])->toArray()"
                select="label:name|value:id"
                placeholder="Select priority"
                :disabled="!$canEdit"
            />

            <x-select.styled
                label="Status *"
                wire:model.defer="status"
                :options="$statuses?->map(fn($s) => ['name' => $s->name, 'id' => $s->id])->toArray() ?? []"
                select="label:name|value:id"
                placeholder="Select status"
                :disabled="!$canEdit"
            />

            <x-select.styled
                label="Task Type *"
                wire:model.defer="task_type_id"
                :options="$taskTypes?->map(fn($t) => ['name' => ucfirst($t->name), 'id' => $t->id])->toArray() ?? []"
                select="label:name|value:id"
                placeholder="Select task type"
                :disabled="!$canEdit"
            />
            
            <x-input
                label="Start Time"
                type="datetime-local"
                wire:model.defer="start_time"
                id="start_time"
                invalidate
                :disabled="$isViewOnly"
            />

            <x-input
                label="End Time"
                type="datetime-local"
                wire:model.defer="end_time"
                id="end_time"
                invalidate
                :disabled="$isViewOnly"
            />
        </div>

        <div class="mt-4">
            <x-textarea
                label="Description"
                wire:model.defer="description"
                rows="4"
                :disabled="$isViewOnly"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Attachments Section -->
            <x-card class="shadow-sm">
                <x-slot name="header">
                    <h2 class="text-lg font-semibold">Attachments</h2>
                </x-slot>

                <!-- Upload -->
                @if(!$isViewOnly)
                    <x-upload
                        wire:model="attachment"
                        delete
                        label="Upload File"
                        color="blue"
                        class="mb-4"
                    >
                        <x-slot:footer>
                            <x-button wire:click="saveAttachment" color="green" class="w-full">
                                Save
                            </x-button>
                        </x-slot:footer>
                    </x-upload>
                @endif

                @error('attachment')
                    <x-alert color="red" icon="x" class="text-sm mt-2">
                        {{ $message }}
                    </x-alert>
                @enderror

                <!-- List of Files -->
                <div class="space-y-2 mt-4 max-h-60 overflow-y-auto">
                    @forelse ($attachments as $file)
                        <x-card class="flex items-center justify-between p-3" wire:key="file-{{ $file->id }}">
                            <div class="flex items-center gap-4">
                                <div class="text-sm">
                                    <img src="{{ Storage::url($file->path) }}" alt="{{ $file->name }}" class="w-20 h-20 object-cover rounded" />
                                </div>
                                <div class="font-medium">{{ $file->name }}</div>
                            </div>

                            @if(!$isViewOnly)
                                <x-button wire:click="deleteAttachment({{ $file->id }})" color="red" size="sm">
                                    Delete
                                </x-button>
                            @endif
                        </x-card>
                    @empty
                        <x-alert color="gray" class="text-sm">
                            No attachments found.
                        </x-alert>
                    @endforelse
                </div>
            </x-card>

            <!-- Comments Section -->
            <x-card class="shadow-sm">
                <x-slot name="header">
                    <h2 class="text-lg font-semibold">Comments</h2>
                </x-slot>

                @if(!$isViewOnly)
                    <x-textarea resize-auto wire:model.defer="commentText" label="Add Comment" />

                    <x-button wire:click="saveComment" class="mt-2" color="blue" size="sm">
                        {{ $editingCommentId ? 'Update Comment' : 'Add Comment' }}
                    </x-button>
                @endif

                <div class="mt-4 space-y-2 max-h-60 overflow-y-auto">
                    @forelse ($comments as $comment)
                        <div class="text-sm p-2 rounded hover:bg-gray-50 transition cursor-pointer group" wire:key="comment-{{ $comment->id }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <strong>{{ $comment->user->name ?? 'Unknown' }}</strong>: {{ $comment->content }}
                                    <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                    @if(!$isViewOnly)
                                        <div class="text-xs text-blue-500 space-x-2 hidden group-hover:flex">
                                            <a wire:click="editComment({{ $comment->id }})" type="button" class="hover:underline">Edit</a>
                                            <a wire:click="deleteComment({{ $comment->id }})" type="button" class="hover:underline">Delete</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">No comments yet.</div>
                    @endforelse
                </div>
            </x-card>
        </div>

        <div class="flex justify-between items-center mt-6">
            <x-button
                type="button"
                color="gray"
                x-on:click="$dispatch('close-modal-edit')"
                class="border">
                {{ $isViewOnly ? 'Close' : 'Cancel' }}
            </x-button>
            @if(!$isViewOnly)
                <x-button type="submit" color="green" loading>
                    Update Task
                </x-button>
            @endif
        </div>
    </form>
    @else
        <div class="text-center py-4">
            <p>Loading task...</p>
        </div>
    @endif
</div>
