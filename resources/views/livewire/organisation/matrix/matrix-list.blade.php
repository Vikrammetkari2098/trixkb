<div class="w-full overflow-x-auto space-y-6 relative">
    <!-- Matrix Edit Modal -->
    <x-modal id="modal-edit-matrix" center x-data="{ show: false }" x-show="show"
            x-on:open-modal-edit-matrix.window="show = true"
            x-on:close-modal-edit-matrix.window="show = false">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Edit Matrix</h2>
        <!-- Include your MatrixEdit Livewire component -->
        <livewire:organisation.matrix.matrix-edit />
    </x-modal>
   <div class="flex justify-between items-center mb-4">
        <!-- Heading on the left -->
        <h4 class="text-lg font-semibold text-gray-700">Matrix List</h4>
        <!-- Button on the right -->
        <div class="flex items-center">
            <x-button
                color="green"
                x-on:click="$modalOpen('modal-create-matrix')"
                class="font-medium"
            >
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Matrix
            </x-button>

            <livewire:organisation.matrix.matrix-create />
        </div>
    </div>
    <!-- Filters Component -->
    <div class="mb-4">
        <livewire:organisation-filters />
    </div>

    <!-- Loader -->
    <div wire:loading.flex class="absolute inset-0 items-center justify-center bg-white/70 z-50">
        <div class="flex items-center space-x-2">
            <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span class="text-gray-700 font-medium">Loading organisations...</span>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-auto border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Details</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($organisations as $org)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $org->id }}</td>
                        <td class="px-4 py-2 max-w-xs break-words">
                            <span class="font-medium">{{ $org->name }}</span>
                            @if($org->unit)
                                <span class="text-gray-400">→ {{ $org->unit->name }}</span>
                            @endif
                            @if($org->subUnit)
                                <span class="text-gray-400">→ {{ $org->subUnit->name }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600 space-y-1">
                            <div><strong>Ministry:</strong> {{ $org->ministry->name ?? '-' }}</div>
                            @if($org->department)
                                <div><strong>Department:</strong> {{ $org->department->name }}</div>
                            @endif
                            @if($org->segment)
                                <div><strong>Division:</strong> {{ $org->segment->name }}</div>
                            @endif
                            @if($org->unit)
                                <div><strong>Unit/Section:</strong> {{ $org->unit->name }}</div>
                            @endif
                            @if($org->subUnit)
                                <div><strong>Sub Unit/Sub Section:</strong> {{ $org->subUnit->name }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($org->status)
                                <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                    Active
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap space-x-2 text-center">
                            <!-- View -->
                            <x-button.circle
                                size="sm"
                                color="blue"
                                icon="eye"
                                title="View"
                                wire:click="view({{ $org->id }})"
                                class="hover:scale-110 hover:shadow-[0_0_10px_rgba(59,130,246,0.4)] transition-all duration-300"
                            />
                           <x-button.circle
                                size="sm"
                                color="indigo"
                                icon="pencil"
                                title="Edit"
                                wire:click="$dispatch('loadData-edit-matrix', {{ $org->id }})"
                                class="hover:scale-110 hover:shadow-[0_0_10px_rgba(99,102,241,0.4)] transition-all duration-300"
                            />


                            <!-- Migrate -->
                            <x-button.circle
                                size="sm"
                                color="purple"
                                icon="arrows-right-left"
                                title="Migrate"
                                wire:click="migrate({{ $org->id }})"
                                class="hover:scale-110 hover:shadow-[0_0_10px_rgba(168,85,247,0.4)] transition-all duration-300"
                            />

                            <!-- Enable / Disable -->
                            @if($org->status)
                                <!-- Disable -->
                                <x-button.circle
                                    size="sm"
                                    color="red"

                                    title="Disable"
                                    wire:click="disable({{ $org->id }})"
                                    class="hover:scale-110 hover:shadow-[0_0_10px_rgba(239,68,68,0.4)] transition-all duration-300"
                                />
                            @else
                                <!-- Enable -->
                                <x-button.circle
                                    size="sm"
                                    color="green"
                                    icon="check"
                                    title="Enable"
                                    wire:click="enable({{ $org->id }})"
                                    class="hover:scale-110 hover:shadow-[0_0_10px_rgba(34,197,94,0.4)] transition-all duration-300"
                                />
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $organisations->links() }}
    </div>
    <!-- View Modal -->
    <x-modal id="view-org-modal" title="View Organisation Details" size="2xl">
        @if ($selectedOrganisation)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input label="Name" value="{{ $selectedOrganisation->name }}" readonly />
                <x-input label="Code" value="{{ $selectedOrganisation->code }}" readonly />
                <x-input label="Category" value="{{ $organisationCategories[$selectedOrganisation->category - 1]['name'] ?? 'N/A' }}" readonly />
                <x-input label="Status" value="{{ $selectedOrganisation->status ? 'Active' : 'Inactive' }}" readonly />
                <x-input label="Ministry" value="{{ $selectedOrganisation->ministry->name ?? 'N/A' }}" readonly />
                <x-input label="Department" value="{{ $selectedOrganisation->department->name ?? 'N/A' }}" readonly />
                <x-input label="Segment" value="{{ $selectedOrganisation->segment->name ?? 'N/A' }}" readonly />
                <x-input label="Unit" value="{{ $selectedOrganisation->unit->name ?? 'N/A' }}" readonly />
                <x-input label="Sub Unit" value="{{ $selectedOrganisation->subUnit->name ?? 'N/A' }}" readonly />
            </div>
        @else
            <p class="text-gray-500 text-sm">No organisation selected.</p>
        @endif

        <x-slot name="footer">
            <x-button flat label="Close" color="gray" x-on:click="$modalClose('view-org-modal')" />
        </x-slot>
    </x-modal>
    <script>
        Livewire.on('open-view-modal', () => {
            $modalOpen('view-org-modal');
        });
    </script>
</div>

