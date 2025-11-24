<div class="bg-gray-50 p-6 rounded-2xl shadow-lg"
     x-data="{
        activeTab: 'ministry',
        departmentLoaded: false,
        segmentLoaded: false,
        unitLoaded: false,
        subUnitLoaded: false,
        segmentLoaded: false,
        unitLoaded: false,
        subUnitLoaded: false,
        matrixLoaded: false,
        caseCategoryLoaded: false,
        subCaseCategory1Loaded: false,
        subCaseCategory2Loaded: false,
        categoryMatrixLoaded: false,
        matrixUploadLoaded: false,
        directoriesLoaded: false,
        articlesLoaded: false,
        dataTransferLoaded: false,
        approvalFlowLoaded: false,
        statusLoaded: false
        }">

    {{-- Modals --}}
    <x-modal id="modal-create-ministry" center x-data="{ show: false }" x-show="show"
             x-on:open-modal-create-ministry.window="show = true"
             x-on:close-modal-create-ministry.window="show = false">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Create Ministry</h2>
        <livewire:organisation.ministry-create />
    </x-modal>

    <x-modal id="modal-edit-ministry" center x-data="{ show: false }" x-show="show"
             x-on:open-modal-edit-ministry.window="show = true"
             x-on:close-modal-edit-ministry.window="show = false">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Edit Ministry</h2>
        <livewire:organisation.ministry-edit />
    </x-modal>

    <x-modal id="modal-view-ministry" center x-data="{ show: false }" x-show="show"
             x-on:open-modal-view-ministry.window="show = true"
             x-on:close-modal-view-ministry.window="show = false">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Ministry Information</h2>
        <livewire:organisation.ministry-view />
    </x-modal>

    {{-- Top Navigation Menu --}}
    <ul class="flex flex-wrap gap-2 mb-6">
        @php
            $tabs = [
                'ministry' => ['label' => 'Ministry', 'color' => 'bg-blue-500 text-white'],
                'department' => ['label' => 'Department', 'color' => 'bg-green-500 text-white'],
                'segment' => ['label' => 'Division', 'color' => 'bg-yellow-500 text-white'],
                'unit' => ['label' => 'Unit/Section', 'color' => 'bg-purple-500 text-white'],
                'subUnit' => ['label' => 'Sub Unit/Sub Section', 'color' => 'bg-pink-500 text-white'],
                'matrix' => ['label' => 'Matrix', 'color' => 'bg-teal-500 text-white'],
                'caseCategory' => ['label' => 'Case Categories', 'color' => 'bg-violet-500 text-white'],
                'subCaseCategory1' => ['label' => 'Sub Case Categories 1', 'color' => 'bg-orange-500 text-white'],
                'subCaseCategory2' => ['label' => 'Sub Case Categories 2', 'color' => 'bg-red-500 text-white'],
                'categoryMatrix' => ['label' => 'Category Matrix', 'color' => 'bg-sky-500 text-white'],
                'matrixUpload' => ['label' => 'Matrix Upload', 'color' => 'bg-lime-600 text-white'],
                'directories' => ['label' => 'Directories', 'color' => 'bg-gray-700 text-white'],
                'articles' => ['label' => 'Articles', 'color' => 'bg-fuchsia-600 text-white'],
                'dataTransfer' => ['label' => 'Data Transfer', 'color' => 'bg-emerald-600 text-white'],
                'approvalFlow' => ['label' => 'Approval Flow', 'color' => 'bg-rose-600 text-white'],
                'status' => ['label' => 'Status', 'color' => 'bg-amber-600 text-white'],
            ];
        @endphp

        @foreach($tabs as $key => $tab)
            <li>
                <button type="button"
                    @click="activeTab='{{ $key }}'; {{ $key }}Loaded = true"
                    :class="activeTab === '{{ $key }}'
                        ? '{{ $tab['color'] }} ring-2 ring-offset-2 ring-gray-300 transform scale-105'
                        : '{{ $tab['color'] }} opacity-60 hover:opacity-100'"
                    class="px-4 py-2 rounded-lg font-medium transition-all duration-200">
                    {{ $tab['label'] }}
                </button>
            </li>
        @endforeach
    </ul>

    {{-- Content for each tab --}}
    <div class="space-y-6">

        {{-- Ministry --}}
        <div x-show="activeTab === 'ministry'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Ministries</h1>
                <x-button color="green" x-on:click="$modalOpen('modal-create-ministry')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Ministry
                </x-button>
            </div>

            {{-- Filters --}}
            <div class="flex flex-col md:flex-row gap-4 items-end mb-6">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model="statusFilter"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>
                        @foreach($ministriesStatus as $item)
                            <option value="{{ $item['value'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <x-button color="neutral" wire:click="resetFilters">Clear</x-button>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-xl shadow-inner">
                <x-table :headers="$headers" :rows="$rows" filter search>
                    @interact('column_status', $row)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $row->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    @endinteract
                    @interact('column_action', $row)
                        <!-- @dump($row) -->
                        <div class="flex gap-2">
                            <x-button.circle size="sm" color="yellow" icon="pencil"
                                title="Edit" wire:click="$dispatch('loadData-edit-ministry', { id: {{ $row->id }} })"
                                class="hover:scale-110 hover:shadow-[0_0_10px_rgba(99,102,241,0.4)] transition-all duration-300" />

                            <x-button.circle size="sm" color="blue" icon="eye"
                                title="View" wire:click="$dispatch('loadData-view-ministry', { id: {{ $row->id }} })"
                                class="hover:scale-110 hover:shadow-[0_0_10px_rgba(59,130,246,0.4)] transition-all duration-300" />
                        </div>
                    @endinteract

                </x-table>
            </div>

            <div class="mt-6">{{ $rows->links() }}</div>
        </div>

        {{-- Department --}}
        <div x-show="activeTab === 'department'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="departmentLoaded">
                <livewire:organisation.department.department-list />
            </template>
        </div>

        {{-- Division --}}
        <div x-show="activeTab === 'segment'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="segmentLoaded">
                <livewire:organisation.segment.segment-list />
            </template>
        </div>

        {{-- Unit --}}
        <div x-show="activeTab === 'unit'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="unitLoaded">
                 <livewire:organisation.unit.unit-list />
            </template>
        </div>

            {{-- Sub Unit --}}
        <div x-show="activeTab === 'subUnit'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="subUnitLoaded">
                <livewire:organisation.subunit.subunit-list />
            </template>
        </div>

            {{-- Matrix --}}
        <div x-show="activeTab === 'matrix'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="matrixLoaded">
                <livewire:organisation.matrix.matrix-list />
            </template>
        </div>
            {{-- Case Categories --}}
        <div x-show="activeTab === 'caseCategory'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="caseCategoryLoaded">
                <livewire:organisation.casecategory.case-category-list />
            </template>
        </div>
            {{-- Sub Case Categories 1 --}}
        <div x-show="activeTab === 'subCaseCategory1'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="subCaseCategory1Loaded">
                <livewire:organisation.subcasecategory1.sub-case-category1-list />
            </template>
        </div>
        <div x-show="activeTab === 'subCaseCategory2'">
            <template x-if="subCaseCategory2Loaded">
                <livewire:organisation.subcasecategory2.sub-case-category2-list />
            </template>
        </div>
          {{-- Category Matrix --}}
        <div x-show="activeTab === 'categoryMatrix'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="categoryMatrixLoaded">
                <livewire:organisation.category-matrix.category-matrix-list />
            </template>
        </div>
        {{-- Matrix Upload --}}
        <div x-show="activeTab === 'matrixUpload'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="matrixUploadLoaded">
                <livewire:organisation.matrix-upload />
            </template>
        </div>
         {{-- Directories --}}
        <div x-show="activeTab === 'directories'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="directoriesLoaded">
                <livewire:organisation.directories.directory-list />
            </template>
        </div>
         {{-- Articles --}}
        <div x-show="activeTab === 'articles'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="articlesLoaded">
                <livewire:organisation.articles.article-list />
            </template>
        </div>
         {{-- Data Transfer --}}
        <div x-show="activeTab === 'dataTransfer'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="dataTransferLoaded">
               <livewire:organisation.data-transfer :team="$team" />
            </template>
        </div>
        {{-- Approval Flow --}}
        <div x-show="activeTab === 'approvalFlow'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="approvalFlowLoaded">
                <livewire:organisation.approvalflow.approval-flow :team="$team" />
            </template>
        </div>
        {{-- Status --}}
        <div x-show="activeTab === 'status'" class="bg-white p-6 rounded-2xl shadow-lg transition duration-300">
            <template x-if="statusLoaded">
                <livewire:organisation.status.status-list :team="$team" />
            </template>
        </div>

    </div>
</div>
