<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <!-- Create Segment Modal -->
    <x-modal id="modal-create-segment"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-create-segment.window="show = true"
             x-on:close-modal-create-segment.window="show = false"
             center>
            <h2 class="text-xl font-semibold mb-4">Create Division</h2>
             <livewire:organisation.segment.segment-create />
    </x-modal>

    <x-modal id="modal-edit-segment"
            x-data="{ show: false }" x-show="show"
            x-on:open-modal-edit-segment.window="show = true"
            x-on:close-modal-edit-segment.window="show = false">
            <h2 class="text-xl font-semibold mb-4">Edit Division</h2>
        <livewire:organisation.segment.segment-edit />
    </x-modal>
    <x-modal id="modal-view-segment"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-view-segment-modal.window="show = true"
             x-on:close-view-segment.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Division Details</h2>
    </x-modal>

    <!-- Top Actions -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Divisions</h1>
        <x-button color="green" x-on:click="$modalOpen('modal-create-segment')" class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Division
        </x-button>
    </div>

                <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="$segmentStatus"
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
        <x-table :headers="$headers" :rows="$rows" filter search paginate wire:key="segments-table">

            <!-- Status Column -->
            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $row->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            @endinteract


          <!-- Action Column -->
@interact('column_action', $row)
    <div class="flex gap-2">
        {{-- Edit --}}
        <x-button.circle
            color="yellow"
            icon="pencil"
            title="Edit"
            wire:click="$dispatch('loadData-edit-segment', { id: {{ $row->id }} })"
        />

        {{-- View --}}
        <x-button.circle 
            color="blue"
            icon="eye"
            title="View"
            x-on:click="
                $dispatch('loadData-view-segment', { id: {{ $row->id }} });
                $dispatch('open-modal-view-segment');
            "
        />
    </div>
@endinteract




        </x-table>
    </div>
</div>
