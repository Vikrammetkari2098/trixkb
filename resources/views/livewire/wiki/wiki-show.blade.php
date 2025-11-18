<div x-data="wikiPage()" class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h2 class="text-lg font-semibold">All {{ $title }} Details - Latest</h2>

        <div class="flex gap-2">
            @if (auth()->user()->hasPermission('add_page'))
                @if($title == 'Directory')
                    <!-- Download Excel Button -->
                    <button
                        x-on:click="$dispatch('open-download-popup')"
                        class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        <i class="fa fa-download mr-1"></i>
                        Download {{ $title }}
                    </button>
                @endif

                @if ($title != 'Case')
                    <a href="{{ route('wikis.create', [$team->slug]) }}?type={{ $pageType }}"
                       class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        <i class="fa fa-plus mr-1"></i>
                        Create {{ $title }}
                    </a>
                @endif
            @endif
        </div>
    </div>

    <!-- Wiki List Content -->
    <div class="p-4">
    {{-- Page Heading --}}
    <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>
    {{-- Conditional Partials --}}
    @if ($title === 'Directory')
        <section class="directories-table pt-4">
            @include('wiki.partials.directories-table')
        </section>

    @elseif ($title === 'Article')
        <section class="wiki-articles-table pt-4">
          <livewire:wiki.wiki-article-table :team="$team" />
        </section>

    @else
        <section class="tickets-table pt-4">
            @include('user.partials.tickets-table')
        </section>
    @endif
</div>

</div>

<script>
function wikiPage() {
    return {
        filters: {
            ministry: '',
            department: '',
            segment: '',
            unit: '',
            subUnit: '',
            search: ''
        },
        clearFilters() {
            this.filters = {
                ministry: '',
                department: '',
                segment: '',
                unit: '',
                subUnit: '',
                search: ''
            };
        }
    }
}
</script>
