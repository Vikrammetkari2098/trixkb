@extends('layouts.app')

@section('content')
<div class="flex">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    // Custom colors to match the screenshot
                    'primary-purple': '#6d28d9', // Dark Purple
                    'active-bg': '#f3e8ff',     // Lightest Purple background (approx. bg-purple-50)
                    'border-light': '#e5e7eb',
                    'user-initial-bg': '#fcd34d', // Yellow/Orange for JW
                    'icon-blue': '#2563eb', // Blue folder icon
                }
            }
        }
    }
</script>

<style>
    /* Custom Styles to match the screenshot details */
    .icon {
        margin-right: 0.5rem;
        width: 1rem;
        display: inline-block;
        text-align: center;
        color: theme('colors.gray.500'); 
    }
    .file-row:hover {
        background-color: theme('colors.gray.50');
        cursor: pointer;
    }
    /* Active Menu Styling (Matching the light purple background in the photo) */
    .active-menu-item {
        background-color: theme('colors.active-bg');
        color: theme('colors.primary-purple');
        font-weight: 600;
        /* Note: The screenshot doesn't show a strong left border, just the background */
    }
    .active-menu-item .icon {
        color: theme('colors.primary-purple');
    }
    .folder-arrow {
        color: theme('colors.gray.400'); /* Gray color for the arrow */
        margin-right: 0.5rem;
        font-size: 0.75rem; /* Smaller arrow size */
    }
    /* Ensure the search bar is the width shown in the image */
    .search-input-w {
        width: 250px; /* Specific width for the search box */
    }
</style>

<div class="w-68 bg-white border-r h-screen p-4" x-data="{ myDriveOpen: false }">
    <!-- Top Buttons -->
    <div class="flex flex-nowrap gap-2 mb-4">
    <button class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 whitespace-nowrap">
        Upload files
    
    </button>
    
    <button class="px-4 py-2 border border-indigo-400 text-indigo-600 rounded-md hover:bg-indigo-50 whitespace-nowrap">
        New folder
    </button>
