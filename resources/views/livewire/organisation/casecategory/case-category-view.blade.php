<div>
    @if($caseCategory)
        <div class="space-y-4">
            <div><strong>Name:</strong> {{ $caseCategory->name }}</div>
            <div><strong>Slug:</strong> {{ $caseCategory->slug }}</div>
            <div>
                <strong>Status:</strong>
                <span class="{{ $caseCategory->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 text-xs rounded">
                    {{ $caseCategory->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div><strong>Created By:</strong> {{ $caseCategory->user->name ?? 'N/A' }}</div>
            <div><strong>Created At:</strong> {{ $caseCategory->created_at?->format('d M Y, h:i A') }}</div>
        </div>
    @else
        <p class="text-gray-500">No details available.</p>
    @endif
</div>
