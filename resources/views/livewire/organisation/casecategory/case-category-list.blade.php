<div class="p-6 bg-white rounded-2xl shadow space-y-6">

    <!-- Create Case Category Modal -->
    <x-modal id="modal-create-case-category"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-create-case-category.window="show = true"
             x-on:close-modal-create-case-category.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Create Case Category</h2>
        <livewire:organisation.casecategory.case-category-create/>
    </x-modal>

    <!-- View Case Category Modal -->
    <x-modal id="modal-view-case-category"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-view-case-category.window="show = true"
             x-on:close-modal-view-case-category.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Case Category Details</h2>
        <livewire:organisation.casecategory.case-category-view />
    </x-modal>

    <!-- Top Actions -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Case Categories</h1>
        <x-button color="green"
                  x-on:click="$modalOpen('modal-create-case-category')"
                  class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Case Category
        </x-button>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="$caseCategoryStatus"
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

    <!-- Table -->
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate wire:key="case-category-table">

            <!-- Name Column -->
            @interact('column_name', $row)
                {{ $row->display_name }}
            @endinteract

            <!-- Status Column -->
            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $row->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            @endinteract

            <!-- Created By Column -->
            @interact('column_created_by', $row)
                {{ $row->created_by_name }}
            @endinteract

            <!-- Action Column -->
            @interact('column_action', $row)
                <div class="flex space-x-2">
                    <x-button.circle
                        color="blue"
                        icon="eye"
                        wire:click="$dispatch('loadData-view-case-category', { id: {{ $row->id }} })"

                    />

                </div>
            @endinteract

        </x-table>
    </div>
</div>
