<div class="bg-white shadow rounded-xl border border-gray-200 p-4">

   <div class="space-y-6">

        {{-- Template Download (Full Width) --}}
        <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center space-x-3 mb-4">
                <i class="fa fa-download text-green-600 text-xl"></i>
                <h2 class="text-lg font-semibold text-gray-800">Template Download</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">Download the example template file.</p>
            <a href="{{ url('/download-template') }}"
                class="inline-flex items-center px-4 py-2 btn btn-gradient btn-info">
                <i class="fa fa-folder mr-2"></i> Directory Template
            </a>
        </div>

        {{-- Second Row: Upload Form & Bulk Update --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Directory Upload --}}
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200 flex flex-col">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fa fa-upload text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="btn btn-gradient btn-accent">Directory Upload</h2>
                </div>

                <form wire:submit.prevent="uploadFile" class="space-y-4 flex-1" x-data="{ fileChosen: false }">
                    <h3 class="text-md font-medium mb-3 text-gray-700">Upload New Directory File</h3>

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

            {{-- Wiki Bulk Update --}}
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition duration-200 flex flex-col">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fa fa-edit text-yellow-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Directory Update</h2>
                </div>
                <div class="flex-1">
                    @include('livewire.users.partials.wiki-bulk-update')
                </div>
            </div>

        </div>
    </div>

        {{-- 📁 Directory Upload Records Table --}}
    <div class="bg-white shadow-xl rounded-xl p-6 transition duration-300 ease-in-out hover:shadow-2xl border border-gray-100">

        {{-- ✨ Header Section --}}
        <div class="flex items-center space-x-3 mb-6 border-b pb-4 border-gray-200">
            <i class="fa fa-history text-indigo-600 text-2xl"></i>
            <h2 class="text-xl font-bold text-gray-800 tracking-wide">Directory Upload Files Records</h2>
        </div>

        {{-- 📜 Records Container (Table) --}}
        <div class="overflow-x-auto max-h-[30rem] lg:max-h-[36rem] overflow-y-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Space & File
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Details
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status Counts
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($wikiUpload as $wiki)
                        <tr class="hover:bg-indigo-50 transition duration-150">
                            {{-- 📝 Space & File Name --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $wiki->space_name }}</div>
                                <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">
                                    @if ($wiki->filename)
                                        <a href="{{ asset('wikiUploadApi/uploads/dire_excel_data/' . $wiki->filename) }}"
                                        target="_blank"
                                        title="Download File: {{ $wiki->filename }}"
                                        class="text-blue-600 hover:text-blue-800 hover:underline transition duration-150">
                                            {{ $wiki->filename }}
                                        </a>
                                    @else
                                        <span class="italic">No file attached</span>
                                    @endif
                                </div>
                            </td>

                            {{-- 📅 Details (Created On, By) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                                <div class="flex flex-col space-y-1">
                                    <span class="text-xs font-medium text-gray-700">By: {{ $wiki->user_name }}</span>
                                    <span class="text-xs">On: {{ $wiki->created_at }}</span>
                                </div>
                            </td>

                            {{-- 📊 Status Counts (Pills) --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2 text-xs">
                                    @if($wiki->insert_success_count)
                                        <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">
                                            + Insert ({{ $wiki->insert_success_count }})
                                        </span>
                                    @endif
                                    @if($wiki->update_success_count)
                                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                            * Update ({{ $wiki->update_success_count }})
                                        </span>
                                    @endif
                                    @if($wiki->exist_failed_count)
                                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                            ! Exist Failed ({{ $wiki->exist_failed_count }})
                                        </span>
                                    @endif
                                    @if($wiki->invalid_count)
                                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">
                                            🚫 Invalid ({{ $wiki->invalid_count }})
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- 🔗 Actions (Download Log) --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ asset('wikiUploadApi/uploads/' . $wiki->log_filename) }}"
                                target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 transition duration-150 flex items-center gap-1.5 text-xs font-semibold p-2 rounded-md hover:bg-indigo-100"
                                title="Download Log File">
                                <i class="fa fa-file-alt"></i> Download Log
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic text-lg">
                                <i class="fa fa-inbox text-2xl mb-2"></i>
                                <p>No directory upload records found. Time to get to work!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
