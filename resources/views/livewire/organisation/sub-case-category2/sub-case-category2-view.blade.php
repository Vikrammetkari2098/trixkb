<div>
    @if($subCaseCategory2)
        <div class="grid grid-cols-1 gap-4">
            <div>
                <strong>Name:</strong> {{ $subCaseCategory2->name }}
            </div>
            <div>
                <strong>Status:</strong>
                <span class="{{ $subCaseCategory2->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $subCaseCategory2->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div>
                <strong>Created By:</strong> {{ $subCaseCategory2->user->name ?? 'N/A' }}
            </div>
        </div>
    @else
        <p class="text-gray-500">No data loaded.</p>
    @endif
</div>