</div>


    <!-- Menu List -->
    <ul class="space-y-1 text-sm">
        <li class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 rounded-md cursor-pointer">
            <span>📄</span> All files
        </li>
        <li class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 rounded-md cursor-pointer">
            <span>⏱</span> Recent
        </li>
        <li class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 rounded-md cursor-pointer">
            <span>⭐</span> Starred
        </li>
        <li class="flex items-center gap-2 px-3 py-2 hover:bg-gray-100 rounded-md cursor-pointer">
            <span>🗑</span> Recycle bin
        </li>
    </ul>

    <!-- My Drive -->
    <div class="mt-6">
        <button @click="myDriveOpen = !myDriveOpen"
                :class="myDriveOpen ? 'bg-purple-100 text-blue-700' : ''"
                class="flex items-center gap-2 px-3 py-2 rounded-md font-medium w-full transition-colors duration-200">
            <span>💾</span> My drive
            <svg :class="{'rotate-90': myDriveOpen}" class="ml-auto w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Folder Tree -->
        <ul x-show="myDriveOpen" x-transition class="mt-2 ml-4 space-y-1 text-sm">
            <li class="flex items-center gap-2 px-2 py-1 hover:bg-gray-100 rounded-md cursor-pointer">
                <span>📁</span> Images
            </li>
            <li class="flex items-center gap-2 px-2 py-1 hover:bg-gray-100 rounded-md cursor-pointer">
                <span>📁</span> PDF
            </li>
            <li class="flex items-center gap-2 px-2 py-1 hover:bg-gray-100 rounded-md cursor-pointer">
                <span>📁</span> Presentation
            </li>
            <li class="flex items-center gap-2 px-2 py-1 hover:bg-gray-100 rounded-md cursor-pointer">
                <span>📁</span> Word-documents
            </li>
            <li class="flex items-center gap-2 px-2 py-1 hover:bg-gray-100 rounded-md cursor-pointer">
                <span>📁</span> Zip
            </li>
        </ul>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>


   <div class="p-6 bg-white shadow-lg rounded-lg max-w-full w-full mx-auto mt-10">
    <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-4">
        <div class="flex items-center space-x-2 text-gray-700 font-semibold text-lg">
            <span>Drive</span>
            <button class="text-blue-500 hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM13 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z" /></svg>
            </button>
            <button class="text-blue-500 hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-9a1 1 0 011-1h1a1 1 0 110 2H4a1 1 0 01-1-1zm4 0a1 1 0 011-1h1a1 1 0 110 2H8a1 1 0 01-1-1zm4 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm4 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
            </button>
        </div>
        
        <div class="flex items-center text-xs text-gray-500 space-x-4  bg-white">
            <span class="flex items-center space-x-1">
                <div class="h-2 w-2 bg-gray-300 rounded-full"></div>
                <span>0 Bytes / **1 GB PDF storage used**</span>
            </span>
            <span class="flex items-center space-x-1">
                <div class="h-2 w-2 bg-gray-300 rounded-full"></div>
                <span>0 Bytes / **500 GB storage used**</span>
            </span>
            <a href="#" class="text-blue-600 font-bold hover:underline">Upgrade</a>

            <div class="flex space-x-2">
                <button class="p-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.07a1 1 0 00-1.01-1.01A1 1 0 009.28 3.52c-.14.32-.42.54-.83.65-.3.08-.66.1-1.01.07-.35-.03-.7-.14-.99-.34-.28-.19-.5-.45-.6-.78a1 1 0 00-1.72.63c.02.44.18.87.48 1.25.32.4.74.69 1.25.86.5.17 1.05.21 1.58.11.53-.1.98-.31 1.34-.63a1 1 0 00.14-1.42zM15.48 8.04a1 1 0 00-.7-.41c-.44.02-.87.18-1.25.48-.4.32-.69.74-.86 1.25-.17.5-.21 1.05-.11 1.58.1.53.31.98.63 1.34a1 1 0 001.42-.14c.19-.28.45-.5.78-.6.33-.11.69-.13 1.04-.07.35.06.7.17.99.37.28.19.5.45.6.78a1 1 0 001.72-.63c-.02-.44-.18-.87-.48-1.25-.32-.4-.74-.69-1.25-.86-.5-.17-1.05-.21-1.58-.11-.53.1-.98.31-1.34.63a1 1 0 00-.14 1.42z" clip-rule="evenodd" /></svg>
                </button>
                <button class="p-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.3 11.2a1 1 0 011.4 0l2 2a1 1 0 010 1.4l-2 2a1 1 0 01-1.4-1.4L16.59 14H5a1 1 0 110-2h11.59l-1.29-1.3a1 1 0 010-1.4zm-10.6-6a1 1 0 010-1.4l2-2a1 1 0 011.4 0l2 2a1 1 0 010 1.4l-2 2a1 1 0 01-1.4 0l-2-2z" clip-rule="evenodd" /></svg>
                </button>
                <button class="p-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100">
                    Filter
                </button>
            </div>
        </div>
    </div>



   <div class="overflow-x-auto w-full bg-gray-50 p-4 rounded-lg">
    <table class="min-w-full divide-y divide-gray-200 bg-white shadow rounded-lg">
        <thead class="bg-white">
            <tr>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[5%]">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                </th>

                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                    <div class="flex items-center space-x-2 w-full border border-gray-300 rounded-md p-1 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <input type="text" placeholder="Search file name" class="flex-grow bg-white focus:outline-none text-sm text-gray-900">
                    </div>
                </th>

                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Dependencies
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Size
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Updated on
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Updated by
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tags
                </th>
            </tr>
        </thead>

       

            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" /></svg>
                        Images
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">4 Files</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">Nov 27, 2025</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-400 text-white font-bold text-xs mr-2">JW</span>
                            Justin Wan
                        </div>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 whitespace-nowrap">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm6 0a1 1 0 00-1 1v1a1 1 0 102 0V5a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        PDF
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">0 Files</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">Nov 27, 2025</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-400 text-white font-bold text-xs mr-2">JW</span>
                            Justin Wan
                        </div>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 whitespace-nowrap"><input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded"></td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16 4h-4l-2-2H8L6 4H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2z" clip-rule="evenodd" /></svg>
                        Presentation
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">0 Files</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">Nov 27, 2025</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-400 text-white font-bold text-xs mr-2">JW</span>
                            Justin Wan
                        </div>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                </tr>
                 <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 whitespace-nowrap"><input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded"></td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm6 0a1 1 0 00-1 1v1a1 1 0 102 0V5a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        Word-documents
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">0 Files</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">Nov 27, 2025</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-400 text-white font-bold text-xs mr-2">JW</span>
                            Justin Wan
                        </div>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                </tr>
                 <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 whitespace-nowrap"><input type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded"></td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm6 0a1 1 0 00-1 1v1a1 1 0 102 0V5a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        Zip
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">0 Files</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">Nov 27, 2025</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-400 text-white font-bold text-xs mr-2">JW</span>
                            Justin Wan
                        </div>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-400">-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

</div>

@endsection 