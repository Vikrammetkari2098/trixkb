<div class="w-full overflow-x-auto space-y-6 relative">

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 bg-white p-4 rounded-lg shadow">
    <!-- Title -->
    <div>
        <span class="text-lg font-semibold text-gray-800">All {{ $title }} Details - Latest</span>
    </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2 mt-3 sm:mt-0">
            @if (auth()->user()->hasPermission('add_page'))
                @if($title == 'Directory')
                    <a href="{{ route('wikis.downloadWikiExcel', ['team_slug' => $team->slug, 'user_id' => auth()->user()->slug, 'pageType' => $pageType]) }}"
                    class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 transition">
                        <i class="fa fa-download fa-fw mr-1"></i>
                        Download {{ $title }}
                    </a>
                @endif

                @if ($title != 'Case')
                    <a href="{{ route('wikis.create', [$team->slug]) }}?type={{$pageType}}"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                        <i class="fa fa-plus fa-fw mr-1"></i>
                        Create {{ $title }}
                    </a>
                @endif
            @endif
        </div>
    </div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h4 class="text-lg font-semibold text-gray-700">Filter by</h4>

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
    <!-- Search -->
    <input type="text" wire:model.debounce.300ms="search" placeholder="Search by Name, Designation..." class="input input-bordered w-full mb-4">

    <!-- Loader Overlay -->
    <div wire:loading.flex class="absolute inset-0 items-center justify-center bg-white/70 z-50">
        <div class="flex items-center space-x-2">
            <svg class="animate-spin h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span class="text-gray-700 font-medium">Loading directories...</span>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-auto border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No.</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Matrix Details</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Dial Code</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Telephone</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($wikis as $index => $wiki)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-2 whitespace-nowrap">
                            {{ ($wikis->currentPage() - 1) * $wikis->perPage() + $index + 1 }}
                        </td>
                        <td class="px-4 py-2 max-w-xs break-words">
                            <span class="font-medium">{{ $wiki->name }}</span>
                            <p class="text-gray-500">{{ $wiki->designation }}</p>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600 space-y-1">
                            <div>
                                <strong>Ministry:</strong>
                                {{ $wiki->organisation?->ministry?->name ?? '-' }}
                            </div>

                            @if($wiki->organisation?->department)
                                <div><strong>Department:</strong> {{ $wiki->organisation->department->name }}</div>
                            @endif
                            @if($wiki->organisation?->segment)
                                <div><strong>Division:</strong> {{ $wiki->organisation->segment->name }}</div>
                            @endif
                            @if($wiki->organisation?->unit)
                                <div><strong>Unit/Section:</strong> {{ $wiki->organisation->unit->name }}</div>
                            @endif
                            @if($wiki->organisation?->subUnit)
                                <div><strong>Sub Unit/Sub Section:</strong> {{ $wiki->organisation->subUnit->name }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $wiki->dial_code ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if($wiki->office_number) <span>Office: {{ $wiki->office_number }}</span><br> @endif
                            @if($wiki->mobile_number) <span>Mobile: {{ $wiki->mobile_number }}</span> @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            No results found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $wikis->links() }}
    </div>
</div>
