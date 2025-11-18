<div class="bg-white p-6 rounded-2xl shadow-lg">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b-2 border-black pb-4 mb-4 w-full">
        <h1 class="text-xl font-semibold">Articles</h1>

        <x-button color="green"
            x-on:click="$dispatch('open-modal-create-article')"
            class="font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Article
        </x-button>
    </div>

    {{-- Create --}}
    <x-modal id="modal-create-article"
        x-data="{ show: false }"
        x-show="show"
        x-on:open-modal-create-article.window="show = true"
        x-on:close-modal-create-article.window="show = false"
        center>
        <h2 class="text-xl font-semibold mb-4">Create Article</h2>
        <livewire:wiki.wiki-create />
    </x-modal>

    {{-- Edit --}}
    <x-modal id="modal-edit-article"
        x-data="{ show: false }"
        x-show="show"
        x-on:open-modal-edit-wiki.window="show = true"
       x-on:close-modal-edit-wiki.window="show = false"
        center>
        <h2 class="text-xl font-semibold mb-4">Edit Article</h2>
        <livewire:wiki.wiki-edit />
    </x-modal>
    <livewire:wiki.wiki-delete />

    <x-modal id="modal-view-article"
        x-data="{ show: false }"
        x-show="show"
        x-on:open-modal-view-article.window="show = true"
        x-on:close-modal-view-article.window="show = false"
        center>

        <h2 class="text-xl font-semibold mb-4">Article Details</h2>

        <livewire:organisation.articles.article-view />
    </x-modal>

    <div class="flex flex-col md:flex-row gap-4 mb-6 items-end">

        <div class="flex-1">
            <label class="text-sm font-medium text-gray-700 mb-1 block">Ministry</label>
            <x-select.styled wire:model="ministryFilter" :options="$ministries_list" placeholder="Select Ministry" class="w-full" />
        </div>

        <div class="flex-1">
            <label class="text-sm font-medium text-gray-700 mb-1 block">Department</label>
            <x-select.styled wire:model="departmentFilter" :options="$departments_list" placeholder="Select Department" class="w-full" />
        </div>

        <div class="flex-1">
            <label class="text-sm font-medium text-gray-700 mb-1 block">Division / Segment</label>
            <x-select.styled wire:model="segmentFilter" :options="$segments_list" placeholder="Select Division" class="w-full" />
        </div>

        <div class="flex-1">
            <label class="text-sm font-medium text-gray-700 mb-1 block">Unit / Section</label>
            <x-select.styled wire:model="unitFilter" :options="$units_list" placeholder="Select Unit" class="w-full" />
        </div>

        <div class="flex-1">
            <label class="text-sm font-medium text-gray-700 mb-1 block">Sub Unit / Sub Section</label>
            <x-select.styled wire:model="subUnitFilter" :options="$subUnits_list" placeholder="Select Sub Unit" class="w-full" />
        </div>

    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-6 items-center">

        <div class="flex-1">
            <x-input
                wire:model.debounce.500ms="barSearch"
                placeholder="Search by name or description"
                class="w-full" />
        </div>

        <x-button color="neutral" wire:click="
            ministryFilter = null;
            departmentFilter = null;
            segmentFilter = null;
            unitFilter = null;
            subUnitFilter = null;
            barSearch = '';
        ">
            Clear
        </x-button>
    </div>

    <div class="overflow-x-auto">
        <x-table
            :rows="$rows"
            :headers="[
                ['index'=>'id','label'=>'No.'],
                ['index'=>'name','label'=>'Name'],
                ['index'=>'organisation_data','label'=>'Organisation'],
                ['index'=>'created_by_name','label'=>'Created By'],
                ['index'=>'action','label'=>'Actions']
            ]"
            filter search paginate>

            {{-- Name --}}
            @interact('column_name', $row)
                {{ $row['name'] }}
            @endinteract

            {{-- Organisation --}}
            @interact('column_organisation_data', $row)
                <div>
                    @foreach($row->organisation_data as $key => $value)
                        @if($value !== '-')
                            <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
                        @endif
                    @endforeach
                </div>
            @endinteract

            {{-- Created By --}}
            @interact('column_created_by_name', $row)
                {{ $row->created_by_name }}
            @endinteract

            {{-- Actions --}}
            @interact('column_action', $row)
            <div class="flex gap-2">
                <x-button.circle
                    color="blue"
                    icon="eye"
                    wire:click="$dispatch('loadData-view-article', {{ json_encode(['id' => $row->id]) }})"
                    x-on:click="$dispatch('open-modal-view-article')"
                    title="View"
                />

                {{-- Edit --}}
                <x-button.circle color="yellow" icon="pencil"
                    wire:click="$dispatch('loadData-edit-wiki', { id: {{ $row->id }} })"
                    title="Edit"
                    class="hover:scale-110 transition" />

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

    <div class="mt-4 text-sm text-gray-600">
        {{ $rows->total() }} results found
        <div class="mt-2">
            {{ $rows->links() }}
        </div>
    </div>

</div>
