<div class="p-6 bg-white rounded-2xl shadow space-y-6">

    {{-- Create Sub Case Category 2 Modal --}}
    <x-modal id="modal-create-sub-case-category2"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-create-sub-case-category2.window="show = true"
             x-on:close-modal-create-sub-case-category2.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Create Sub Case Category 2</h2>
        <livewire:organisation.sub-case-category2.sub-case-category2-create />
    </x-modal>
        {{-- View Sub Case Category 2 Modal --}}
        <x-modal id="modal-view-sub-case-category2"
                x-data="{ show: false }"
                x-show="show"
                x-on:open-modal-view-sub-case-category2.window="show = true"
                x-on:close-modal-view-sub-case-category2.window="show = false"
                center>
            <h2 class="text-xl font-semibold mb-4">Sub Case Category 2 Details</h2>
            <livewire:organisation.sub-case-category2.sub-case-category2-view :subCaseCategory2Id="$subCaseCategory2Id ?? null" />
        </x-modal>

    {{-- Top Actions --}}
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Sub Case Categories 2</h1>
        <x-button color="green"
                  x-on:click="$dispatch('open-modal-create-sub-case-category2')"
                  class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Sub Case Category 2
        </x-button>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="$subCaseCategory2Status"
                placeholder="All Status"
                class="w-full"
            />
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <x-input
                wire:model.debounce.500ms="search"
                placeholder="Search by name"
                class="w-full"
            />
        </div>

        <div class="flex gap-2 items-center">
            <x-button color="neutral" wire:click="$set('statusFilter', null)">Clear</x-button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate>

            @interact('column_name', $row)
                {{ $row['name'] }}
            @endinteract

            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $row['status'] == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row['status'] == 1 ? 'Active' : 'Inactive' }}
                </span>
            @endinteract

            @interact('column_created_by', $row)
                {{ $row['created_by_name'] }}
            @endinteract

     @interact('column_action', $row)
    <div class="flex gap-2">
        <x-button.circle 
            color="blue" 
            icon="eye"
            x-on:click="
                $dispatch('loadData-view-sub-case-category2', [{{ $row->id }}]);
                $dispatch('open-view-subcasecategory2-modal');
            "
        />
    </div>
@endinteract

        </x-table>
    </div>
</div>
