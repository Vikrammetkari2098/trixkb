<div class="p-6 bg-white rounded-2xl shadow space-y-6">

    <!-- Create Status Modal -->
    <x-modal id="modal-create-status"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-create-status.window="show = true"
             x-on:close-modal-create-status.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Create Status</h2>
        <livewire:organisation.status.status-create />
    </x-modal>

    <!-- Edit Status Modl -->
    <x-modal id="modal-edit-status"
             x-data="{ show: false }"
             x-show="show"
             x-on:open-modal-edit-status.window="show = true"
      x-on:close-modal-edit-status.window="show = false"
             center>
        <h2 class="text-xl font-semibold mb-4">Edit Status</h2>
        <livewire:organisation.status.status-edit />
    </x-modal>

    <!-- Header -->
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Statuses</h1>

        <x-button color="green"
                  x-on:click="$modalOpen('modal-create-status')"
                  class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>
            Create Status
        </x-button>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter</label>

            <x-select.styled
                :options="$statusOptions"
                wire:model.defer="statusFilter"
                placeholder="Select Status"
            />
        </div>

        <div>
            <x-button color="neutral" wire:click="$set('statusFilter', null)">
                Clear
            </x-button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" search paginate filter wire:key="status-table">

            {{-- Is Default --}}
            @interact('column_is_default', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $row->is_default ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row->is_default ? 'true' : 'false' }}
                </span>
            @endinteract

            {{-- Is Private --}}
            @interact('column_is_private', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $row->is_private ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row->is_private ? 'true' : 'false' }}
                </span>
            @endinteract

            {{-- Is Public --}}
            @interact('column_is_public', $row)
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $row->is_public ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $row->is_public ? 'true' : 'false' }}
                </span>
            @endinteract

            {{-- Actions --}}
            @interact('column_action', $row)
                <x-button.circle
                    color="yellow"
                    icon="pencil"
                 wire:click="$dispatch('open-modal-edit-status', [{{ $row->id }}])"


                />

            @endinteract

        </x-table>
    </div>

</div>
