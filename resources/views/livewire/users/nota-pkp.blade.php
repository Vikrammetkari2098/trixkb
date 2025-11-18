<div x-data="{ wikiType: @entangle('wikiTypeFilter') }" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 relative">

    <!-- Wiki Type Tabs -->
    <div class="flex space-x-2 mb-4">
        <template x-for="type in {{ json_encode($wikiTypes) }}" :key="type">
            <button @click="wikiType = type"
                    :class="{'bg-[#374151] text-white': wikiType === type, 'bg-gray-200 text-gray-800': wikiType !== type}"
                    class="px-4 py-2 rounded-lg">
                <span x-text="type.charAt(0).toUpperCase() + type.slice(1)"></span>
            </button>
        </template>
    </div>

    <!-- Filters Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <template x-if="wikiType !== 'general'">
            <div class="contents">
                {{-- Ministry --}}
                <x-select.styled
                    label="Ministry"
                    placeholder="Select Ministry"
                    wire:model="ministryFilter"
                    :options="collect($ministries_list)
                                ->map(fn($m) => ['name' => $m->name, 'id' => $m->id])
                                ->prepend(['name' => 'All Ministries', 'id' => ''])
                                ->toArray()"
                    select="label:name|value:id"
                />

                {{-- Department --}}
                <x-select.styled
                    label="Department"
                    placeholder="Select Department"
                    wire:model="departmentFilter"
                    :options="collect($departments_list)
                                ->map(fn($d) => ['name' => $d->name, 'id' => $d->id])
                                ->prepend(['name' => 'All Departments', 'id' => ''])
                                ->toArray()"
                    select="label:name|value:id"
                />

                {{-- Division --}}
                <x-select.styled
                    label="Division"
                    placeholder="Select Division"
                    wire:model="segmentFilter"
                    :options="collect($segments_list)
                                ->map(fn($s) => ['name' => $s->name, 'id' => $s->id])
                                ->prepend(['name' => 'All Divisions', 'id' => ''])
                                ->toArray()"
                    select="label:name|value:id"
                />

                {{-- Unit --}}
                <x-select.styled
                    label="Unit/Section"
                    placeholder="Select Unit/Section"
                    wire:model="unitFilter"
                    :options="collect($units_list)
                                ->map(fn($u) => ['name' => $u->name, 'id' => $u->id])
                                ->prepend(['name' => 'All Units', 'id' => ''])
                                ->toArray()"
                    select="label:name|value:id"
                />

                {{-- Sub Unit --}}
                <x-select.styled
                    label="Sub Unit"
                    placeholder="Select Sub Unit"
                    wire:model="subUnitFilter"
                    :options="collect($sub_units_list)
                                ->map(fn($su) => ['name' => $su->name, 'id' => $su->id])
                                ->prepend(['name' => 'All Sub Units', 'id' => ''])
                                ->toArray()"
                    select="label:name|value:id"
                />
            </div>
        </template>

        <!-- Show Category only for Article -->
        <template x-if="wikiType === 'article'">
            <x-select.styled
                label="Category"
                placeholder="Select Category"
                wire:model="artCategoryFilter"
                :options="collect($artCategories)
                            ->map(fn($c) => ['name' => $c['name'], 'id' => $c['id']])
                            ->prepend(['name' => 'All Categories', 'id' => ''])
                            ->toArray()"
                select="label:name|value:id"
            />
        </template>

        {{-- Reported By --}}
        <x-select.styled
            label="Reported By"
            placeholder="Select Agent"
            wire:model="pkpAgentFilter"
            :options="collect($pkpAgents)
                        ->map(fn($a) => ['name' => $a->name, 'id' => $a->id])
                        ->prepend(['name' => 'All Agents', 'id' => ''])
                        ->toArray()"
            select="label:name|value:id"
        />

        {{-- Days --}}
        <x-select.styled
            label="No. of Days Not Solved"
            placeholder="Select Days"
            wire:model="daysNumberFilter"
            :options="collect($daysNumbers)
                        ->map(fn($d) => ['name' => $d, 'id' => $d])
                        ->prepend(['name' => 'All', 'id' => ''])
                        ->toArray()"
            select="label:name|value:id"
        />

        {{-- Child Data --}}
        <div class="flex justify-between items-center pt-6 border-t md:col-span-4">
            <!-- Left Side: Child Data -->
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model="isChildDataIncluded" class="form-checkbox">
                <span>Include child data?</span>
            </label>

            <!-- Right Side: Buttons -->
            <div class="flex gap-3">
                <button  class="btn btn-outline btn-error"  wire:click="resetFilters">Reset</button>
                <button  class="btn btn-outline btn-success" type="submit" loading>Search</button>
            </div>
        </div>
    </div>

    <!-- Tables per Tab -->
    <div>
        <!-- General Table -->
        <div x-show="wikiType === 'general'" x-cloak>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">No of Days</th>
                            <th class="px-4 py-2">Created By</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2 text-center">View General</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($comments as $i => $comment)
                        <tr class="{{ $comment->days_since_updated > 5 ? 'bg-yellow-100 animate-pulse' : '' }}">
                            <td class="px-4 py-2">{{ $comments->firstItem() + $i }}</td>
                            <td class="px-4 py-2">{{ $comment->title }}</td>
                            <td class="px-4 py-2">{{ $comment->days_since_updated }}</td>
                            <td class="px-4 py-2">{{ $comment->user->name }}</td>
                            <td class="px-4 py-2">{{ $comment->created_at->format('d/m/Y h:i A') }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('comments.show', [$team->slug, $comment->id]) }}" class="text-indigo-600 hover:underline">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">No results found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Article Table -->
        <div x-show="wikiType === 'article'" x-cloak>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Organization</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">No of Days</th>
                            <th class="px-4 py-2">Created By</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2 text-center">View Article</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($comments as $i => $comment)
                        <tr class="{{ $comment->days_since_updated > 5 ? 'bg-yellow-100 animate-pulse' : '' }}">
                            <td class="px-4 py-2">{{ $comments->firstItem() + $i }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('wikis.notaPKP', [$team->slug, $comment->wiki->space->slug, $comment->wiki->slug, $comment->slug]) }}" class="text-indigo-600 hover:underline">
                                    {{ $comment->title ?? 'Nota PKP' }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                @if($comment->wiki->organisation->ministry) <p><strong>Ministry:</strong> {{ $comment->wiki->organisation->ministry->name }}</p> @endif
                                @if($comment->wiki->organisation->department) <p><strong>Department:</strong> {{ $comment->wiki->organisation->department->name }}</p> @endif
                                @if($comment->wiki->organisation->segment) <p><strong>Division:</strong> {{ $comment->wiki->organisation->segment->name }}</p> @endif
                                @if($comment->wiki->organisation->unit) <p><strong>Unit:</strong> {{ $comment->wiki->organisation->unit->name }}</p> @endif
                                @if($comment->wiki->organisation->subUnit) <p><strong>Sub Unit:</strong> {{ $comment->wiki->organisation->subUnit->name }}</p> @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($comment->status == 'Baru')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">New</span>
                                @elseif($comment->status == 'Dalam Tindakan')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">In Progress</span>
                                @elseif($comment->status == 'Selesai')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $comment->days_since_updated }}</td>
                            <td class="px-4 py-2">{{ $comment->user->name }}</td>
                            <td class="px-4 py-2">{{ $comment->created_at->format('d/m/Y h:i A') }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('wikis.show', [$team->slug, $comment->wiki->space->slug, $comment->wiki->slug]) }}" class="text-indigo-600 hover:underline">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">No results found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Directory/Nota Table -->
        <div x-show="wikiType === 'directory'" x-cloak>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Organization</th>
                            <th class="px-4 py-2">No of Days</th>
                            <th class="px-4 py-2">Created By</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2 text-center">View Directory</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($comments as $i => $comment)
                        <tr class="{{ $comment->days_since_updated > 5 ? 'bg-yellow-100 animate-pulse' : '' }}">
                            <td class="px-4 py-2">{{ $comments->firstItem() + $i }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('wikis.notaPKP', [$team->slug, $comment->wiki->space->slug, $comment->wiki->slug, $comment->slug]) }}" class="text-indigo-600 hover:underline">
                                    {{ $comment->title ?? 'Nota PKP' }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                @if($comment->wiki->organisation->ministry) <p><strong>Ministry:</strong> {{ $comment->wiki->organisation->ministry->name }}</p> @endif
                                @if($comment->wiki->organisation->department) <p><strong>Department:</strong> {{ $comment->wiki->organisation->department->name }}</p> @endif
                                @if($comment->wiki->organisation->segment) <p><strong>Division:</strong> {{ $comment->wiki->organisation->segment->name }}</p> @endif
                                @if($comment->wiki->organisation->unit) <p><strong>Unit:</strong> {{ $comment->wiki->organisation->unit->name }}</p> @endif
                                @if($comment->wiki->organisation->subUnit) <p><strong>Sub Unit:</strong> {{ $comment->wiki->organisation->subUnit->name }}</p> @endif
                            </td>
                            <td class="px-4 py-2">{{ $comment->days_since_updated }}</td>
                            <td class="px-4 py-2">{{ $comment->user->name }}</td>
                            <td class="px-4 py-2">{{ $comment->created_at->format('d/m/Y h:i A') }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('wikis.show', [$team->slug, $comment->wiki->space->slug, $comment->wiki->slug]) }}" class="text-indigo-600 hover:underline">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">No results found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- Pagination --}}
    <div class="mt-4">
        {{ $comments->links() }}
    </div>
</div>
