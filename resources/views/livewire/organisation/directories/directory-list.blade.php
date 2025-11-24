<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    {{-- Top Actions --}}
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Directories</h1>
        <x-button color="green"
                  x-on:click="$dispatch('open-modal-create-directory')"
                  class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Directory
        </x-button>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col md:flex-row gap-4 mb-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Ministry</label>
            <x-select.styled
                wire:model="ministryFilter"
                :options="$ministries_list"
                placeholder="All Ministries"
                class="w-full"
            />
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <x-select.styled
                wire:model="departmentFilter"
                :options="$departments_list"
                placeholder="All Departments"
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
            <x-button color="neutral" wire:click="$set('ministryFilter', null); $set('departmentFilter', null); $set('search', null)">Clear</x-button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <x-table :headers="$headers" :rows="$rows" filter search paginate>

            @interact('column_name', $row)
                {{ $row['name'] }}
            @endinteract

            @interact('column_organisation', $row)
                <div class="space-y-1 text-sm">
                    @if($row['organisation']['ministry'] ?? null)<p><strong>Ministry:</strong> {{ $row['organisation']['ministry']['name'] }}</p>@endif
                    @if($row['organisation']['department'] ?? null)<p><strong>Department:</strong> {{ $row['organisation']['department']['name'] }}</p>@endif
                    @if($row['organisation']['segment'] ?? null)<p><strong>Segment:</strong> {{ $row['organisation']['segment']['name'] }}</p>@endif
                    @if($row['organisation']['unit'] ?? null)<p><strong>Unit:</strong> {{ $row['organisation']['unit']['name'] }}</p>@endif
                    @if($row['organisation']['subUnit'] ?? null)<p><strong>Sub Unit:</strong> {{ $row['organisation']['subUnit']['name'] }}</p>@endif
                </div>
            @endinteract

            @interact('column_created_by', $row)
                {{ $row['user']['name'] ?? '-' }}
            @endinteract

        @interact('column_action', $row)
    <div class="flex gap-2">

        {{-- View --}}
        <x-button.circle
            color="blue"
            icon="eye"
            wire:click="$dispatch('loadData-view-article', { id: {{ $row->id }} })"
            title="View"
        />

        {{-- Edit --}}
        <x-button.circle
            color="yellow"
            icon="pencil"
            wire:click="$dispatch('loadData-edit-wiki', { id: {{ $row->id }} })"
            title="Edit"
            class="hover:scale-110 transition"
        />

        {{-- Delete --}}
        <x-button.circle
            color="red"
            icon="trash"
            x-on:click="$dispatch('delete-wiki', { wikiId: {{ $row->id }} })"
            title="Delete"
            class="hover:scale-110 transition"
        />

    </div>
@endinteract

        </x-table>
    </div>

</div>
