<div x-data="chatWidget()"
     x-init="init()"
     x-cloak
     @mousemove.window="drag($event)"
     @mouseup.window="stopDrag($event)"
     @resize.window="keepInBounds()"
     @scroll.window="keepInBounds()">

    <button
        @mousedown="startDrag($event)"
        @click="clickButton()"
        :style="{ position: 'fixed', left: posX + 'px', top: posY + 'px' }"
        class="btn btn-gradient btn-primary px-5 py-10 rounded-full shadow-lg z-50 transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-3 cursor-grab"
    >
        <img src="/image/kbai.png" alt="AI" class="w-14 h-14 object-contain rounded-full border-2 border-white" />
        <span class="font-semibold text-lg">KB ChatBot</span>
    </button>
    <div x-show="show" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black/50 z-[999] flex items-center justify-center p-4 sm:p-0">

        <div class="w-full max-w-sm sm:max-w-md rounded-xl shadow-2xl flex flex-col overflow-hidden text-gray-800
                    bg-white border border-gray-200 transition-all duration-300"
             @click.outside="show = false">

            <div class="p-6 flex flex-col items-center justify-center text-center
                        bg-white border-b border-gray-200">
                <div class="mb-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </div>
                </div>
                <h3 class="font-semibold text-lg text-gray-500">KnowLedge</h3>
                <h2 class="text-2xl font-bold mt-1 tracking-wide text-gray-900">KB Assistant</h2>
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-4 space-y-4 h-[360px] overflow-y-auto bg-gray-50 custom-scrollbar">
                <div class="flex justify-start">
                    <div class="px-4 py-3 rounded-2xl max-w-[75%] shadow-md bg-gray-200 text-gray-800">
                        <span x-text="greetingText"></span>
                    </div>
                </div>

                @foreach($messages as $msg)
                <div class="flex {{ $msg['sender'] === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="px-4 py-3 rounded-2xl max-w-[75%] shadow-md
                        {{ $msg['sender'] === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                        {{ $msg['text'] }}
                    </div>
                </div>
                @endforeach
            </div>

            <form wire:submit.prevent="sendMessage" class="p-3 border-t border-gray-200 bg-white flex gap-2 items-center">
                <input type="text" wire:model.defer="input"
                       placeholder="Ask me anything..."
                       class="flex-grow border border-gray-300 bg-white text-gray-800 rounded-xl px-4 py-2.5
                              focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 text-sm transition duration-150">
                <button class="bg-blue-600 text-white px-3 py-2.5 rounded-xl hover:bg-blue-700 transition duration-150 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <style>
    /* For WebKit browsers (Chrome, Safari) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f9fafb; /* Gray-50 */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #d1d5db; /* Gray-300 */
        border-radius: 20px;
        border: 2px solid #f9fafb;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #9ca3af; /* Gray-400 */
    }
    </style>
    <script>
        function chatWidget() {
            return {
                show: false,
                greetingText: '',
                fullGreeting: 'Hi, what can I help you with?',
                typingSpeed: 50,
                posX: window.innerWidth - 150,
                posY: window.innerHeight - 100,
                dragging: false,
                offsetX: 0,
                offsetY: 0,
                moved: false,

                init() {
                    // Keep button visible when zooming or resizing
                    window.addEventListener('resize', this.keepInBounds.bind(this));
                },

                typeGreeting() {
                    let i = 0;
                    const fullText = this.fullGreeting;
                    this.greetingText = '';
                    const typingInterval = setInterval(() => {
                        if (i < fullText.length) {
                            this.greetingText += fullText.charAt(i);
                            i++;
                        } else {
                            clearInterval(typingInterval);
                        }
                    }, this.typingSpeed);
                },

                startDrag(event) {
                    this.dragging = true;
                    this.moved = false;
                    this.offsetX = event.clientX - this.posX;
                    this.offsetY = event.clientY - this.posY;
                },

                stopDrag() {
                    this.dragging = false;
                    this.keepInBounds();
                },

                drag(event) {
                    if (this.dragging) {
                        const dx = event.clientX - this.offsetX - this.posX;
                        const dy = event.clientY - this.offsetY - this.posY;
                        if (Math.abs(dx) > 3 || Math.abs(dy) > 3) this.moved = true;
                        this.posX = event.clientX - this.offsetX;
                        this.posY = event.clientY - this.offsetY;
                    }
                },

                clickButton() {
                    if (!this.moved) {
                        this.show = true;
                        this.$nextTick(() => this.typeGreeting());
                    }
                },

                keepInBounds() {
                    const padding = 10; // keep some space from edges
                    const maxX = window.innerWidth - 120;
                    const maxY = window.innerHeight - 80;
                    if (this.posX > maxX) this.posX = maxX;
                    if (this.posY > maxY) this.posY = maxY;
                    if (this.posX < padding) this.posX = padding;
                    if (this.posY < padding) this.posY = padding;
                }
            };
        }
    </script>
</div>
