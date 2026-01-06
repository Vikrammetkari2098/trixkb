<div
    class="bg-white min-h-screen text-gray-800"
    x-data="{
        isSaving: false,

        get activeTitle() { return @this.title },
        set activeTitle(val) { @this.title = val },

        init() {
            window.addEventListener('load-article-title', (e) => {
                @this.set('title', e.detail.title);
                @this.set('content', e.detail.content);
            });
        },

        
        async saveContent() {
            if (!window.editorInstance || this.isSaving) return;

            this.isSaving = true;

            try {
                const outputData = await window.editorInstance.save();
                await $wire.save(outputData); 

                window.dispatchEvent(new CustomEvent('article-updated-in-list', {
                    detail: { id: @this.articleId, title: @this.title }
                }));
            } catch (error) {
                console.error(error);
            } finally {
                setTimeout(() => { this.isSaving = false; }, 800);
            }
        },

      
        async updateStatus(status) {
            if (!window.editorInstance || this.isSaving) return;

            this.isSaving = true;

            try {
                const outputData = await window.editorInstance.save();
            
                await $wire.changeStatus(status, outputData); 

            } catch (error) {
                console.error(error);
            } finally {
                setTimeout(() => { this.isSaving = false; }, 800);
            }
        }
    }"
>
    <div class="flex items-center justify-between px-6 py-3 border-b sticky top-0 bg-white z-10">
        <div class="flex items-center space-x-4 text-gray-900">
            <button class="flex items-center text-gray-600 hover:text-black transition mr-4" @click="tableArticleId = null">
                <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back
            </button>
            <svg class="h-5 w-5 cursor-pointer" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.71 3.45001L15.17 7.94C15.2272 8.04557 15.307 8.1371 15.4039 8.20801C15.5007 8.27892 15.6121 8.3274 15.73 8.34998L20.73 9.29999C20.8726 9.327 21.0053 9.39183 21.1142 9.48767C21.2232 9.58352 21.3044 9.70688 21.3494 9.84485C21.3943 9.98282 21.4014 10.1303 21.3698 10.272C21.3383 10.4136 21.2693 10.5442 21.17 10.65L17.66 14.38C17.5784 14.4676 17.5172 14.5723 17.4809 14.6864C17.4446 14.8005 17.4341 14.9213 17.45 15.04L18.09 20.12C18.1098 20.2633 18.0903 20.4094 18.0337 20.5425C17.9771 20.6757 17.8854 20.791 17.7684 20.8762C17.6514 20.9613 17.5135 21.0132 17.3694 21.0262C17.2253 21.0392 17.0804 21.0129 16.95 20.95L12.32 18.77C12.2114 18.7155 12.0915 18.6871 11.97 18.6871C11.8485 18.6871 11.7286 18.7155 11.62 18.77L6.99 20.95C6.85904 21.0119 6.71392 21.0375 6.56971 21.0242C6.4255 21.0109 6.28751 20.9591 6.17008 20.8744C6.05265 20.7896 5.96006 20.6749 5.90201 20.5422C5.84396 20.4096 5.82256 20.2638 5.84 20.12L6.49 15.04C6.50596 14.9213 6.49542 14.8005 6.45911 14.6864C6.4228 14.5723 6.36162 14.4676 6.28 14.38L2.76999 10.65C2.67072 10.5442 2.60172 10.4136 2.57017 10.272C2.53861 10.1303 2.54568 9.98282 2.59064 9.84485C2.63561 9.70688 2.71683 9.58352 2.82578 9.48767C2.93473 9.39183 3.06742 9.327 3.21 9.29999L8.21 8.34998C8.32789 8.3274 8.43929 8.27892 8.53614 8.20801C8.63299 8.1371 8.71286 8.04557 8.76999 7.94L11.28 3.45001C11.349 3.32033 11.4521 3.21187 11.578 3.13623C11.704 3.0606 11.8481 3.02063 11.995 3.02063C12.1419 3.02063 12.2861 3.0606 12.412 3.13623C12.538 3.21187 12.641 3.32033 12.71 3.45001Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <svg class="h-5 w-5 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8H12.01M12 11V16M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            @if($articleId)
                <button 
                    type="button"
                    x-on:click="async () => {
                        if(window.editorInstance) {
                            const data = await window.editorInstance.save();
                            $wire.showPreview(data); 
                        }
                    }"
                    class="text-gray-500 hover:text-gray-700 rounded-full transition flex items-center gap-2"
                >
                    <span wire:loading.remove wire:target="showPreview">Preview</span>
                    <span wire:loading wire:target="showPreview" class="text-xs">Saving...</span>
                </button>
            @endif
        </div>

        <div class="flex items-center space-x-4">
            
            <div x-data="{ open: false }" class="relative inline-flex shadow-sm rounded-md">
                
                <button
                    @click="saveContent()"
                    :disabled="isSaving"
                    class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-transparent bg-purple-600 text-sm font-medium text-white hover:bg-purple-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 disabled:opacity-50 transition"
                >
                    <span x-show="isSaving" class="mr-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </span>
                    
                    <span x-text="isSaving ? 'Saving...' : '{{ $status === 'published' ? 'Update Live' : 'Save Draft' }}'"></span>
                </button>

                <button 
                    @click="open = !open" 
                    :disabled="isSaving"
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-l-0 border-transparent bg-purple-700 text-sm font-medium text-white hover:bg-purple-800 focus:z-10 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 disabled:opacity-50"
                >
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>

                <div 
                    x-show="open" 
                    @click.outside="open = false" 
                    x-transition:enter="transition ease-out duration-100" 
                    x-transition:enter-start="transform opacity-0 scale-95" 
                    x-transition:enter-end="transform opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-75" 
                    x-transition:leave-start="transform opacity-100 scale-100" 
                    x-transition:leave-end="transform opacity-0 scale-95" 
                    class="origin-top-right absolute right-0 top-10 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                    style="display: none;"
                >
                    <div class="py-1">
                        @if($status !== 'published')
                            <button @click="updateStatus('published'); open = false" class="group flex items-center px-4 py-3 text-sm text-green-700 hover:bg-green-50 w-full text-left font-semibold">
                                <svg class="mr-3 h-5 w-5 text-green-500 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Publish Now
                            </button>
                            <div class="border-t border-gray-100 my-1"></div>
                        @endif

                        <button @click="updateStatus('draft'); open = false" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            <span class="w-2 h-2 rounded-full bg-gray-400 mr-3"></span> Save as Draft
                        </button>
                        
                        <button @click="updateStatus('in_review'); open = false" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            <span class="w-2 h-2 rounded-full bg-blue-400 mr-3"></span> Move to Review
                        </button>

                        @if($status === 'published')
                            <div class="border-t border-gray-100 my-1"></div>
                            <button @click="updateStatus('draft'); open = false" class="group flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                <svg class="mr-3 h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Unpublish (Revert to Draft)
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="pt-10 pb-16 px-4 sm:px-8 w-full editor-custom-icons">
        <div class="flex flex-col lg:flex-row items-start gap-10">
            <div class="flex-1 w-full lg:max-w-4xl">
                <div class="mb-6">
                    <input type="text"
                        x-model="activeTitle"
                        @input.debounce.500ms="$wire.set('title', activeTitle)"
                        class="w-full text-4xl font-semibold bg-transparent border-none outline-none focus:ring-0 p-0 placeholder-gray-300"
                        placeholder="Add title">
                </div>

                <div x-data="{
                        initEditor(initialData) {
                            let editorData = initialData;
                            
                            if (typeof editorData === 'string') {
                                try {
                                    editorData = JSON.parse(editorData);
                                } catch(e) {
                                    console.error('Error parsing content', e);
                                    editorData = { blocks: [] };
                                }
                            }
                            
                            if (!editorData || typeof editorData !== 'object' || !editorData.blocks) {
                                editorData = { blocks: [] };
                            }

                            if (window.editorInstance && typeof window.editorInstance.destroy === 'function') {
                                window.editorInstance.destroy();
                            }
                            window.editorInstance = new window.EditorJS({
                                holder: this.$refs.editor,
                                placeholder: 'Write here...',
                                inlineToolbar: true,
                                data: editorData,
                                tools: {
                                    header: { class: window.Header, inlineToolbar: true, config: { levels: [1, 2, 3, 4], defaultLevel: 2 } },
                                    paragraph: { class: window.Paragraph, inlineToolbar: true },
                                    list: { class: window.NestedList, inlineToolbar: true },
                                    checklist: { class: window.Checklist, inlineToolbar: true },
                                    quote: { class: window.Quote, inlineToolbar: true },
                                    table: { class: window.Table, inlineToolbar: true },
                                    warning: { class: window.Warning, inlineToolbar: true },
                                    marker: { class: window.Marker, inlineToolbar: true },
                                    underline: window.Underline,
                                    toggle: window.ToggleBlock,
                                    alert: window.Alert,
                                    raw: window.RawTool,
                                    embed: {
                                        class: window.Embed,
                                        inlineToolbar: true,
                                        config: {
                                            services: { youtube: true, vimeo: true, instagram: true, facebook: true, twitter: true }
                                        }
                                    },
                                    image: {
                                        class: window.ImageTool,
                                        config: {
                                            uploader: {
                                                async uploadByFile(file) {
                                                    return new Promise((resolve, reject) => {
                                                        @this.upload('editorImage', file, async () => {
                                                            try {
                                                                const url = await @this.saveEditorImage();
                                                                if (url) {
                                                                    resolve({ success: 1, file: { url: url } });
                                                                } else {
                                                                    reject('Save failed');
                                                                }
                                                            } catch (e) {
                                                                reject(e);
                                                            }
                                                        }, () => {
                                                            reject('Upload failed');
                                                        });
                                                    });
                                                }
                                            }
                                        }
                                    },
                                    attaches: {
                                        class: window.AttachesTool,
                                        config: {
                                            types: 'application/pdf, text/plain, text/csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                            uploader: {
                                                async uploadByFile(file) {
                                                    return new Promise((resolve, reject) => {
                                                        @this.upload('editorImage', file, (uploadedFilename) => {
                                                            @this.saveEditorImage().then(url => {
                                                                url ? resolve({ success: 1, file: { url: url, name: file.name, size: file.size } }) : reject('Save failed');
                                                            });
                                                        }, () => reject('Upload failed'));
                                                    });
                                                }
                                            }
                                        }
                                    },
                                    linkTool: {
                                        class: window.LinkTool,
                                        config: {
                                            uploader: {
                                                async fetchData(url) {
                                                    return @this.fetchLinkMetadata(url).then(result => {
                                                        return {
                                                            success: 1,
                                                            meta: result
                                                        };
                                                    });
                                                }
                                            }
                                        }
                                    },
                                }
                            });
                        }
                    }"
                    x-init="setTimeout(() => initEditor(@js($content)), 500)"
                    x-on:article-loaded.window="initEditor($event.detail.content)"
                    wire:ignore>
                    <div x-ref="editor" class="prose max-w-none rounded-lg p-4 bg-white min-h-[400px]"></div>
                </div>
            </div>

            <div class="w-full lg:w-1/3 flex flex-col items-center justify-start pt-40">
                <div class="space-y-4 sticky top-10">
                    <button class="relative inline-flex items-center justify-center px-10 py-4 font-bold text-white transition duration-300 ease-in-out transform hover:scale-110 rounded-full shadow-[0_0_20px_rgba(192,38,211,0.5)] overflow-hidden bg-gradient-to-r from-pink-500 via-purple-600 via-indigo-500 via-cyan-500 to-teal-400 bg-[length:400%_400%] animate-[gradient_4s_ease_infinite]">
                        <span class="absolute inset-0 bg-white opacity-10 hover:opacity-20 transition-opacity"></span>
                        <span class="relative flex items-center">Start writing with Eddy AI</span>
                    </button>
                    <button class="block w-full lg:w-auto lg:ml-12 text-center text-gray-900 hover:text-gray-900 py-3 px-7 rounded-full bg-gray-100 transition duration-150 ease-in-out text-sm">Pick a template</button>
                    <button class="w-full lg:w-auto lg:ml-11 text-center text-gray-900 hover:text-gray-900 py-3 px-6 rounded-full bg-gray-100 transition duration-150 ease-in-out text-sm">Import document</button>
                </div>
            </div>
        </div>
    </main>

    <style>
        @keyframes gradient { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .editor-custom-icons .ce-toolbar__plus, .editor-custom-icons .ce-toolbar__settings-btn, .editor-custom-icons .ce-toolbox__button { border: none !important; box-shadow: none !important; color: #374151 !important; }
        .editor-custom-icons .ce-popover__item-icon { display: flex !important; align-items: center !important; justify-content: center !important; width: 28px !important; height: 28px !important; }
        .editor-custom-icons [class*="icon-"] { mask-image: none !important; -webkit-mask-image: none !important; background-color: transparent !important; border: 1px solid #aaadb3 !important; border-radius: 4px !important; width: 28px !important; height: 28px !important; display: flex !important; align-items: center !important; justify-content: center !important; }
        .editor-custom-icons .ce-popover__item-icon svg, .editor-custom-icons .ce-toolbar__plus svg, .editor-custom-icons .ce-toolbox__button svg { width: 20px !important; height: 20px !important; fill: #383c42 !important; }
        .editor-custom-icons .ce-toolbar__content { max-width: none !important; margin-left: 0 !important; }
        .editor-custom-icons .ce-toolbar__actions { left: -35px !important; right: auto !important; }
        [x-cloak] { display: none !important; }
        h1.ce-header { font-size: 2.25rem; font-weight: 700; }
        h2.ce-header { font-size: 1.875rem; font-weight: 700; }
        h3.ce-header { font-size: 1.5rem; font-weight: 600; }
    </style>
    <livewire:document.partial.article-preview />
</div>