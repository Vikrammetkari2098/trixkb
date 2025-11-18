<div class="bg-white shadow rounded-xl border border-gray-200 p-4" x-data="{ fileChosen: false }">

    <!-- Panel Heading -->
    <div class="flex items-center mb-4">
        <i class="fa fa-history fa-fw mr-2 text-gray-500"></i>
        <h2 class="text-lg font-semibold text-gray-800">Update</h2>
    </div>

    <div class="flex flex-col lg:flex-row gap-4">

        <!-- Upload Form -->
        <div class="lg:w-1/3">
            <form wire:submit.prevent="uploadChatbotFile" class="space-y-4">
                @csrf
                <input type="hidden" wire:model="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" wire:model="team_id" value="{{ $team->id }}">

                <h3 class="text-md font-medium mb-2">Upload new chatbot file</h3>

                <label class="block mb-2 cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded">
                    Select File
                    <input type="file" wire:model="file"
                           accept=".xlsx,.xls"
                           class="hidden"
                           x-ref="uploadFile"
                           @change="fileChosen = $refs.uploadFile.files.length > 0">
                </label>

                <p class="text-sm text-gray-500 mb-2">The maximum file size allowed is 500 kb</p>

                @error('file')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror

                <button type="submit"
                        :disabled="!fileChosen"
                        class="btn btn-gradient btn-accent">
                    <i class="fa fa-upload fa-fw mr-2"></i>
                    <span>Upload</span>
                </button>

                <div wire:loading wire:target="file" class="text-blue-600 text-sm mt-2">Uploading file...</div>
            </form>
        </div>
    </div>
</div>
