<div class="space-y-4">

    <!-- Search -->
    <div class="relative w-full max-w-md">
        <input type="text"
               wire:model.debounce.300ms="search"
               placeholder="Search by Title, Content"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2">
        @if($search)
            <button wire:click="$set('search', '')"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                &times;
            </button>
        @endif
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No.</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Description</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Resolution</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Organization</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Created At</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Updated At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($wikis as $index => $wiki)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ ($wikis->firstItem() + $index) }}</td>
                        <td class="px-4 py-2">{{ $wiki->description }}</td>
                        <td class="px-4 py-2">{{ $wiki->remark }}</td>
                        <td class="px-4 py-2">
                            <strong>Ministry:</strong> {{ $wiki->organisation->ministry->name ?? '-' }} <br>
                            @if($wiki->organisation->department)
                                <strong>Department:</strong> {{ $wiki->organisation->department->name }} <br>
                            @endif
                            @if($wiki->organisation->segment)
                                <strong>Division:</strong> {{ $wiki->organisation->segment->name }} <br>
                            @endif
                            @if($wiki->organisation->unit)
                                <strong>Unit/Section:</strong> {{ $wiki->organisation->unit->name }} <br>
                            @endif
                            @if($wiki->organisation->subUnit)
                                <strong>Sub Unit:</strong> {{ $wiki->organisation->subUnit->name }} <br>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $wiki->created_at->format('d/m/Y h:i:s A') }}</td>
                        <td class="px-4 py-2">{{ $wiki->updated_at->format('d/m/Y h:i:s A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No results found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-600">{{ $wikiCount }} results found</p>
        <div>
            {{ $wikis->links() }}
        </div>
    </div>
</div>
