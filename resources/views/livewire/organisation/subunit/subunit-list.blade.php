<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <!-- Create Sub Unit Modal -->
    <x-modal id="modal-create-subunit"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-create-subunit.window="show = true"
             x-on:close-modal-create-subunit.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Create Sub Unit</h2>
        <livewire:organisation.subunit.subunit-create :team="$team" />
    </x-modal>

    <!-- Edit Subunit Modal -->
    <x-modal id="modal-edit-subunit"
            x-data="{ show: false }"
            x-show="show"
            x-on:open-modal-edit-subunit.window="show = true"
            x-on:close-modal-edit-subunit.window="show = false"
            center>
        <h2 class="text-xl font-semibold mb-4">Edit Sub Unit</h2>
        <livewire:organisation.subunit.subunit-edit />
    </x-modal>


    <!-- View Sub Unit Modal -->
    <x-modal id="modal-view-subunit"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-view-subunit.window="show = true"
             x-on:close-modal-view-subunit.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Sub Unit Details</h2>
        <div class="text-gray-700 space-y-2">
            <p><strong>Name:</strong> {{ $viewingSubUnit->name ?? '' }}</p>
            <p><strong>Status:</strong> {{ ($viewingSubUnit->status ?? 0) ? 'Active' : 'Inactive' }}</p>
            <p><strong>Created At:</strong> {{ optional($viewingSubUnit)->created_at?->format('d M, Y') }}</p>
        </div>
    </x-modal>

    <!-- Header -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Sub Units</h1>
        <x-button color="green" x-on:click="$modalOpen('modal-create-subunit')" class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Sub Unit/Sub Section
        </x-button>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <x-select.styled
                label="Status *"
                :options="$subUnitStatus"
                wire:model.defer="status"
                placeholder="Select status"
            />
        </div>

        <div class="flex gap-2 items-center">
            <x-button color="neutral" wire:click="$set('statusFilter', null)">Clear</x-button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate wire:key="subunit-table">

            <!-- Status Column -->
            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $row->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            @endinteract

            <!-- Action Column -->
            @interact('column_action', $row)
                <div class="flex items-center space-x-2">
                    <x-button.circle
                        color="emerald"
                        icon="pencil"
                        wire:click="$dispatch('loadData-edit-subunit', {{ $row->id }})"
                    />
                    <x-button.circle
                        color="blue"
                        icon="information-circle"
                        wire:click="$dispatch('loadData-view-subunit', { id: {{ $row->id }} })"
                    />
                </div>
            @endinteract

        </x-table>
    </div>
</div>
