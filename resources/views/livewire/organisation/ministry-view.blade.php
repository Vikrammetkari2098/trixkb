<div>
    @if($ministry)
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2">{{ $ministry->name }}</h2>
            <p class="text-gray-700 mb-1"><strong>Short Name:</strong> {{ $ministry->short_name ?? '-' }}</p>
            <p class="text-gray-700 mb-1"><strong>Status:</strong> {{ $ministry->status == 1 ? 'Active' : 'Inactive' }}</p>
            <p class="text-gray-700 mb-1"><strong>Slug:</strong> {{ $ministry->slug }}</p>
        </div>
    @else
        <p>Loading ministry details...</p>
    @endif
</div>
