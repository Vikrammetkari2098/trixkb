<div x-data="reportTabs()" class="space-y-4">
    <!-- Page title -->
    <div class="flex justify-between items-center pb-3 border-b">
        <h2 class="text-xl font-semibold">Reporting</h2>
    </div>

    <!-- Main Tabs -->
    <div class="flex gap-2 border-b">
        <template x-for="tab in mainTabs" :key="tab.key">
            <button
                @click="selectMain(tab.key)"
                :class="main === tab.key ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'"
                class="px-4 py-2 border-b-2 font-medium hover:text-blue-600 transition">
                <span x-text="tab.label"></span>
            </button>
        </template>
    </div>

    <!-- Sub Tabs -->
    <template x-if="main !== 'general'">
        <div class="flex gap-2 flex-wrap border-b pb-2">
            <template x-for="sub in filteredSubTabs" :key="sub.type">
                <a :href="sub.url"
                    :class="type === sub.type ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-3 py-1 rounded-md text-sm font-medium hover:bg-blue-500 hover:text-white transition">
                    <span x-text="sub.label"></span>
                </a>
            </template>
        </div>
    </template>

    <!-- Content -->
    <div>
        @include($viewPath)
    </div>
</div>
<script>
function reportTabs() {
    // get current type from server (safe string)
    const currentType = "{{ request()->get('type') ?? '' }}";

    // JS map from type -> main tab
    const typeToMain = {
        'general-report': 'general',
        'categories': 'article',
        'categories2': 'directory',
        'activity': 'article',
        'activity2': 'directory',
        'logs-wikis': 'article',
        'logs-wikis2': 'directory',
        'direCount': 'directory',
        'artCount': 'article',
        'directory-transaction': 'directory',
        'article-access': 'article',
        'article-status': 'article',
        'notaPKP-status': 'other',
        'notaPKP-users': 'other',
        'directory-transaction-2': 'directory',
        'article-entries': 'article',
        'login-statistics': 'other',
        'auditTrail': 'other'
    };

    // compute initial main tab; default to 'general' if unknown
    const initialMain = typeToMain[currentType] || 'general';
    // compute initial type (if empty, fallback to default based on role)
    const initialType = currentType || '{{ auth()->user()->current_role_id != \App\Helpers\GeneralHelper::userInternalContentCreator() ? "general-report" : "direCount" }}';

    return {
        main: initialMain,
        type: initialType,

        mainTabs: [
            { key: 'general', label: 'General' },
            { key: 'article', label: 'Article' },
            { key: 'directory', label: 'Directory' },
            { key: 'other', label: 'Other' }
        ],

        allSubTabs: [
            @if(auth()->user()->current_role_id == \App\Helpers\GeneralHelper::userInternalContentCreator())
                { type: 'direCount', label: 'Directory Count', key: 'directory' },
                { type: 'artCount', label: 'Article Count', key: 'article' },
            @else
                { type: 'general-report', label: 'General Report', key: 'general' },
                { type: 'categories', label: 'Article Create', key: 'article' },
                { type: 'activity', label: 'Article Update', key: 'article' },
                { type: 'logs-wikis', label: 'Article Delete', key: 'article' },
                { type: 'categories2', label: 'Directory Create', key: 'directory' },
                { type: 'activity2', label: 'Directory Update', key: 'directory' },
                { type: 'logs-wikis2', label: 'Directory Delete', key: 'directory' },
                { type: 'direCount', label: 'Directory Count', key: 'directory' },
                { type: 'artCount', label: 'Article Count', key: 'article' },
                { type: 'directory-transaction', label: 'Directory Transaction', key: 'directory' },
                { type: 'article-access', label: 'Article Access', key: 'article' },
                { type: 'article-status', label: 'Article Status', key: 'article' },
                { type: 'notaPKP-status', label: 'Nota PKP Status', key: 'other' },
                { type: 'notaPKP-users', label: 'Nota PKP Users', key: 'other' },
                { type: 'directory-transaction-2', label: 'Directory Transaction BY CC', key: 'directory' },
                { type: 'article-entries', label: 'Article Entries', key: 'article' },
                { type: 'login-statistics', label: 'Login Statistics', key: 'other' },
                { type: 'auditTrail', label: 'Audit Trail', key: 'other' },
            @endif
        ],

        get filteredSubTabs() {
            // return only subTabs that match the current main tab
            return this.allSubTabs
                .filter(tab => tab.key === this.main)
                .map(item => ({
                    ...item,
                    url: `{{ route('reports.reportings', [$team->slug, Auth::user()->slug]) }}?type=${item.type}`
                }));
        },

        selectMain(tabKey) {
            if (tabKey === 'general') {
                // navigate to base reports route without query string
                window.location.href = "{{ route('reports.reportings', [$team->slug, Auth::user()->slug]) }}";
                return;
            }
            this.main = tabKey;
        }
    };
}
</script>

