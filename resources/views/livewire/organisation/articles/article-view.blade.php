<div class="space-y-4">

    <div>
        <h3 class="font-semibold">Title</h3>
        <p>{{ $article->name ?? '-' }}</p>
    </div>

    <div>
        <h3 class="font-semibold">Description</h3>
        <p>{{ $article->description ?? '-' }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <h3 class="font-semibold">Active Date</h3>
            <p>{{ $article->active_date ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">Expiry Date</h3>
            <p>{{ $article->expiry_date ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">Start Date</h3>
            <p>{{ $article->start_date ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">End Date</h3>
            <p>{{ $article->end_date ?? '-' }}</p>
        </div>
    </div>

    <div>
        <h3 class="font-semibold">Organisation</h3>
        <p>
            {{ $article->organisation?->name ?? '-' }}
        </p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <h3 class="font-semibold">Ministry</h3>
            <p>{{ $article->organisation?->ministry->name ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">Department</h3>
            <p>{{ $article->organisation?->department->name ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">Segment</h3>
            <p>{{ $article->organisation?->segment->name ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">Unit</h3>
            <p>{{ $article->organisation?->unit->name ?? '-' }}</p>
        </div>

        <div>
            <h3 class="font-semibold">Sub Unit</h3>
            <p>{{ $article->organisation?->subUnit->name ?? '-' }}</p>
        </div>
    </div>

    <div>
        <h3 class="font-semibold">Categories</h3>
        @foreach($article->categories ?? [] as $cat)
            <span class="px-2 py-1 text-sm bg-gray-200 rounded">{{ $cat->name }}</span>
        @endforeach
    </div>

    <div>
        <h3 class="font-semibold">Spaces</h3>
        @foreach($article->spaces ?? [] as $space)
            <span class="px-2 py-1 text-sm bg-gray-200 rounded">{{ $space->name }}</span>
        @endforeach
    </div>
</div>
