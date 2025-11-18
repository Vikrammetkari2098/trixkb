<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <!-- Edit Case Category Modal -->
    <x-modal id="modal-edit-approval-flow"
            x-data="{ show: false }"
            x-show="show"
            x-on:open-modal-edit-approval-flow.window="show = true"
            x-on:close-modal-edit-approval-flow.window="show = false"
            center>

        <h2 class="text-xl font-semibold mb-4">Edit Approval Flow</h2>

        <livewire:organisation.approvalflow.approval-flow-edit />

    </x-modal>
    <!-- Top Actions -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Approval Flow</h1>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="array_merge([['value'=>'','label'=>'All Status']], \App\Models\Status::all()->map(fn($s)=>['value'=>$s->id,'label'=>$s->name])->toArray())"
                placeholder="All Status"
                class="w-full"
            />
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <x-input
                wire:model.debounce.500ms="search"
                placeholder="Search by status"
                class="w-full"
            />
        </div>

        <div class="flex gap-2 items-center">
            <x-button color="neutral" wire:click="$set('statusFilter', null)">Clear</x-button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate wire:key="approval-flow-table">

            <!-- Status Column -->
            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    bg-indigo-100 text-indigo-800">
                    {{ $row->status_name }}
                </span>
            @endinteract

            <!-- Order Column -->
            @interact('column_order', $row)
                {{ $row->order }}
            @endinteract

            <!-- Roles Column -->
            @interact('column_roles', $row)
                {{ $row->role_names }}
            @endinteract

            <!-- Action Column -->
            @interact('column_action', $row)
                <div class="flex space-x-2">
                   <x-button.circle
                        color="yellow"
                        icon="pencil"
                        wire:click="$dispatch('open-modal-edit-approval-flow', { id: {{ $row->id }} })"
                        title="Edit"
                    />


                </div>
            @endinteract

        </x-table>
    </div>

</div>
