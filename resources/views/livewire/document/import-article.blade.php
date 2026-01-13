<div x-data="{ openBulkModal: @entangle('modalImport').live }">
    
    {{-- Modal Wrapper --}}
    <div x-show="openBulkModal" 
         x-cloak
         style="display: none;" 
         class="fixed inset-0 z-40 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-all px-4">
        
        {{-- Modal Content --}}
        <div x-show="openBulkModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-3xl bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
            
            {{-- Close Button --}}
            <button @click="openBulkModal = false" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Header --}}
            <div class="p-8 pb-0 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Import Articles</h2>
                <p class="mt-2 text-gray-500 text-sm">Import thousands of articles in one click using an Excel file.</p>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    {{-- Step 1: Download --}}
                    <div class="flex flex-col items-center p-6 bg-purple-50 rounded-xl border border-purple-100 text-center">
                        <div class="mb-4 p-3 bg-purple-600 text-white rounded-lg shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </div>
                        <span class="block text-sm font-bold text-purple-900 mb-1">Step 1: Get Sample</span>
                        <p class="text-xs text-purple-700 mb-4 italic">Download the file to understand the format.</p>
                        
                        <button wire:click="downloadTemplate" class="w-full bg-white text-purple-700 border border-purple-300 py-2 rounded-lg text-sm font-semibold hover:bg-purple-100 transition">
                            Download Template
                        </button>
                    </div>

                    {{-- Step 2: Upload --}}
                    <div class="flex flex-col items-center p-6 bg-blue-50 rounded-xl border border-blue-100 text-center relative">
                        <div class="mb-4 p-3 bg-blue-600 text-white rounded-lg shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <span class="block text-sm font-bold text-blue-900 mb-1">Step 2: Upload File</span>
                        <p class="text-xs text-blue-700 mb-4 italic">
                            @if($file) 
                                <span class="text-green-600 font-bold">File Selected!</span>
                            @else 
                                Select your prepared Excel file.
                            @endif
                        </p>
                        
                        {{-- Loading Indicator during upload --}}
                        <div wire:loading wire:target="file" class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl z-10">
                            <span class="text-blue-600 font-bold text-sm animate-pulse">Uploading...</span>
                        </div>

                        <label class="w-full bg-white text-blue-700 border border-blue-300 py-2 rounded-lg text-sm font-semibold cursor-pointer hover:bg-blue-100 transition block">
                            Select .xlsx File
                            {{-- ✅ Wire Model --}}
                            <input type="file" wire:model="file" class="hidden" accept=".xlsx, .xls, .csv">
                        </label>

                        @error('file') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                </div>

                {{-- Pro Tip --}}
                <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-xs text-gray-600 leading-relaxed">
                            <strong>Professional Tip:</strong> Columns <span class="text-black font-bold underline">title</span>, <span class="text-black font-bold underline">content</span>, and <span class="text-black font-bold underline">status</span> are required. Max 1,000 articles per file.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="p-6 bg-gray-50 flex items-center justify-end space-x-3 border-t">
                <button @click="openBulkModal = false" class="btn">
                    Discard
                </button>
                
                <button wire:click="import" 
                        wire:loading.attr="disabled"
                        class="btn btn-success">
                    
                    <span wire:loading wire:target="import" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
                    <span wire:loading.remove wire:target="import">Start Import</span>
                    <span wire:loading wire:target="import">Importing...</span>
                </button>
            </div>
        </div>
    </div>
</div>