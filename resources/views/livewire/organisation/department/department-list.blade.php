<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <!-- Create Department Modal -->
    <x-modal id="modal-create-department"
            x-data="{ show: false }"
            x-show="show"
            x-on:open-modal-create-department.window="show = true"
            x-on:close-modal-create-department.window="show = false"
            center>
        <h2 class="text-xl font-semibold mb-4">Create Department</h2>
        <livewire:organisation.department.department-create />
    </x-modal>

    <!-- Edit Department Modal -->
    <x-modal id="modal-edit-department"
            x-data="{ show: false }"
            x-show="show"
            x-on:open-edit-department-modal.window="show = true"
            x-on:close-edit-department.window="show = false"
            center>
        <h2 class="text-xl font-semibold mb-4">Edit Department</h2>
        <livewire:organisation.department.department-edit />
    </x-modal>

    <!-- View Department Modal -->
    <x-modal id="modal-view-department"
            x-data="{ show: false }"
            x-show="show"
            x-on:open-view-department-modal.window="show = true"
            x-on:close-view-department.window="show = false"
            center>
        <h2 class="text-xl font-semibold mb-4">Department Details</h2>
        <livewire:organisation.department.department-show />
    </x-modal>

    <!-- Top Actions -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Departments</h1>
        <x-button color="green" x-on:click="$modalOpen('modal-create-department')" class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Department
        </x-button>
    </div>


    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <x-select.styled
                wire:model="statusFilter"
                :options="$departmentStatus"
                placeholder="All Status"
                class="w-full"
            />
        </div>

        <div class="flex gap-2 items-center">
            <x-button color="neutral" wire:click="resetFilters">Clear</x-button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate wire:key="departments-table">

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
            title="Edit Department"
            wire:click="$dispatch('loadData-edit-department', { id: '{{ $row->id }}' })"

        />

        {{-- View --}}
        <x-button.circle
            color="blue"
            icon="eye"
            title="View Department"
            wire:click="$dispatch('loadData-view-department', { id: {{ $row->id }} })"

        />
    </div>
@endinteract

        </x-table>
    </div>
</div>
