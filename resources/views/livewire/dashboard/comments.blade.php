
<div class="bg-white rounded-xl shadow-soft p-5 md:p-6 border border-gray-100" x-data="commentsData()">

            <!-- Header Section -->
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Comments</h3>
                <span class="text-sm text-gray-500 mt-0.5">Last updated 20 minutes ago</span>
            </div>

            <!-- Tab Navigation Section -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-4 mb-4">
                <!-- All Tab -->
                <button @click="setActiveTab('all')"
                    :class="{
                        'bg-violet-100 text-violet-700 font-semibold border-violet-500': activeTab === 'all',
                        'bg-gray-100 text-gray-700 hover:bg-gray-200 border-gray-300': activeTab !== 'all'
                    }"
                    class="flex items-center space-x-1 py-1 px-3 text-sm rounded-lg border-2 transition-colors duration-150">
                    <span>All</span>
                    <span class="font-bold ml-1" x-text="metrics.all">10</span>
                </button>

                <!-- Mentioned Me Tab -->
                <button @click="setActiveTab('mentioned')"
                    :class="{
                        'bg-violet-100 text-violet-700 font-semibold border-violet-500': activeTab === 'mentioned',
                        'bg-gray-100 text-gray-700 hover:bg-gray-200 border-gray-300': activeTab !== 'mentioned'
                    }"
                    class="flex items-center space-x-1 py-1 px-3 text-sm rounded-lg border-2 transition-colors duration-150">
                    <span>Mentioned me</span>
                    <span class="font-bold ml-1" x-text="metrics.mentioned">5</span>
                </button>

                <!-- Article Comments Tab -->
                <button @click="setActiveTab('article')"
                    :class="{
                        'bg-violet-100 text-violet-700 font-semibold border-violet-500': activeTab === 'article',
                        'bg-gray-100 text-gray-700 hover:bg-gray-200 border-gray-300': activeTab !== 'article'
                    }"
                    class="flex items-center space-x-1 py-1 px-3 text-sm rounded-lg border-2 transition-colors duration-150">
                    <span>Article comments</span>
                    <span class="font-bold ml-1" x-text="metrics.article">5</span>
                </button>
            </div>

            <!-- Comments List -->
            <div class="space-y-4 pt-1">
                <template x-for="comment in filteredComments" :key="comment.id">
                    <div class="flex items-start space-x-3 hover:bg-gray-50 p-2 -mx-2 rounded-lg transition-colors cursor-pointer">
                        <!-- Avatar -->
                        <div class="avatar-placeholder bg-cover bg-center"
                            :style="comment.avatarUrl ? `background-image: url('${comment.avatarUrl}');` : ''"
                            :class="comment.avatarUrl ? 'bg-transparent' : 'text-white'"
                            x-html="comment.avatarUrl ? '' : getInitials(comment.user)">
                        </div>

                        <!-- Content -->
                        <div>
                            <p class="text-gray-800 text-sm">
                                <span class="font-semibold" x-text="comment.user"></span>
                                <span x-text="comment.actionText"></span>
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                <span x-text="comment.timeAgo"></span>
                                <span class="mx-1">•</span>
                                <a :href="comment.articleLink" class="hover:underline" x-text="comment.articleName"></a>
                            </p>
                        </div>
                    </div>
                </template>
                <div x-show="filteredComments.length === 0" class="text-center py-6 text-gray-500">
                    No new activity in this category.
                </div>
            </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('commentsData', () => ({
                activeTab: 'all',
                metrics: {
                    all: 5,
                    mentioned: 3,
                    article: 2
                },

                // Corrected image paths (Laravel public path)
                allComments: [
                    { id: 1, user: 'John Smith', actionText: 'commented on an article', timeAgo: '5 minutes ago', articleName: 'Article name', articleLink: '#', tags: ['all', 'article'], avatarUrl: '/assets/img/avatars/avatar1.jpeg' },
                    { id: 2, user: 'Mark James', actionText: 'mentioned you', timeAgo: '2 hours ago', articleName: 'Article name', articleLink: '#', tags: ['all', 'mentioned'], avatarUrl: '/assets/img/avatars/avatar2.jpeg' },
                    { id: 3, user: 'John Doe', actionText: 'commented on an article', timeAgo: '5 minutes ago', articleName: 'Article name', articleLink: '#', tags: ['all', 'article'], avatarUrl: '/assets/img/avatars/avatar3.jpeg' },
                    { id: 4, user: 'Jane Doe', actionText: 'mentioned you', timeAgo: '4 hours ago', articleName: 'Project Proposal 2025', articleLink: '#', tags: ['all', 'mentioned'], avatarUrl: '/assets/img/avatars/avatar4.jpeg' },
                    { id: 5, user: 'John Smith', actionText: 'mentioned you', timeAgo: '4 hours ago', articleName: 'Article name', articleLink: '#', tags: ['all', 'mentioned'], avatarUrl: '/assets/img/avatars/avatar5.jpeg' }
                ],

                // Filter Logic
                get filteredComments() {
                    if (this.activeTab === 'all') {
                        return this.allComments.slice(0, 10);
                    }
                    return this.allComments.filter(comment => comment.tags.includes(this.activeTab));
                },

                setActiveTab(tab) {
                    this.activeTab = tab;
                },

                getInitials(name) {
                    return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
                }
            }));
        });
    </script>
    <style>
        /* Custom shadows for a softer look */
        .shadow-soft {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        /* Style for the avatars */
        .avatar-placeholder {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background-color: #d1d5db; /* Default fallback color for initials */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #4b5563; /* Darker gray text */
            font-size: 0.875rem; /* text-sm */
            flex-shrink: 0;
            overflow: hidden; /* Ensure image fits */
        }
    </style>
</div>

