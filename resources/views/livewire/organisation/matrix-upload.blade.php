<div
    x-data="{ fileName: @entangle('uploadScriptFile').live ? @entangle('uploadScriptFile').live.name : null }"
    x-on:toast.window="window.toast($event.detail.message)"
    class="tab-content p-6"
>
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Matrix Upload 📝</h2>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <i class="fa fa-history fa-fw text-blue-500 mr-2"></i>
                <h3 class="text-xl font-semibold text-gray-700">File Selection</h3>
            </div>

            <form wire:submit.prevent="upload" enctype="multipart/form-data">

                <div class="form-group mb-6">
                    <label
                        for="file-upload-input"
                        class="block w-full cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-10 text-center transition duration-300 ease-in-out hover:border-blue-500 hover:bg-blue-50"
                        :class="{ 'border-blue-500 bg-blue-50': fileName }"
                    >
                        <input
                            id="file-upload-input"
                            type="file"
                            wire:model="uploadScriptFile"
                            class="hidden"
                            accept=".csv, .xlsx, .xls" {{-- Add accepted file types here --}}
                        >

                        <div class="flex flex-col items-center justify-center">
                            <i class="fa fa-cloud-upload fa-3x text-gray-400 mb-3"></i>

                            <p x-cloak x-show="fileName" class="text-lg font-medium text-blue-600 mb-1">
                                File Selected: <span x-text="fileName" class="font-bold"></span>
                            </p>

                            <p x-show="!fileName" class="text-lg font-medium text-gray-600 mb-1">
                                Click to browse or drag and drop your file here
                            </p>

                            <p class="text-sm text-gray-500 mt-2">Maximum file size allowed is **500 KB**.</p>
                        </div>
                    </label>

                    @error('uploadScriptFile')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="uploadScriptFile, upload"
                        class="btn bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <i class="fa fa-upload fa-fw mr-1"></i>
                        <span wire:loading.remove wire:target="upload">Upload Matrix</span>
                        <span wire:loading wire:target="upload">Processing...</span>
                    </button>
                </div>
                </form>

            <div wire:loading wire:target="uploadScriptFile" class="mt-4 text-center">
                <p class="text-sm text-blue-500">
                    <i class="fa fa-spinner fa-spin mr-1"></i>
                    Preparing file for upload...
                </p>
            </div>

        </div>
    </div>

    <script>
        window.toast = function(message) {
            const toast = document.createElement('div');
            toast.textContent = message;
            // Using Tailwind-like classes: fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg animate-fade-in
            toast.className =
                'fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-xl animate-fade-in z-50'; // Added z-50
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 3000);
        };
    </script>

    <style>
        /* Add basic styles if Tailwind CSS is not fully included,
           or keep the animation for the toast */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.3s ease-out; }

        /* Basic utility styles if Tailwind is not present */
        .bg-white { background-color: #fff; }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
        .rounded-lg { border-radius: 0.5rem; }
        .p-6 { padding: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .font-bold { font-weight: 700; }
        .mb-6 { margin-bottom: 1.5rem; }
        .text-gray-800 { color: #1f2937; }
        .text-blue-500 { color: #3b82f6; }
        .bg-blue-50 { background-color: #eff6ff; }
        .border-gray-300 { border-color: #d1d5db; }
        .border-dashed { border-style: dashed; }
        .text-center { text-align: center; }
        /* Many more utility classes are assumed from the Tailwind-like class names used */
    </style>
</div>
