<div class="bg-white rounded-xl shadow-soft overflow-hidden p-4 md:p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Documents</h2>
        <button class="btn btn-primary btn-sm">
            Upload New
        </button>
    </div>

    {{-- Search --}}
    <div class="relative mb-4 w-full md:w-64">
        <input type="text"
            wire:model.debounce.500ms="search"
            placeholder="Search documents..."
            class="input input-bordered input-sm w-full pl-10"
        >
        <span class="icon-[tabler--search] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 size-5"></span>
    </div>

    {{-- Document Table --}}
    @if($documents->count() > 0)
        <div class="overflow-x-auto">
            <table class="table table-striped table-hover w-full text-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Uploaded By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                        <tr>
                            <td>{{ $doc->name }}</td>
                            <td>{{ $doc->type }}</td>
                            <td>{{ $doc->uploadedBy->name ?? '-' }}</td>
                            <td>{{ $doc->created_at->format('d M Y') }}</td>
                            <td class="flex gap-2">
                                <button class="btn btn-circle btn-text btn-sm" title="Edit">
                                    <span class="icon-[tabler--pencil] size-5"></span>
                                </button>
                                <button class="btn btn-circle btn-text btn-sm" title="Delete">
                                    <span class="icon-[tabler--trash] size-5"></span>
                                </button>
                                <button class="btn btn-circle btn-text btn-sm" title="More">
                                    <span class="icon-[tabler--dots-vertical] size-5"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $documents->links() }}
        </div>
    @else
        <div class="text-center py-10">
            <img src="{{ asset('image/document.png') }}" class="mx-auto w-40 mb-4">
            <h3 class="text-lg font-semibold text-gray-600">No documents found</h3>
            <p class="text-gray-500">Upload your first document to get started.</p>
        </div>
    @endif

</div>
