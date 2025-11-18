<div>
    @if($subCaseCategory1)
        <div class="space-y-2">
            <div>
                <strong>Name:</strong> {{ $subCaseCategory1->name }}
            </div>
            <div>
                <strong>Slug:</strong> {{ $subCaseCategory1->slug }}
            </div>
            <div>
                <strong>Status:</strong>
                <span class="px-2 py-1 rounded-full text-xs font-semibold
                    {{ $subCaseCategory1->status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $subCaseCategory1->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div>
                <strong>Created By:</strong> {{ $subCaseCategory1->user->name ?? 'N/A' }}
            </div>
            <div>
                <strong>Created At:</strong> {{ $subCaseCategory1->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    @else
        <p>No data to display.</p>
    @endif
</div>
