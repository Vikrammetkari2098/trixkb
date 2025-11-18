<div class="p-6 space-y-6">
             {{-- Top Navigation --}}
    <div class="rounded-xl px-4 py-2 flex justify-between items-center">
        <ul class="flex space-x-2">
            @if($user->hasPermission('add_page'))
                <li>
                    <a href="{{ route('chatbot.edit', [$team->slug, $chatbot->slug]) }}"
                    class="px-3 py-1 text-white bg-indigo-700 rounded hover:bg-indigo-800 flex items-center space-x-1">
                        <i class="fa fa-pencil"></i>
                        <span>Edit</span>
                    </a>
                </li>
            @endif

            @if($user->hasPermission('delete_page'))
                <li>
                    <button
                        x-data
                        x-on:click="if(confirm('Are you sure?')) $wire.deleteChatbot('{{ $chatbot->id }}')"
                        class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700 flex items-center space-x-1">
                        <i class="fa fa-trash"></i>
                        <span>Delete</span>
                    </button>
                </li>
            @endif
        </ul>
    </div>
    {{-- Chatbot Info Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="bg-gray-400 text-white px-4 py-2 rounded-t-xl font-semibold">Chatbot Info</div>
        <div class="p-4 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <span class="text-gray-600 font-medium">Ministry</span>
                    <p class="text-gray-900">{{ $chatbot->organisation->ministry->name ?? 'N/A' }}</p>
                </div>

                <div>
                    <span class="text-gray-600 font-medium">Department</span>
                    <p class="text-gray-900">{{ $chatbot->organisation->department->name ?? 'N/A' }}</p>
                </div>

                <div>
                    <span class="text-gray-600 font-medium">Main Category</span>
                    <p class="text-gray-900">{{ $chatbot->main_category ?? 'N/A' }}</p>
                </div>

                <div>
                    <span class="text-gray-600 font-medium">Region</span>
                    <p class="text-gray-900">{{ $this->getRegionName($chatbot->region) ?? 'N/A' }}</p>
                </div>

                <div>
                    <span class="text-gray-600 font-medium">Language</span>
                    <p class="text-gray-900">{{ $this->getLanguageName($chatbot->language_id) ?? 'N/A' }}</p>
                </div>

                <div>
                    <span class="text-gray-600 font-medium">Service</span>
                    <p class="text-gray-900">{{ $chatbot->service ?? 'N/A' }}</p>
                </div>

                <div>
                    <span class="text-gray-600 font-medium">Sub Service</span>
                    <p class="text-gray-900">{{ $chatbot->sub_service ?: 'N/A' }}</p>
                </div>

            </div>
        </div>
    </div>

        {{-- Audit Trail Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="bg-gray-400 text-white px-4 py-2 rounded-t-xl font-semibold">Audit Trail</div>
        <div class="p-4">
            @if($chatbot)
                <livewire:users.chatbot-audit-trail :chatbot="$chatbot" />
            @else
                <p class="text-gray-500">Select a chatbot to view audit trail.</p>
            @endif
        </div>
    </div>
</div>
