<div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 relative">

    {{-- Loader Overlay --}}
    <div wire:loading.flex class="absolute inset-0 items-center justify-center bg-white/70 z-50">
        <div class="flex items-center space-x-3">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span class="text-gray-700 font-medium">Loading chatbots...</span>
        </div>
    </div>
                {{-- Header + Action Buttons --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">All ChatBot Data</h2>
        <div class="flex space-x-2 mt-3 md:mt-0">
            <button wire:click="$set('export', true)"
                    class="btn btn-gradient btn-info">
                Export Excel
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- Ministry Filter --}}
        <x-select.styled
            label="Ministry"
            placeholder="Select Ministry"
            wire:model="ministryFilter"
            :options="collect($ministries)->map(fn($m) => ['name' => (string)$m->name, 'id' => $m->ministry_id])->prepend(['name' => 'All Ministries', 'id' => ''])->toArray()"
            select="label:name|value:id"
        />

        {{-- Department Filter --}}
        <x-select.styled
            label="Department"
            placeholder="Select Department"
            wire:model="departmentFilter"
            :options="collect($departments)->map(fn($d) => ['name' => $d->name, 'id' => $d->department_id])->prepend(['name' => 'All Departments', 'id' => ''])->toArray()"
            select="label:name|value:id"
        />

        {{-- Status Filter --}}
        <x-select.styled
            label="Status"
            placeholder="Select Status..."
            wire:model.live="statusFilter"
            :options="array_merge([['name' => 'All Status', 'id' => '']], collect($statuses)->map(fn($name, $value) => ['name' => $name, 'id' => $value])->toArray())"
            select="label:name|value:id"
        />

        {{-- Language Filter --}}
        <x-select.styled
            label="Language"
            placeholder="Select Language..."
            wire:model.live="languageFilter"
            :options="array_merge([['name' => 'All Languages', 'id' => '']], collect($languages)->map(fn($name, $value) => ['name' => $name, 'id' => $value])->toArray())"
            select="label:name|value:id"
        />

        {{-- Region Filter --}}
        <x-select.styled
            label="Region"
            placeholder="Select Region..."
            wire:model.live="regionFilter"
            :options="array_merge([['name' => 'All Regions', 'id' => '']], collect($regions)->map(fn($name, $value) => ['name' => $name, 'id' => $value])->toArray())"
            select="label:name|value:id"
        />

        {{-- Date Filters --}}
        <x-input type="date" label="Start Date" wire:model="start_date" placeholder="Select start date" />
        <x-input type="date" label="End Date" wire:model="end_date" placeholder="Select end date" />

        {{-- Search --}}
        <x-input label="Search Chatbots" placeholder="Type to search..." wire:model.debounce.500ms="keySearch" />

        {{-- Filter Buttons --}}
        <div class="flex justify-end gap-3 pt-6 border-t md:col-span-4">
            <button class="btn btn-outline btn-error" wire:click="resetFilters">Reset</button>
            <button class="btn btn-outline btn-success" type="submit" loading>Search</xbutton>
        </div>
    </div>



    {{-- Table --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">No.</th>
                    <th class="px-4 py-2 text-left">Main Category</th>
                    <th class="px-4 py-2 text-left">Service</th>
                    <th class="px-4 py-2 text-left">Sub Service</th>
                    <th class="px-4 py-2 text-left">Organisation</th>
                    <th class="px-4 py-2 text-left">Created By</th>
                    <th class="px-4 py-2 text-left">Created At</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($chatbots as $i => $chatbot)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-2">{{ $chatbots->firstItem() + $i }}</td>
                        <td class="px-4 py-2">{{ $chatbot->main_category }}</td>
                        <td class="px-4 py-2">{{ $chatbot->service }}</td>
                        <td class="px-4 py-2">{{ $chatbot->sub_service ?: 'N/A' }}</td>
                       <td class="px-4 py-2">
                            <p><strong>Ministry:</strong> {{ $chatbot->organisation?->ministry?->name ?? '-' }}</p>
                            <p><strong>Department:</strong> {{ $chatbot->organisation?->department?->name ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-2">{{ $chatbot->user?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $chatbot->created_at->format('d/m/Y h:i A') }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                {{-- Show Data Button --}}
                                <div class="relative group">
                                    <x-button.circle
                                        color="blue"
                                        icon="eye"
                                        :href="route('chatbot.show', [$team->slug, $chatbot->slug])"
                                    />
                                    <span
                                        class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap"
                                    >
                                        Show Data
                                    </span>
                                </div>

                                {{-- Copy Ref ID Button --}}
                                <div class="relative group">
                                    <x-button.circle
                                        color="gray"
                                        icon="clipboard"
                                        type="button"
                                        x-on:click="navigator.clipboard.writeText('{{ $chatbot->ref_id }}').then(() => {
                                            alert('Copied: {{ $chatbot->ref_id }}');
                                        })"
                                    />
                                    <span
                                        class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap"
                                    >
                                        Copy Ref ID
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center px-4 py-6 text-gray-500">No results found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $chatbots->links() }}
    </div>
</div>
