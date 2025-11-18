<div class="w-full overflow-x-auto space-y-6 relative">
        <div class="flex justify-between items-center mb-4">
            <!-- Heading -->
            <h4 class="text-lg font-semibold text-gray-700">
                Filter by
            </h4>

            <!-- Right Button -->
            <x-button  wire:click="exportExcel" class="btn btn-gradient btn-info flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v16h16V4H4zM12 12v6m0 0l-3-3m3 3l3-3" />
                </svg>
                Download Excel
            </x-button>
        </div>
         <div class="mb-4">
            <livewire:organisation-filters />
        </div>
        <!-- Loader Overlay -->
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
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700"> Details</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
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
</div>
