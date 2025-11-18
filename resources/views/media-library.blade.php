@extends('layouts.app')
@section('content')
    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="modal-members">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-black text-xl">Members</h4>
                <button class="text-gray-500 hover:text-gray-700" aria-label="Close" onclick="document.getElementById('modal-members').classList.add('hidden')">
                    &times;
                </button>
            </div>
            <div class="mb-6">
                <div class="mb-4">
                    <div class="inline">
                        <p class="inline">Created by :&nbsp;</p>
                    </div>
                    <div class="inline">
                        <img class="border rounded-full mr-1" src="assets/img/avatars/avatar4.jpeg" width="20" height="20">
                        <p class="inline">Serene</p>
                    </div>
                </div>
                <div class="flex items-center mb-2">
                    <div class="shadow-sm p-2 rounded flex-grow">
                        <p class="m-0">
                            <img class="border rounded-full mr-1" src="assets/img/avatars/avatar5.jpeg" width="20" height="20">
                            Izzat Saifullah
                        </p>
                    </div>
                    <div class="ml-2 text-center">
                        <button class="bg-red-500 text-white font-bold py-1 px-2 rounded shadow-sm text-xs border border-gray-300" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-sm">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7l16 0"></path>
                                <path d="M10 11l0 6"></path>
                                <path d="M14 11l0 6"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mb-2">
                    <div class="shadow-sm p-2 rounded flex-grow">
                        <p class="m-0">
                            <img class="border rounded-full mr-1" src="assets/img/avatars/avatar3.jpeg" width="20" height="20">
                            Arabee
                        </p>
                    </div>
                    <div class="ml-2 text-center">
                        <button class="bg-red-500 text-white font-bold py-1 px-2 rounded shadow-sm text-xs border border-gray-300" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-sm">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7l16 0"></path>
                                <path d="M10 11l0 6"></path>
                                <path d="M14 11l0 6"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mb-2">
                    <div class="shadow-sm p-2 rounded flex-grow">
                        <p class="m-0">
                            <img class="border rounded-full mr-1" src="assets/img/avatars/avatar2.jpeg" width="20" height="20">
                            Nina
                        </p>
                    </div>
                    <div class="ml-2 text-center">
                        <button class="bg-red-500 text-white font-bold py-1 px-2 rounded shadow-sm text-xs border border-gray-300" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-sm">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7l16 0"></path>
                                <path d="M10 11l0 6"></path>
                                <path d="M14 11l0 6"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-2">
                <button class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100" type="button" onclick="document.getElementById('modal-members').classList.add('hidden')">
                    Close
                </button>
                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" type="button">
                    Save
                </button>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="modal-delete-folder">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <div class="text-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="border rounded-full p-1 mx-auto text-red-500 bg-red-100">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                    <path d="M12 8v4"></path>
                    <path d="M12 16h.01"></path>
                </svg>
                <p class="font-semibold mt-4 text-black text-2xl">Delete folder</p>
                <p class="my-2">Are you sure you want to delete this folder?<br>This action cannot be undone.</p>
                <p class="text-red-500 font-bold italic text-sm">This folder contains 453 files!</p>
            </div>
            <div class="flex justify-center space-x-4">
                <button class="px-6 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100" type="button" onclick="document.getElementById('modal-delete-folder').classList.add('hidden')">
                    Cancel
                </button>
                <button class="px-6 py-2 bg-red-500 text-white rounded hover:bg-red-600" type="button">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="modal-delete-file">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <div class="text-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="border rounded-full p-1 mx-auto text-red-500 bg-red-100">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                    <path d="M12 8v4"></path>
                    <path d="M12 16h.01"></path>
                </svg>
                <p class="font-semibold mt-4 text-black text-2xl">Delete file</p>
                <p>Are you sure you want to delete this file?<br>This action cannot be undone.</p>
            </div>
            <div class="flex justify-center space-x-4">
                <button class="px-6 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100" type="button" onclick="document.getElementById('modal-delete-file').classList.add('hidden')">
                    Cancel
                </button>
                <button class="px-6 py-2 bg-red-500 text-white rounded hover:bg-red-600" type="button">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <div class="container mx-auto mb-0 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card bg-gradient-to-b from-blue-600 to-cyan-400 pb-0 mb-3">
                <div class="p-4">
                    <i class="fa fa-folder-open text-6xl text-white"></i>
                    <p class="text-white font-bold mb-2">Total Folders</p>
                    <p class="font-semibold text-white text-2xl">27</p>
                </div>
            </div>
            <div class="card bg-gradient-to-b from-blue-600 to-cyan-400 mb-3">
                <div class="p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" height="4em" viewBox="0 0 24 24" width="4em" fill="currentColor" class="text-white">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4l6 6v10c0 1.1-.9 2-2 2H7.99C6.89 23 6 22.1 6 21l.01-14c0-1.1.89-2 1.99-2h7zm-1 7h5.5L14 6.5V12z"></path>
                    </svg>
                    <p class="text-white font-bold mb-2">Total Files</p>
                    <p class="font-semibold text-white text-2xl">1253</p>
                </div>
            </div>
            <div class="card bg-gradient-to-b from-blue-600 to-cyan-400 mb-3">
                <div class="p-4">
                    <i class="fa fa-server text-6xl text-white"></i>
                    <p class="text-white font-bold mb-2">Total Memory</p>
                    <p class="font-semibold text-white text-2xl">29.5 GB</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <p class="font-bold text-xl text-black">Folders</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4" x-data="{ tab: 'tab-1' }">
    <div>
        <ul class="flex border-b" role="tablist">
            <li class="mr-1" role="presentation">
                <button
                    @click="tab = 'tab-1'"
                    :class="tab === 'tab-1' ? 'border-b-2 border-blue-500 text-black font-semibold' : 'text-black/50'"
                    class="py-2 px-4 focus:outline-none"
                    role="tab">
                    Group
                </button>
            </li>
            <li class="mr-1" role="presentation">
                <button
                    @click="tab = 'tab-2'"
                    :class="tab === 'tab-2' ? 'border-b-2 border-blue-500 text-black font-semibold' : 'text-black/50'"
                    class="py-2 px-4 focus:outline-none"
                    role="tab">
                    List
                </button>
            </li>
        </ul>
        <div class="mt-4">
            <div x-show="tab === 'tab-1'" role="tabpanel" id="tab-1">
                        <div class="mt-3 flex flex-wrap -mx-3">
                            <!-- Projects Folder -->
                            <div class="w-full md:w-1/4 px-3 mb-6">
                            <div class="rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-4">
                                <div class="flex mb-2">
                                    <div class="w-1/2">
                                    <i class="fa fa-folder-open text-blue-600 text-6xl"></i>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <div class="dropdown relative inline-block">
                                        <button class="text-black border-none bg-transparent" type="button">
                                        <i class="icon ion-android-more-vertical text-base"></i>
                                        </button>
                                        <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-members" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="inline mr-1 text-base">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                            </svg> Members
                                        </a>
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-delete-folder" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="inline mr-1 text-base">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                            <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                            <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                            </svg> Delete
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <p class="text-blue-800 font-bold mb-1">Projects</p>
                                <div class="flex mb-1">
                                    <div class="w-1/2">
                                    <p class="text-sm">453 files</p>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <p class="font-bold text-black">11 GB</p>
                                    </div>
                                </div>
                                <div class="flex mt-2 justify-end">
                                    <a class="inline-flex items-center text-xs font-semibold rounded overflow-hidden" role="button">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800">
                                        <i class="fa fa-lock text-yellow-600 text-xs"></i>
                                    </span>
                                    <span class="px-2 py-1 bg-white text-yellow-600">27 Members</span>
                                    </a>
                                </div>
                                </div>
                            </div>
                            </div>

                            <!-- Marketing Folder -->
                            <div class="w-full md:w-1/4 px-3 mb-6">
                            <div class="rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-4">
                                <div class="flex mb-2">
                                    <div class="w-1/2">
                                    <i class="fa fa-folder-open text-blue-600 text-6xl"></i>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <div class="dropdown relative inline-block">
                                        <button class="text-black border-none bg-transparent" type="button">
                                        <i class="icon ion-android-more-vertical text-base"></i>
                                        </button>
                                        <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-members" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="inline mr-1 text-base">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                            </svg> Members
                                        </a>
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-delete-folder" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="inline mr-1 text-base">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                            <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                            <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                            </svg> Delete
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <p class="text-blue-800 font-bold mb-1">Marketing</p>
                                <div class="flex mb-1">
                                    <div class="w-1/2">
                                    <p class="text-sm">84 files</p>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <p class="font-bold text-black">3.6 GB</p>
                                    </div>
                                </div>
                                <div class="flex mt-2 justify-end">
                                    <a class="inline-flex items-center text-xs font-semibold rounded overflow-hidden" role="button">
                                    <span class="px-2 py-1 bg-green-100 text-green-800">
                                        <i class="fa fa-unlock text-green-600"></i>
                                    </span>
                                    <span class="px-2 py-1 bg-white text-green-600">Public</span>
                                    </a>
                                </div>
                                </div>
                            </div>
                            </div>

                            <!-- Personal Folder -->
                            <div class="w-full md:w-1/4 px-3 mb-6">
                            <div class="rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-4">
                                <div class="flex mb-2">
                                    <div class="w-1/2">
                                    <i class="fa fa-folder-open text-blue-600 text-6xl"></i>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <div class="dropdown relative inline-block">
                                        <button class="text-black border-none bg-transparent" type="button">
                                        <i class="icon ion-android-more-vertical text-base"></i>
                                        </button>
                                        <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-members" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="inline mr-1 text-base">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                            </svg> Members
                                        </a>
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-delete-folder" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="inline mr-1 text-base">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                            <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                            <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                            </svg> Delete
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <p class="text-blue-800 font-bold mb-1">Personal</p>
                                <div class="flex mb-1">
                                    <div class="w-1/2">
                                    <p class="text-sm">287 files</p>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <p class="font-bold text-black">8.9 GB</p>
                                    </div>
                                </div>
                                <div class="flex mt-2 justify-end">
                                    <a class="inline-flex items-center text-xs font-semibold rounded overflow-hidden" role="button">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800">
                                        <i class="fa fa-lock text-yellow-600 text-xs"></i>
                                    </span>
                                    <span class="px-2 py-1 bg-white text-yellow-600">10 Members</span>
                                    </a>
                                </div>
                                </div>
                            </div>
                            </div>

                            <!-- Portfolio Folder -->
                            <div class="w-full md:w-1/4 px-3 mb-6">
                            <div class="rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-4">
                                <div class="flex mb-2">
                                    <div class="w-1/2">
                                    <i class="fa fa-folder-open text-blue-600 text-6xl"></i>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <div class="dropdown relative inline-block">
                                        <button class="text-black border-none bg-transparent" type="button">
                                        <i class="icon ion-android-more-vertical text-base"></i>
                                        </button>
                                        <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-members" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="inline mr-1 text-base">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                            </svg> Members
                                        </a>
                                        <a class="dropdown-item block px-4 py-2 text-gray-800 hover:bg-gray-100" href="#" data-target="#modal-delete-folder" data-toggle="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="inline mr-1 text-base">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                            <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                            <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                            </svg> Delete
                                        </a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <p class="text-blue-800 font-bold mb-1">Portfolio</p>
                                <div class="flex mb-1">
                                    <div class="w-1/2">
                                    <p class="text-sm">58 files</p>
                                    </div>
                                    <div class="w-1/2 text-right">
                                    <p class="font-bold text-black">6 GB</p>
                                    </div>
                                </div>
                                <div class="flex mt-2 justify-end">
                                    <a class="inline-flex items-center text-xs font-semibold rounded overflow-hidden" role="button">
                                    <span class="px-2 py-1 bg-green-100 text-green-800">
                                        <i class="fa fa-unlock text-green-600"></i>
                                    </span>
                                    <span class="px-2 py-1 bg-white text-green-600">Public</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="tab === 'tab-2'" role="tabpanel" id="tab-2">
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <div class="flex flex-wrap mb-3 py-2 px-0 mt-3 rounded-lg border border-gray-300 bg-gray-50">
                        <div class="w-full md:w-1/2">
                            <div class="inline-block px-1 py-1">
                                <button class="font-semibold shadow-sm py-1 px-2 rounded border border-gray-300 text-gray-500 text-sm bg-transparent" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-ease-in-out-control-points inline mr-1">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M17 20a2 2 0 1 0 4 0a2 2 0 0 0 -4 0z"></path>
                                        <path d="M17 20h-2"></path>
                                        <path d="M7 4a2 2 0 1 1 -4 0a2 2 0 0 1 4 0z"></path>
                                        <path d="M7 4h2"></path>
                                        <path d="M14 4h-2"></path>
                                        <path d="M12 20h-2"></path>
                                        <path d="M3 20c8 0 10 -16 18 -16"></path>
                                    </svg>
                                    Filter
                                </button>
                            </div>
                            <div class="inline-block px-1 py-1">
                                <select class="shadow-sm p-1 border border-gray-300 rounded text-gray-500 text-sm bg-transparent">
                                    <option value="" selected>All</option>
                                    <option value="12">Members</option>
                                    <option value="13">Public</option>
                                </select>
                            </div>
                            <div class="inline-block px-1 py-1">
                                <select class="shadow-sm p-1 border border-gray-300 rounded text-gray-500 text-sm bg-transparent">
                                    <optgroup label="Includes shared and private folders">
                                        <option value="" selected>All Folders</option>
                                    </optgroup>
                                    <optgroup label="Folders you own or have access to">
                                        <option value="12">Accessible Folders</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 text-right">
                            <input class="shadow-sm form-input-sm pl-3 pr-3 rounded bg-transparent" type="search" placeholder="Search task...">
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full">
                            <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-300">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="font-semibold text-gray-500 py-2 px-4">Name</th>
                                            <th class="font-semibold text-gray-500 py-2 px-4">Created By</th>
                                            <th class="text-gray-500 py-2 px-4">Members</th>
                                            <th class="font-semibold text-gray-500 py-2 px-4">Size</th>
                                            <th class="py-2 px-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-t border-gray-200">
                                            <td class="font-semibold text-sm py-2 px-4">
                                                <i class="fa fa-folder-open mr-1 text-blue-500 text-xl"></i>Projects
                                            </td>
                                            <td class="text-sm py-2 px-4">
                                                <img class="border rounded-full mr-1 inline" src="assets/img/avatars/avatar5.jpeg" width="25" height="25">Izzat
                                            </td>
                                            <td class="py-2 px-4">
                                                <button class="inline-flex items-center text-xs font-semibold border border-yellow-400 rounded overflow-hidden">
                                                    <span class="px-2 bg-yellow-100 text-yellow-600">
                                                        <i class="fa fa-lock text-yellow-500 text-xs"></i>
                                                    </span>
                                                    <span class="px-2 bg-white text-yellow-600">10 Members</span>
                                                </button>
                                            </td>
                                            <td class="text-sm py-2 px-4">11 GB</td>
                                            <td class="py-2 px-4 text-center">
                                                <div class="dropdown inline-block relative">
                                                    <button class="text-black bg-transparent" type="button">
                                                        <i class="icon ion-android-more-vertical mr-1 text-lg"></i>
                                                    </button>
                                                    <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded shadow-lg z-10">
                                                        <a class="block px-4 py-2 text-gray-800 hover:bg-blue-50" href="#" data-target="#modal-members" data-toggle="modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="mr-1 inline" style="font-size: 16px;">
                                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                                            </svg>Members
                                                        </a>
                                                        <a class="block px-4 py-2 text-gray-800 hover:bg-blue-50" href="#">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-1 inline" style="font-size: 16px;">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                                                <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                                                <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                                            </svg>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-t border-gray-200">
                                            <td class="font-semibold text-sm py-2 px-4">
                                                <i class="fa fa-folder-open mr-1 text-blue-500 text-xl"></i>Marketing
                                            </td>
                                            <td class="text-sm py-2 px-4">
                                                <img class="border rounded-full mr-1 inline" src="assets/img/avatars/avatar4.jpeg" width="25" height="25">Serene
                                            </td>
                                            <td class="py-2 px-4">
                                                <button class="inline-flex items-center text-xs font-semibold rounded overflow-hidden">
                                                    <span class="px-2 bg-green-100 text-green-600">
                                                        <i class="fa fa-unlock text-green-500"></i>
                                                    </span>
                                                    <span class="px-2 bg-white text-green-600">Public</span>
                                                </button>
                                            </td>
                                            <td class="text-sm py-2 px-4">3.6 GB</td>
                                            <td class="py-2 px-4 text-center">
                                                <div class="dropdown inline-block relative">
                                                    <button class="text-black bg-transparent" type="button">
                                                        <i class="icon ion-android-more-vertical mr-1 text-lg"></i>
                                                    </button>
                                                    <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded shadow-lg z-10">
                                                        <a class="block px-4 py-2 text-gray-800 hover:bg-blue-50" href="#" data-target="#modal-members" data-toggle="modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="mr-1 inline" style="font-size: 16px;">
                                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                                            </svg>Members
                                                        </a>
                                                        <a class="block px-4 py-2 text-gray-800 hover:bg-blue-50" href="#">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-1 inline" style="font-size: 16px;">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                                                <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                                                <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                                            </svg>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-t border-gray-200">
                                            <td class="font-semibold text-sm py-2 px-4">
                                                <i class="fa fa-folder-open mr-1 text-blue-500 text-xl"></i>Personal
                                            </td>
                                            <td class="text-sm py-2 px-4">
                                                <img class="border rounded-full mr-1 inline" src="assets/img/avatars/avatar4.jpeg" width="25" height="25">Serene
                                            </td>
                                            <td class="py-2 px-4">
                                                <button class="inline-flex items-center text-xs font-semibold border border-yellow-400 rounded overflow-hidden">
                                                    <span class="px-2 bg-yellow-100 text-yellow-600">
                                                        <i class="fa fa-lock text-yellow-500 text-xs"></i>
                                                    </span>
                                                    <span class="px-2 bg-white text-yellow-600">17 Members</span>
                                                </button>
                                            </td>
                                            <td class="text-sm py-2 px-4">8.9 GB</td>
                                            <td class="py-2 px-4 text-center">
                                                <div class="dropdown inline-block relative">
                                                    <button class="text-black bg-transparent" type="button">
                                                        <i class="icon ion-android-more-vertical mr-1 text-lg"></i>
                                                    </button>
                                                    <div class="dropdown-menu absolute hidden right-0 mt-2 w-48 bg-white rounded shadow-lg z-10">
                                                        <a class="block px-4 py-2 text-gray-800 hover:bg-blue-50" href="#" data-target="#modal-members" data-toggle="modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="mr-1 inline" style="font-size: 16px;">
                                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
                                                            </svg>Members
                                                        </a>
                                                        <a class="block px-4 py-2 text-gray-800 hover:bg-blue-50" href="#">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-1 inline" style="font-size: 16px;">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                                                <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                                                <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                                            </svg>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   <div class="container mx-auto mt-4">
    <div class="flex flex-wrap">
        <div class="w-full">
        <p class="font-bold text-xl text-black">Files</p>
        </div>
    </div>
    <div class="flex flex-wrap mb-3 mt-0 py-2 mx-0 px-0 rounded-xl border border-gray-300 bg-gray-50">
        <div class="w-full md:w-auto flex-grow">
        <div class="inline-block px-1 py-1">
            <button class="font-semibold shadow-sm py-1 px-3 text-gray-500 rounded border border-gray-300 bg-transparent text-sm" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="inline mr-1">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M17 20a2 2 0 1 0 4 0a2 2 0 0 0 -4 0z"></path>
                <path d="M17 20h-2"></path>
                <path d="M7 4a2 2 0 1 1 -4 0a2 2 0 0 1 4 0z"></path>
                <path d="M7 4h2"></path>
                <path d="M14 4h-2"></path>
                <path d="M12 20h-2"></path>
                <path d="M3 20c8 0 10 -16 18 -16"></path>
            </svg>
            Filter
            </button>
        </div>
        <div class="inline-block px-1 py-1">
            <select class="shadow-sm p-1 border border-gray-300 rounded text-gray-500 text-sm bg-transparent">
            <option value="" selected>All</option>
            <option value="12">Members</option>
            <option value="13">Public</option>
            </select>
        </div>
        <div class="inline-block px-1 py-1">
            <select class="shadow-sm p-1 border border-gray-300 rounded text-gray-500 text-sm bg-transparent">
            <optgroup label="Includes shared and private files">
                <option value="" selected>All Files</option>
            </optgroup>
            <optgroup label="Files you own or have access to">
                <option value="12">Accessible Files</option>
            </optgroup>
            </select>
        </div>
        </div>
        <div class="w-full md:w-auto text-right">
        <input class="shadow-sm px-3 py-1 rounded bg-transparent border-none focus:outline-none" type="search" placeholder="Search task...">
        </div>
    </div>
