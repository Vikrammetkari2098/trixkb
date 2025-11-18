<div id="modal-view-category-matrix" center
    x-data="{ show: false }"
    x-show="show"
    x-on:open-modal-view-category-matrix.window="show = true"
    x-on:close-modal-view-category-matrix.window="show = false">

    <div class="p-6 space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">
            View Category Matrix
        </h2>

        @if ($matrix)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Ministry</p>
                    <p>{{ $matrix->ministry->name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Department</p>
                    <p>{{ $matrix->department->name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Case Category</p>
                    <p>{{ $matrix->caseCategory->category_name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Sub Category 1</p>
                    <p>{{ $matrix->subCategory1->name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Sub Category 2</p>
                    <p>{{ $matrix->subCategory2->name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Status</p>
                    <x-badge :color="$matrix->status ? 'green' : 'red'">
                        {{ $matrix->status ? 'Active' : 'Inactive' }}
                    </x-badge>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Created By</p>
                    <p>{{ $matrix->created_by ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500">Created At</p>
                    <p>{{ $matrix->created_at ? $matrix->created_at->format('d M Y, h:i A') : '—' }}</p>
                </div>
            </div>
        @else
            <p class="text-gray-500 text-center py-6">No data found.</p>
        @endif

        <div class="flex justify-end border-t pt-4">
            <x-button color="gray" x-on:click="show = false">
                Close
            </x-button>
        </div>
    </div>
</div>

