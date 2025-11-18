<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <!-- Create Unit Modal -->
    <x-modal id="modal-create-unit"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-create-unit.window="show = true"
             x-on:close-modal-create-unit.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Create Unit</h2>
        <livewire:organisation.unit.unit-create />
    </x-modal>

    <!-- Edit Unit Modal -->
    <x-modal id="modal-edit-unit"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-edit-unit.window="show = true"
             x-on:close-modal-edit-unit.window="show = false">
        <h2 class="text-xl font-semibold mb-4">Edit Unit</h2>
        <livewire:organisation.unit.unit-edit />
    </x-modal>

    <!-- View Unit Modal -->
    <x-modal id="modal-view-unit"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-view-unit.window="show = true"
             x-on:close-modal-view-unit.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Unit Details</h2>
        <div class="text-gray-700 space-y-2">
            <p><strong>Name:</strong> {{ $viewingUnit->name ?? '' }}</p>
            <p><strong>Status:</strong> {{ ($viewingUnit->status ?? 0) ? 'Active' : 'Inactive' }}</p>
            <p><strong>Created At:</strong> {{ optional($viewingUnit)->created_at?->format('d M, Y') }}</p>
        </div>
    </x-modal>

    <!-- Header -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Units</h1>
        <x-button color="green" x-on:click="$modalOpen('modal-create-unit')" class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Unit
        </x-button>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="$unitStatus"
                placeholder="All Status"
                class="w-full"
            />
        </div>

        <div class="flex gap-2 items-center">
            <x-button color="neutral" wire:click="$set('statusFilter', null)">Clear</x-button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate wire:key="units-table">

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
                        wire:click="$dispatch('loadData-edit-unit', {{ $row->id }})"
                    />
                    <x-button.circle
                        color="blue"
                        icon="information-circle"
                        wire:click="$dispatch('loadData-view-unit', { id: {{ $row->id }} })"
                    />
                </div>
            @endinteract

        </x-table>
    </div>
</div>
