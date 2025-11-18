<div class="bg-white shadow rounded-xl border border-gray-200 p-4">

    <div class="space-y-6">
        {{-- Template Download --}}
        <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center space-x-3 mb-4">
                <i class="fa fa-download text-green-600 text-xl"></i>
                <h2 class="text-lg font-semibold text-gray-800">Chatbot Template Download</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">Download the example chatbot upload template file.</p>
             <a href="{{ asset('wikiUploadApi/chatbot_upload_template.xlsx') }}"
                class="inline-flex items-center px-4 py-2 btn btn-gradient btn-info"
                download>
                    <i class="fa fa-folder fa-fw mr-2"></i>
                    <span>Chatbot SITI Template</span>
            </a>
        </div>

        {{-- Upload & Update Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Chatbot Upload --}}
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200 flex flex-col">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fa fa-upload text-blue-600 text-xl"></i>
                        <h2 class="btn btn-gradient btn-accent">Chatbot Upload</h2>
                    </div>
                </div>

                <form wire:submit.prevent="uploadChatbotFile" class="space-y-4 flex-1" x-data="{ fileChosen: false }">
                    <h3 class="text-md font-medium mb-3 text-gray-700">Upload New Chatbot File</h3>

                    <input type="file" wire:model="file"
                           accept=".xlsx,.xls"
                           x-ref="uploadFile"
                           @change="fileChosen = $refs.uploadFile.files.length > 0"
                           class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm mb-2">

                    @error('file')
                        <span class="text-sm text-red-600 mb-2">{{ $message }}</span>
                    @enderror

                    <div wire:loading wire:target="file" class="text-blue-600 text-sm mb-2">Uploading file...</div>

                    <button type="submit"
                            :disabled="!fileChosen"
                            class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                        <i class="fa fa-upload mr-2"></i> Upload
                    </button>
                </form>
            </div>

            {{-- Bulk Update (Optional Include) --}}
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200 flex flex-col">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fa fa-edit text-yellow-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Chatbot Bulk Update</h2>
                </div>
                <div class="flex-1">
                    @include('livewire.users.partials.chatbot-bulk-update')
                </div>
            </div>
        </div>
    </div>

    {{-- Chatbot Upload Records - Upgraded Table View --}}
    <div class="bg-white shadow-xl rounded-xl p-6 transition duration-300 hover:shadow-2xl mt-6 border border-gray-100">
        <div class="flex items-center space-x-3 mb-6 border-b pb-4">
            <i class="fa fa-history text-indigo-600 text-2xl"></i>
            <h2 class="text-xl font-bold text-gray-800">Chatbot Upload Files Records</h2>
        </div>

        <div class="overflow-x-auto max-h-[30rem] lg:max-h-[40rem] overflow-y-auto custom-scrollbar">
            {{-- Custom Scrollbar Style (requires a small CSS addition, see note below) --}}

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Space Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            File Link
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Uploaded By
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Created On
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($wikiUpload as $wiki)
                        <tr class="hover:bg-indigo-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $wiki->space_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($wiki->filename)
                                    <a href="{{ asset('storage/chatbot_uploads/' . $wiki->filename) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 font-semibold truncate block max-w-xs"
                                    title="{{ $wiki->filename }}">
                                        {{ $wiki->filename }}
                                    </a>
                                @else
                                    <span class="text-gray-500">No File</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                {{ $wiki->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                {{ \Carbon\Carbon::parse($wiki->created_at)->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-base">
                                <i class="fa fa-info-circle mr-2"></i>Nothing found. Time to upload some data!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
