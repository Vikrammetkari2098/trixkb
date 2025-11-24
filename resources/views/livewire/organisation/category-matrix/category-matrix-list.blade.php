<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <x-modal id="modal-create-category-matrix" center
            x-data="{ show: false }"
            x-show="show"
            x-on:open-modal-create-category-matrix.window="show = true"
            x-on:close-modal-create-category-matrix.window="show = false">
        <h2 class="text-xl font-semibold mb-4">Create Category Matrix</h2>
        <livewire:organisation.category-matrix.category-matrix-create />
    </x-modal>
    <x-modal id="modal-view-category-matrix" center
        x-data="{ show: false }"
        x-show="show"
        x-on:open-modal-view-category-matrix.window="show = true"
        x-on:close-modal-view-category-matrix.window="show = false">

        <h2 class="text-xl font-semibold mb-4">View Category Matrix</h2>
        <livewire:organisation.category-matrix.category-matrix-view />
    </x-modal>

    {{-- Top Actions --}}
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Case Category Matrix</h1>
        <x-button color="green"
                  x-on:click="$dispatch('open-modal-create-category-matrix')"
                  class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Category Matrix
        </x-button>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="$categoryMatrixStatus"
                placeholder="All Status"
                class="w-full"
            />
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <x-input wire:model.debounce.500ms="search" placeholder="Search by Name" class="w-full"/>
        </div>

        <div class="flex gap-2 items-center">
            <x-button color="neutral" wire:click="$set('statusFilter', null)">Clear</x-button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <x-table class="table-auto w-full" :headers="$headers" :rows="$rows" filter search paginate>
            @interact('column_name', $row)
                <div class="break-words whitespace-normal max-w-xs">
                    {{ $row['name'] }}
                </div>
            @endinteract
            @interact('column_matrix_details', $row)
                <div class="text-sm break-words">
                    <p><strong>Ministry: </strong>{{ $row['matrix_details']['ministry'] }}</p>
                    <p><strong>Department: </strong>{{ $row['matrix_details']['department'] }}</p>
                    <p><strong>Case Category: </strong>{{ $row['matrix_details']['caseCategory'] }}</p>
                    <p><strong>Sub Case Category 1: </strong>{{ $row['matrix_details']['subCategory1'] }}</p>
                    <p><strong>Sub Case Category 2: </strong>{{ $row['matrix_details']['subCategory2'] }}</p>
                </div>
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
                       wire:click="$dispatch('viewCategoryMatrix', [{{ $row->id }}])"

                        title="View"
                    />

                </div>
            @endinteract
        </x-table>
        <div class="mt-2">
            <span>{{ $categoryMatrixCount }} results found</span>
        </div>
    </div>
</div>