</div>
    <div class="mx-auto px-4">
    <div class="flex flex-wrap">
        <div class="w-full">
        <div class="shadow-sm rounded-lg overflow-hidden" style="border-radius: 10px; border: 1px solid rgba(133,135,150,0.26);">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Folder
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Created By
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Members
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Size
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Action
                </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                    class="bi bi-filetype-mp4 mr-2 inline" style="font-size: 30px; color: #3b82f6;">
                    <path fill-rule="evenodd"
                        d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM.706 15.849v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715V11.85h-.8l-1.14 2.596h-.026L.805 11.85H0v3.999zm5.278-3.999h-1.6v3.999h.792v-1.342h.803c.287 0 .53-.057.732-.173.203-.117.357-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477 1.4 1.4 0 0 0-.733-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.237.241.794.794 0 0 1-.375.082h-.66V12.48h.66c.219 0 .39.06.513.181.123.122.184.296.184.522m1.505-.032c.266-.434.53-.867.791-1.301h1.14v2.62h.49v.638h-.49v.741h-.741v-.741H7.287v-.648c.235-.44.484-.876.747-1.31Zm-.029 1.298v.02h1.219v-2.021h-.041c-.201.318-.404.646-.607.984-.2.338-.391.677-.571 1.017">
                    </path>
                    </svg>MyVacation.mp4
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm italic text-gray-500">
                    No folder
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <img class="border rounded-full mr-2" src="assets/img/avatars/avatar5.jpeg" width="25" height="25">Izzat
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button class="inline-flex items-center text-xs font-semibold" style="border-color: #f59e0b;">
                    <span class="px-2 py-1 rounded-l" style="background-color: #fef3c7;">
                        <i class="fa fa-lock" style="color: #f59e0b; font-size: 12px;"></i>
                    </span>
                    <span class="px-2 py-1 rounded-r" style="background-color: #ffffff; color: #f59e0b !important;">
                        10 Members
                    </span>
                    </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    5.7 MB
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="relative inline-block text-left">
                    <button type="button" class="inline-flex justify-center w-full px-2 py-2 text-sm font-medium text-gray-700 focus:outline-none"
                        id="options-menu-1" aria-haspopup="true" aria-expanded="true">
                        <i class="icon ion-android-more-vertical mr-1" style="font-size: 16px;"></i>
                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-2 inline" style="font-size: 16px;">
                            <path d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z" fill="currentColor"></path>
                            <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor"></path>
                            </svg>Download
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-2 inline" style="font-size: 16px;">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                            <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                            <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                            </svg>Delete
                        </a>
                        </div>
                    </div>
                    </div>
                </td>
                </tr>
                <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                    class="bi bi-filetype-pdf mr-2 inline" style="font-size: 30px; color: #ef4444;">
                    <path fill-rule="evenodd"
                        d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z">
                    </path>
                    </svg>Logo Guideline.pdf
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm italic text-gray-500">
                    No folder
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <img class="border rounded-full mr-2" src="assets/img/avatars/avatar4.jpeg" width="25" height="25">Serene
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button class="inline-flex items-center text-xs font-semibold">
                    <span class="px-2 py-1 rounded-l" style="background-color: #dcfce7;">
                        <i class="fa fa-unlock" style="color: #22c55e;"></i>
                    </span>
                    <span class="px-2 py-1 rounded-r" style="background-color: #ffffff; color: #22c55e !important;">
                        Public
                    </span>
                    </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    2.5 MB
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="relative inline-block text-left">
                    <button type="button" class="inline-flex justify-center w-full px-2 py-2 text-sm font-medium text-gray-700 focus:outline-none"
                        id="options-menu-2" aria-haspopup="true" aria-expanded="true">
                        <i class="icon ion-android-more-vertical mr-1" style="font-size: 16px;"></i>
                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-2 inline" style="font-size: 16px;">
                            <path d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z" fill="currentColor"></path>
                            <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor"></path>
                            </svg>Download
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-2 inline" style="font-size: 16px;">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                            <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                            <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                            </svg>Delete
                        </a>
                        </div>
                    </div>
                    </div>
                </td>
                </tr>
                <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                    class="bi bi-file-earmark-zip mr-2 inline" style="font-size: 30px; color: #f59e0b;">
                    <path
                        d="M5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.11 0l-.929-.62a1 1 0 0 1-.415-1.074L5 8.438zm2 0H6v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.929-.62-.4-1.598A1 1 0 0 1 7 8.438z">
                    </path>
                    <path
                        d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1h-2v1h-1v1h1v1h-1v1h1v1H6V5H5V4h1V3H5V2h1V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z">
                    </path>
                    </svg>Project Brief &amp; Assets.zip
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button class="inline-flex items-center text-xs font-semibold" style="border-color: #3b82f6;">
                    <span class="px-2 py-1 rounded-l" style="background-color: #dbeafe;">
                        <i class="fa fa-folder-open" style="color: #3b82f6;"></i>
                    </span>
                    <span class="px-2 py-1 rounded-r" style="background-color: #ffffff; color: #3b82f6 !important;">
                        Marketing
                    </span>
                    </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <img class="border rounded-full mr-2" src="assets/img/avatars/avatar4.jpeg" width="25" height="25">Serene
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button class="inline-flex items-center text-xs font-semibold" style="border-color: #f59e0b;">
                    <span class="px-2 py-1 rounded-l" style="background-color: #fef3c7;">
                        <i class="fa fa-lock" style="color: #f59e0b; font-size: 12px;"></i>
                    </span>
                    <span class="px-2 py-1 rounded-r" style="background-color: #ffffff; color: #f59e0b !important;">
                        17 Members
                    </span>
                    </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    2.5 MB
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="relative inline-block text-left">
                        <button type="button" class="inline-flex justify-center w-full px-2 py-2 text-sm font-medium text-gray-700 focus:outline-none"
                            id="options-menu-3" aria-haspopup="true" aria-expanded="true">
                            <i class="icon ion-android-more-vertical mr-1" style="font-size: 16px;"></i>
                        </button>
                        <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-3">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-2 inline" style="font-size: 16px;">
                                    <path d="M11 5C11 4.44772 11.4477 4 12 4C12.5523 4 13 4.44772 13 5V12.1578L16.2428 8.91501L17.657 10.3292L12.0001 15.9861L6.34326 10.3292L7.75748 8.91501L11 12.1575V5Z" fill="currentColor"></path>
                                    <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="currentColor"></path>
                                    </svg>Download
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" class="mr-2 inline" style="font-size: 16px;">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" fill="currentColor"></path>
                                    <path d="M9 9H11V17H9V9Z" fill="currentColor"></path>
                                    <path d="M13 9H15V17H13V9Z" fill="currentColor"></path>
                                    </svg>Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
