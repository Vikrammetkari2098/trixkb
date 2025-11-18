<div class="bg-white shadow rounded-xl border border-gray-200 p-4">
    <!-- Panel Heading -->
    <div class="flex items-center mb-4">
        <i class="fa fa-history fa-fw mr-2 text-gray-500"></i>
        <h2 class="text-lg font-semibold text-gray-800">Directory Update</h2>
    </div>

    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Upload Form -->
        <div class="lg:w-1/3">
            <form wire:submit.prevent="uploadFile" x-data="{ fileChosen: false }">

                <h3 class="text-md font-medium mb-2">Upload new directory file</h3>

                <!-- File Input -->
                <label class="block mb-2 cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded">
                    Select File
                    <input type="file" wire:model="file" accept=".xlsx,.xls" class="hidden"
                           x-ref="uploadFile"
                           @change="fileChosen = $refs.uploadFile.files.length > 0">
                </label>

                <p class="text-sm text-gray-500 mb-2">Maximum file size: 10 MB</p>

                <!-- Validation Errors -->
                @error('file')
                    <div class="text-red-600 mb-2">{{ $message }}</div>
                @enderror

                <!-- Upload Button -->
                <button type="submit"
                        :disabled="!fileChosen"
                        class="btn btn-gradient btn-accent">
                     <i class="fa fa-upload fa-fw mr-2"></i>
                    <span>Upload</span>
                </button>
            </form>
        </div>
    </div>
</div>
