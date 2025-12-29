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

            // Manual save button
            handleManualSave: async function () {
                if (!window.editorInstance || this.isSaving) return;

                this.isSaving = true;

                try {
                    const outputData = await window.editorInstance.save();
                    await $wire.save(outputData);

                    window.dispatchEvent(new CustomEvent('article-updated-in-list', {
                        detail: { id: @this.articleId, title: @this.title }
                    }));
                } catch (error) {
                    console.error('Save failed:', error);
                } finally {
                    setTimeout(() => { this.isSaving = false; }, 800);
                }
            },

            // ✅ AUTO SAVE WHEN STATUS IS SELECTED
            handleStatusChange: async function (status) {
                if (!window.editorInstance || this.isSaving) return;

                this.isSaving = true;

                try {
                    const outputData = await window.editorInstance.save();
                    await $wire.save(outputData, status);
                } catch (error) {
                    console.error('Status save failed:', error);
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
            <svg class="h-5 w-5 cursor-pointer" fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M16.108 10.044c-3.313 0-6 2.687-6 6s2.687 6 6 6 6-2.686 6-6-2.686-6-6-6zM16.108 20.044c-2.206 0-4.046-1.838-4.046-4.044s1.794-4 4-4c2.206 0 4 1.794 4 4s-1.748 4.044-3.954 4.044zM31.99 15.768c-0.012-0.050-0.006-0.104-0.021-0.153-0.006-0.021-0.020-0.033-0.027-0.051-0.011-0.028-0.008-0.062-0.023-0.089-2.909-6.66-9.177-10.492-15.857-10.492s-13.074 3.826-15.984 10.486c-0.012 0.028-0.010 0.057-0.021 0.089-0.007 0.020-0.021 0.030-0.028 0.049-0.015 0.050-0.009 0.103-0.019 0.154-0.018 0.090-0.035 0.178-0.035 0.269s0.017 0.177 0.035 0.268c0.010 0.050 0.003 0.105 0.019 0.152 0.006 0.023 0.021 0.032 0.028 0.052 0.010 0.027 0.008 0.061 0.021 0.089 2.91 6.658 9.242 10.428 15.922 10.428s13.011-3.762 15.92-10.422c0.015-0.029 0.012-0.058 0.023-0.090 0.007-0.017 0.020-0.030 0.026-0.050 0.015-0.049 0.011-0.102 0.021-0.154 0.018-0.090 0.034-0.177 0.034-0.27 0-0.088-0.017-0.175-0.035-0.266zM16 25.019c-5.665 0-11.242-2.986-13.982-8.99 2.714-5.983 8.365-9.047 14.044-9.047 5.678 0 11.203 3.067 13.918 9.053-2.713 5.982-8.301 8.984-13.981 8.984z"></path></svg>
           @if($articleId)
                <a
                    href="{{ route('user.article.preview', $articleId) }}"
                    target="_blank"
                    class="text-gray-500 hover:text-gray-700 rounded-full transition"
                >
                    Preview
                </a>
            @endif


        </div>

        <div class="flex items-center space-x-4">
            <button class="text-gray-500 hover:text-gray-700 transition">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 10H16.01M12 10H12.01M8 10H8.01M7 16V21L12 16H20V4H4V16H7Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </button>
            <button class="text-gray-500 hover:text-gray-700 transition">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 8C21.4477 8 21 7.55228 21 7V4.41421L14.7071 10.7071C14.3166 11.0976 13.6834 11.0976 13.2929 10.7071C12.9024 10.3166 12.9024 9.68342 13.2929 9.29289L19.5858 3H17C16.4477 3 16 2.55228 16 2C16 1.44772 16.4477 1 17 1H21C22.1046 1 23 1.89543 23 3V7C23 7.55228 22.5523 8 22 8Z" fill="#0F0F0F"></path><path d="M2 16C2.55228 16 3 16.4477 3 17V19.5858L9.29289 13.2929C9.68342 12.9024 10.3166 12.9024 10.7071 13.2929C11.0976 13.6834 11.0976 14.3166 10.7071 14.7071L4.41421 21H7C7.55228 21 8 21.4477 8 22C8 22.5523 7.55228 23 7 23H3C1.89543 23 1 22.1046 1 21V17C1 16.4477 1.44772 16 2 16Z" fill="#0F0F0F"></path></svg>
            </button>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-gray-600 cursor-pointer">
                <svg class="h-5 w-5" fill="#000000" viewBox="0 0 32 32"><path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z"></path><path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z"></path><path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z"></path></svg>
            </div>
            <button @click="handleManualSave()"
                    :disabled="isSaving"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-1 px-3 rounded-lg shadow-md transition text-sm flex items-center disabled:opacity-50">
                <span x-text="isSaving ? 'Saving...' : 'Save'"></span>
                <svg x-show="!isSaving" class="h-4 w-4 ml-1" fill="#FFFFFF" viewBox="0 0 24 24"><path d="M7.00003 8.5C6.59557 8.5 6.23093 8.74364 6.07615 9.11732C5.92137 9.49099 6.00692 9.92111 6.29292 10.2071L11.2929 15.2071C11.6834 15.5976 12.3166 15.5976 12.7071 15.2071L17.7071 10.2071C17.9931 9.92111 18.0787 9.49099 17.9239 9.11732C17.7691 8.74364 17.4045 8.5 17 8.5H7.00003Z"></path></svg>
            </button>
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
                            const staticArticleData = {
                               blocks: [
                                    {
                                        id: 'welcome_01',
                                        type: 'paragraph',
                                        data: {
                                            text: 'welcome editor'
                                        }
                                    }
                                ]
                            };
                            if (window.editorInstance && typeof window.editorInstance.destroy === 'function') {
                                window.editorInstance.destroy();
                            }
                            window.editorInstance = new window.EditorJS({
                                holder: this.$refs.editor,
                                placeholder: 'Write here...',
                                inlineToolbar: true,
                                data: staticArticleData,
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
                                            // रूट ऐवजी थेट एका मॅन्युअल फंक्शनचा वापर (जर बॅकएंडला विचारायचे असेल तर)
                                            uploader: {
                                                async fetchData(url) {
                                                    // बॅकएंडला (Livewire) डेटा फेच करण्यासाठी कॉल करा
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
                    x-init="setTimeout(() => initEditor(), 500)"
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
</div>
