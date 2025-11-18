<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6">
        <!-- Filters -->
        <div class="mb-4">
            <livewire:organisation-filters />
        </div>

        <!-- Articles Table -->
        <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200 relative">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No.</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700" colspan="2">Organization</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Created On</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Updated On</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Popular</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 text-center">AI</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($wikis as $index => $wiki)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium">{{ $wikis->firstItem() + $index }}</td>

                            <td class="px-4 py-2">
                                <a href="{{ route('wikis.show', [$team->slug ?? '', $wiki->space?->slug ?? '', $wiki->slug]) }}"
                                   class="text-indigo-600 hover:underline font-medium">
                                    {{ $wiki->name }}
                                </a>
                            </td>

                            <td class="px-4 py-2" colspan="2">
                                @if($wiki->organisation)
                                    <p><strong>Ministry:</strong> {{ $wiki->organisation->ministry?->name ?? '-' }}</p>
                                    @if($wiki->organisation->department)
                                        <p><strong>Department:</strong> {{ $wiki->organisation->department->name }}</p>
                                    @endif
                                    @if($wiki->organisation->segment)
                                        <p><strong>Division:</strong> {{ $wiki->organisation->segment->name }}</p>
                                    @endif
                                    @if($wiki->organisation->unit)
                                        <p><strong>Unit/Section:</strong> {{ $wiki->organisation->unit->name }}</p>
                                    @endif
                                    @if($wiki->organisation->subUnit)
                                        <p><strong>Sub Unit/Sub Section:</strong> {{ $wiki->organisation->subUnit->name }}</p>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-2">{{ $wiki->created_at?->format('d/m/Y h:i A') }}</td>
                            <td class="px-4 py-2">{{ $wiki->updated_at?->format('d/m/Y h:i A') }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-indigo-600">{{ $wiki->views }}</td>

                            <!-- AI Button -->
                            <td class="px-4 py-2 text-center">
                                <x-button wire:click="openAiModal('{{ $wiki->id }}')" class="inline-flex items-center space-x-1 text-sm text-blue-600 hover:text-blue-800">
                                    <x-icon name="sparkles" class="text-yellow-500 w-4 h-4" />
                                    <span>AI Info</span>
                                </x-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500 font-medium">No results found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Footer -->
            <div class="flex justify-end mt-4">
                {{ $wikis->links() }}
            </div>

            <!-- AI Modal -->
            @if ($showAiModal && $selectedWikiId)
                <div
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 px-4 sm:px-6"
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition.opacity.duration.300ms
                >
                    <livewire:wiki.wiki-article-ai
                        :wiki-id="$selectedWikiId"
                        :key="'wiki-ai-' . $selectedWikiId"
                    />
                </div>
            @endif
        </div>
    </div>
</div>
