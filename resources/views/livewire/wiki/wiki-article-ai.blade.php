<div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 px-4 sm:px-6"
    x-data="{ show: true }"
    x-show="show"
    x-transition.opacity.duration.300ms
>
    <div
        class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-8 relative transform transition-all duration-300 scale-95 sm:scale-100"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <!-- Close Button (Always visible) -->
        <button
            @click="show = false"
            wire:click="closeModal"
            class="absolute top-4 right-4 z-50 text-black hover:text-red-600 transition text-2xl"
        >
            ✖
        </button>

        <!-- Modal Header -->
        <h2 class="text-xl sm:text-2xl font-semibold text-[#09325d] mb-5 text-center flex items-center justify-center space-x-2">
            <i class="fi fi-rr-robot text-[#09325d]"></i>
            <span>AI Assistant for: {{ $article->name }}</span>
        </h2>

        <!-- Search Input -->
        <div class="mb-4 flex space-x-2">
            <input
                type="text"
                placeholder="Ask something related to the article..."
                wire:model.defer="userInput"
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#09325d]"
            />
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-start mb-6 space-x-2">
            <button
                wire:click="askAi"
                wire:loading.attr="disabled"
                class="bg-[#09325d] text-white px-4 py-2 rounded-lg shadow flex items-center space-x-2 hover:bg-[#0b4177] transition duration-300"
            >
                <x-icon name="sparkles" class="text-yellow-500 w-4 h-4" />
                <span wire:loading.remove>Generate AI Article</span>
                <span wire:loading>⏳ Generating...</span>
            </button>


            <!-- Show PDF button only if response exists -->
            @if($aiResponse)
                <button
                    wire:click="downloadPdf"
                    wire:loading.attr="disabled"
                    class="bg-green-600 text-white font-medium px-5 py-2 sm:px-6 sm:py-3 rounded-lg shadow hover:bg-green-700 transition duration-300 flex items-center space-x-2"
                >
                    <i class="fi fi-rr-document"></i>
                    <span wire:loading.remove>Save as PDF</span>
                    <span wire:loading>⏳ Preparing...</span>
                </button>
            @endif
        </div>
        <!-- Response Section -->
        <div id="ai-response" class="mt-2 text-gray-700 leading-relaxed max-h-96 overflow-y-auto">
            @if($aiResponse)
                <div class="space-y-2">
                    {!! nl2br(e($aiResponse)) !!}
                </div>
            @elseif($loading)
                <p class="italic text-gray-500 text-center">Thinking...</p>
            @else
                <p class="text-gray-400 text-sm text-center">
                    Click the button above or ask a question to generate AI-powered insights.
                </p>
            @endif
        </div>
    </div>
</div>
