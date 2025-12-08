@extends('layouts.app')
@section('content')

    <style>
        .chart-container {
            position: relative;
            height: 300px; 
            width: 100%;
        }
    </style>
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 space-y-6">
    test
</div>

    <div class="flex h-screen" x-data="{ menuState: 'default', isOpen: false, currentPage: 'Articles', pages: ['Articles', 'Eddy AI', 'Search', 'Reader', 'Team accounts', 'Feedback', 'Link status', 'Page not found', 'Ticket deflector'] }">
    
    <div class="w-80 bg-gray-100 border-r border-gray-200 flex flex-col sticky top-0 h-185">
        
        <nav class="flex-grow p-4 space-y-2">
            
            <a href="#" 
               @click.prevent="currentPage = 'Articles'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Articles', 'text-gray-900': currentPage !== 'Articles'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve" fill="#000000"><g><path d="M12.966,17.262c-0.483,0-0.878,0.395-0.878,0.878s0.395,0.877,0.878,0.877h13.518c0.483,0,0.878-0.394,0.878-0.877 s-0.395-0.878-0.878-0.878H12.966L12.966,17.262z"></path><path d="M9.411,35C9,35,8.652,34.658,8.652,34.254V5.758C8.652,5.34,8.992,5,9.411,5h14.704c0.2,0,0.395,0.084,0.547,0.236 l6.449,6.461c0.15,0.13,0.236,0.324,0.236,0.534v22.022c0,0.404-0.349,0.746-0.759,0.746H9.411z M10.17,33.496h19.672V12.989 h-5.727c-0.417,0-0.758-0.34-0.758-0.757V6.504H10.17V33.496z M24.875,11.485h3.9l-3.9-3.915V11.485z"></path><path d="M12.966,21.164c-0.483,0-0.878,0.395-0.878,0.878s0.395,0.878,0.878,0.878h13.518c0.483,0,0.878-0.395,0.878-0.878 s-0.395-0.878-0.878-0.878H12.966L12.966,21.164z"></path><path d="M12.966,25.065c-0.483,0-0.878,0.395-0.878,0.878c0,0.484,0.395,0.877,0.878,0.877h13.518c0.483,0,0.878-0.393,0.878-0.877 c0-0.483-0.395-0.878-0.878-0.878H12.966L12.966,25.065z"></path></g></svg>
                Articles
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Eddy AI'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Eddy AI', 'text-gray-700': currentPage !== 'Eddy AI'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3 text-indigo-600" fill="#000000" viewBox="0 0 750 750" id="Layer_1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M587.54,369.5c.03,10.91-5.43,16.63-16.87,17.19-24.14,1.2-47.66,5.43-70.69,12.9-27.43,8.89-47.33,25.72-58.1,52.78-8.4,21.11-16.5,42.36-25.41,63.25-5.47,12.82-11.6,25.47-18.67,37.47-3.64,6.18-9.33,11.69-15.26,15.86-9.2,6.48-19.12,3.51-23.72-6.83-2.6-5.85-3.57-12.53-4.64-18.94-2.6-15.51-4.36-31.17-7.3-46.6-10.71-56.23-45.39-90.27-99.85-104.33-20.21-5.22-41.25-7.24-61.9-10.79-4.3-.74-8.56-1.7-12.8-2.74-6.39-1.57-9.44-6.09-9.84-12.33-.4-6.2,2.05-11.2,7.82-13.94,3.13-1.49,6.52-2.53,9.87-3.48,71.73-20.5,129.09-60.82,170.33-123.36,3.13-4.74,5.97-9.67,8.88-14.56,3.12-5.25,6.25-10.14,3.45-17.08-1.21-3.01,.19-7.86,1.89-11.08,3.39-6.41,9.22-7.06,13.65-1.29,6.89,9,18.09,15.47,17.11,29.46-.23,3.33,3.19,7.02,5.22,10.37,31.3,51.75,74.28,90.17,130.41,113.34,13.71,5.66,27.74,10.55,41.7,15.59,10,3.61,14.69,9.46,14.72,19.16Zm-80.92,1.25c-3.28-2.02-5-3.32-6.91-4.24-27.84-13.36-50.78-32.97-68.9-57.56-14.5-19.67-26.86-40.91-40.11-61.5-2.47-3.84-4.64-7.88-7.87-13.4-3.67,5.5-5.88,9.15-8.42,12.56-9.4,12.63-18.22,25.77-28.51,37.62-20.23,23.31-44.3,42.23-70.47,58.55-3.76,2.34-9.04,3.51-10.19,9.6,50.44,11.92,79.34,45.91,95.47,92.54,5.28,15.26,8.96,31.06,13.36,46.62,1.25,4.41,2.45,8.84,4.48,16.17,4.19-6.21,6.92-9.95,9.34-13.88,12.16-19.75,23.73-39.88,36.47-59.24,17.54-26.65,41.24-46.22,71.02-58.19,3.47-1.4,6.71-3.37,11.24-5.67Z"></path></g></svg>
                Eddy AI
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Search'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Search', 'text-gray-700': currentPage !== 'Search'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Search
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Reader'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Reader', 'text-gray-700': currentPage !== 'Reader'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M18.003 3A7.646 7.646 0 0 0 12.5 5.277 7.646 7.646 0 0 0 6.997 3a7.532 7.532 0 0 0-5.833 2.686.79.79 0 0 0-.164.493v13.59a.833.833 0 0 0 .499.755.894.894 0 0 0 .879-.083A8.187 8.187 0 0 1 7 19.033a7.832 7.832 0 0 1 5.153 1.841l.31.355.384-.355A7.832 7.832 0 0 1 18 19.034a8.185 8.185 0 0 1 4.624 1.41.903.903 0 0 0 .875.081.834.834 0 0 0 .501-.755V6.179a.79.79 0 0 0-.161-.49A7.536 7.536 0 0 0 18.003 3zM2 19.49V6.24A6.53 6.53 0 0 1 6.997 4 6.568 6.568 0 0 1 12 6.244v13.253a9.16 9.16 0 0 0-5-1.464 9.266 9.266 0 0 0-5 1.456zm21 0a9.262 9.262 0 0 0-5-1.457 9.16 9.16 0 0 0-5 1.464V6.244a6.697 6.697 0 0 1 10-.005z"></path><path fill="none" d="M0 0h24v24H0z"></path></g></svg>
                Reader
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Team accounts'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Team accounts', 'text-gray-700': currentPage !== 'Team accounts'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                Team accounts
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Feedback'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Feedback', 'text-gray-700': currentPage !== 'Feedback'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#clip0_8_53)"> <path d="M16 12C15.87 12.0016 15.7409 11.9778 15.62 11.93C15.4971 11.8781 15.3852 11.8035 15.29 11.7101C15.2001 11.6179 15.1287 11.5092 15.08 11.39C15.0296 11.266 15.0025 11.1338 15 11C15.0011 10.7376 15.1053 10.4863 15.29 10.3C15.3825 10.2033 15.4952 10.1282 15.62 10.0801C15.8031 10.0047 16.0044 9.98535 16.1984 10.0245C16.3924 10.0637 16.5705 10.1596 16.71 10.3C16.8947 10.4863 16.9989 10.7376 17 11C16.9975 11.1338 16.9704 11.266 16.92 11.39C16.8713 11.5092 16.7999 11.6179 16.71 11.7101C16.6166 11.8027 16.5057 11.876 16.3839 11.9258C16.2621 11.9755 16.1316 12.0007 16 12Z" fill="#000000"></path> <path d="M12 12C11.87 12.0016 11.7409 11.9778 11.62 11.93C11.4971 11.8781 11.3852 11.8035 11.29 11.7101C11.2001 11.6179 11.1287 11.5092 11.08 11.39C11.0296 11.266 11.0025 11.1338 11 11C11.0011 10.7376 11.1053 10.4863 11.29 10.3C11.3825 10.2033 11.4952 10.1282 11.62 10.0801C11.8031 10.0047 12.0044 9.98535 12.1984 10.0245C12.3924 10.0637 12.5705 10.1596 12.71 10.3C12.8947 10.4863 12.9989 10.7376 13 11C12.9975 11.1338 12.9704 11.266 12.92 11.39C12.8713 11.5092 12.7999 11.6179 12.71 11.7101C12.6166 11.8027 12.5057 11.876 12.3839 11.9258C12.2621 11.9755 12.1316 12.0007 12 12Z" fill="#000000"></path> <path d="M8 12C7.86999 12.0016 7.74091 11.9778 7.62 11.93C7.49713 11.8781 7.38519 11.8035 7.29001 11.7101C7.20006 11.6179 7.12873 11.5092 7.07999 11.39C7.0296 11.266 7.0025 11.1338 7 11C7.0011 10.7376 7.10526 10.4863 7.29001 10.3C7.3825 10.2033 7.49516 10.1282 7.62 10.0801C7.80305 10.0047 8.00435 9.98535 8.19839 10.0245C8.39244 10.0637 8.57048 10.1596 8.70999 10.3C8.89474 10.4863 8.9989 10.7376 9 11C8.9975 11.1338 8.9704 11.266 8.92001 11.39C8.87127 11.5092 8.79994 11.6179 8.70999 11.7101C8.61655 11.8027 8.50575 11.876 8.38391 11.9258C8.26207 11.9755 8.13161 12.0007 8 12Z" fill="#000000"></path> </g> <path d="M4.99951 16.55V19.9C4.99922 20.3102 5.11905 20.7114 5.34418 21.0542C5.56931 21.397 5.88994 21.6665 6.26642 21.8292C6.6429 21.9919 7.05875 22.0408 7.46271 21.9698C7.86666 21.8989 8.24103 21.7113 8.53955 21.4301L11.1495 18.9701H12.0195C17.5395 18.9701 22.0195 15.1701 22.0195 10.4701C22.0195 5.77009 17.5395 1.97009 12.0195 1.97009C6.49953 1.97009 2.01953 5.78009 2.01953 10.4701C2.042 11.6389 2.32261 12.7882 2.84125 13.8358C3.35989 14.8835 4.10373 15.8035 5.01953 16.53L4.99951 16.55Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <defs> <clipPath id="clip0_8_53"> <rect width="10" height="2" fill="white" transform="translate(7 10)"></rect> </clipPath> </defs> </g></svg>
                Feedback
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Link status'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Link status', 'text-gray-700': currentPage !== 'Link status'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>link-slash</title> <path d="M11.94 22.59c-0.899 0.899-2.141 1.455-3.512 1.455-2.743 0-4.967-2.224-4.967-4.967 0-1.371 0.556-2.613 1.454-3.512l3.036-3.036c0.131-0.135 0.212-0.319 0.212-0.523 0-0.414-0.336-0.75-0.75-0.75-0.203 0-0.388 0.081-0.523 0.212l0-0-3.036 3.036c-1.169 1.17-1.891 2.786-1.891 4.57 0 3.572 2.895 6.467 6.467 6.467 1.784 0 3.4-0.723 4.57-1.891l-0 0c0.137-0.136 0.222-0.325 0.222-0.533 0-0.415-0.336-0.751-0.751-0.751-0.208 0-0.396 0.085-0.532 0.221l-0 0zM18.143 22.482c-2.192-0.437-3.845-2.271-4.003-4.518l-0.001-0.016c-0.029-0.39-0.353-0.695-0.748-0.695-0.414 0-0.75 0.336-0.75 0.75 0 0.017 0.001 0.033 0.002 0.049l-0-0.002c0.205 2.947 2.36 5.337 5.174 5.897l0.041 0.007c0.042 0.009 0.090 0.014 0.14 0.014 0.001 0 0.002 0 0.003 0h-0c0 0 0 0 0 0 0.414 0 0.75-0.336 0.75-0.75 0-0.364-0.259-0.667-0.603-0.736l-0.005-0.001zM30.531 29.469l-7.1-7.1c0.074-0.067 0.157-0.118 0.229-0.189l4.488-4.488c1.169-1.17 1.893-2.785 1.893-4.57 0-3.569-2.894-6.463-6.463-6.463-1.785 0-3.401 0.724-4.57 1.893v0c-0.136 0.136-0.219 0.323-0.219 0.53 0 0.415 0.336 0.751 0.751 0.751 0.208 0 0.395-0.084 0.531-0.22v0c0.91-0.87 2.146-1.406 3.508-1.406s2.598 0.536 3.51 1.408l-0.002-0.002c0.897 0.899 1.452 2.139 1.452 3.509s-0.555 2.611-1.452 3.509l-4.488 4.488c-0.071 0.071-0.153 0.123-0.227 0.189l-3.738-3.738c0.47-0.871 0.746-1.907 0.746-3.007 0-3.553-2.881-6.434-6.434-6.434-1.1 0-2.136 0.276-3.042 0.763l0.034-0.017-7.406-7.406c-0.135-0.131-0.32-0.212-0.523-0.212-0.414 0-0.75 0.336-0.75 0.75 0 0.203 0.081 0.388 0.213 0.523l27.999 28.001c0.136 0.136 0.324 0.22 0.531 0.22 0.415 0 0.751-0.336 0.751-0.751 0-0.207-0.084-0.395-0.22-0.531v0zM16.433 11.074c0.894 0.901 1.447 2.142 1.447 3.513 0 0.673-0.133 1.315-0.375 1.901l0.012-0.033-2.126-2.126c0.066-0.075 0.119-0.157 0.191-0.229 0.13-0.135 0.211-0.319 0.211-0.521 0-0.414-0.336-0.75-0.75-0.75-0.204 0-0.388 0.081-0.524 0.213l0-0c-0.071 0.071-0.122 0.154-0.189 0.227l-3.278-3.277c0.553-0.23 1.195-0.363 1.868-0.363 1.37 0 2.611 0.553 3.513 1.447l-0-0z"></path> </g></svg>
                Link status
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Page not found'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Page not found', 'text-gray-700': currentPage !== 'Page not found'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Page not found
            </a>
            
            <a href="#" 
               @click.prevent="currentPage = 'Ticket deflector'"
               :class="{'bg-gray-200 text-gray-900': currentPage === 'Ticket deflector', 'text-gray-700': currentPage !== 'Ticket deflector'}" 
               class="flex items-center p-3 text-sm font-medium rounded-lg hover:bg-gray-200 transition duration-150">
                <svg class="w-5 h-5 mr-3" fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>ticket</title> <path d="M22.996 11.25h-13.996c-0.414 0-0.75 0.336-0.75 0.75v0 7.605c0 0.414 0.336 0.75 0.75 0.75h13.996c0.414-0 0.75-0.336 0.75-0.75v0-7.605c-0-0.414-0.336-0.75-0.75-0.75v0zM22.246 18.855h-12.496v-6.105h12.496zM30 13.75c0.414-0 0.75-0.336 0.75-0.75v0-5c-0-0.414-0.336-0.75-0.75-0.75h-28c-0.414 0-0.75 0.336-0.75 0.75v0 5c0 0.414 0.336 0.75 0.75 0.75v0c1.243 0 2.25 1.007 2.25 2.25s-1.007 2.25-2.25 2.25v0c-0.414 0-0.75 0.336-0.75 0.75v0 5c0 0.414 0.336 0.75 0.75 0.75h28c0.414-0 0.75-0.336 0.75-0.75v0-5c-0-0.414-0.336-0.75-0.75-0.75v0c-1.243 0-2.25-1.007-2.25-2.25s1.007-2.25 2.25-2.25v0zM29.25 19.674v3.576h-26.5v-3.576c1.724-0.361 3-1.869 3-3.674s-1.276-3.313-2.975-3.67l-0.024-0.004v-3.576h26.5v3.576c-1.724 0.361-3 1.869-3 3.674s1.276 3.313 2.975 3.67l0.024 0.004z"></path> </g></svg>
                Ticket deflector
            </a>
            
        </nav>

        <div class="p-4 my-45 border-r border-gray-200 rounded-[10px] text-sm text-gray-500 bg-gray-100">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                All data in analytics are <br> displayed based on UTC time<br> zone
            </div>
        </div>
     </div> 
    
                        <!-- Main content -->

        <main class="flex-1 overflow-auto p-6">
                       <!-- Articles -->
           <div x-show="currentPage === 'Articles'" class="w-full">
            <div class="flex justify-between items-center pb-2">
                <div class="flex items-center text-xl font-semibold text-gray-900">
                    Articles 
                    <button class="flex ml-2 text-gray-400 hover:text-gray-600">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" /></svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-end items-center space-x-4 pt-4 mb-6">
                <select class="p-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Knowledge base</option>
                    <option>Option 2</option>
                </select>
                <select class="p-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option>All users</option>
                    <option>User A</option>
                </select>
                <select class="p-2 border border-gray-300 rounded-lg text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Date: Last week</option>
                    <option>Last 30 days</option>
                </select>
                <button class="flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">
                    <svg class="w-4 h-4 mr-2" fill="#000000" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style> .cls-1 { fill: none; } </style> </defs> <title>document--pdf</title> <polygon points="30 18 30 16 24 16 24 26 26 26 26 22 29 22 29 20 26 20 26 18 30 18"></polygon> <path d="M19,26H15V16h4a3.0033,3.0033,0,0,1,3,3v4A3.0033,3.0033,0,0,1,19,26Zm-2-2h2a1.0011,1.0011,0,0,0,1-1V19a1.0011,1.0011,0,0,0-1-1H17Z"></path> <path d="M11,16H6V26H8V23h3a2.0027,2.0027,0,0,0,2-2V18A2.0023,2.0023,0,0,0,11,16ZM8,21V18h3l.001,3Z"></path> <path d="M22,14V10a.9092.9092,0,0,0-.3-.7l-7-7A.9087.9087,0,0,0,14,2H4A2.0059,2.0059,0,0,0,2,4V28a2,2,0,0,0,2,2H20V28H4V4h8v6a2.0059,2.0059,0,0,0,2,2h6v2Zm-8-4V4.4L19.6,10Z"></path> <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"></rect> </g></svg>
                    Export PDF
                </button>
            </div>

            <div class="grid grid-cols-5 gap-6 mb-8">
                <div class="border-1 border-gray-200 p-6 rounded-lg flex flex-col items-center">
                    <div class="w-12 h-12 mb-2 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2a1 1 0 000 2h8a1 1 0 000-2H6zm0 4a1 1 0 000 2h8a1 1 0 000-2H6zm0 4a1 1 0 000 2h8a1 1 0 000-2H6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Total articles</p>
                    <p class="text-3xl font-bold text-gray-900">100</p>
                </div>
                <div class="border-1 border-gray-200 p-6 rounded-lg flex flex-col items-center ">
                    <div class="w-12 h-12 mb-2 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Total views</p>
                    <p class="text-3xl font-bold text-gray-900">500</p>
                </div>
                <div class="border-1 border-gray-200 p-6 rounded-lg  flex flex-col items-center ">
                    <div class="w-12 h-12 mb-2 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="48" fill="#F4E0C0"/>
                        <g fill="#9E7C4F"> 
                            <rect x="45" y="30" width="16" height="14" rx="5"/> 
                            <rect x="31" y="45" width="20" height="30" rx="5"/> 
                            <rect x="55" y="45" width="20" height="30" rx="5"/> 
                        </g>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">Total reads</p>
                    <p class="text-3xl font-bold text-gray-900">450</p>
                </div>
                <div class="border-1 border-gray-200 p-6 rounded-lg  flex flex-col items-center ">
                    <div class="w-12 h-12 mb-2 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="#047c18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" stroke="#047c18"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M10.5,21h-5C4.7,21,4,21.7,4,22.5v23C4,46.3,4.7,47,5.5,47H8c2.2,0,4-1.8,4-4V22.5C12,21.7,11.3,21,10.5,21 z"></path> <path d="M44,22h-6c-2.2,0-4-1.8-4-4V8c0-2.2-1.8-4-4-4h-2.5C26.7,4,26,4.7,26,5.5v6c0,5.3-3.7,10.5-8.5,10.5 c-0.8,0-1.5,0.7-1.5,1.5v20c0,0.8,0.6,1.5,1.4,1.5c6.8,0.3,9.1,3,16.2,3c7.5,0,14.4-0.8,14.4-9.5v-5V26C48,23.8,46.2,22,44,22z"></path> </g> </g></svg>
                    </div>
                    <p class="text-sm text-gray-500">Total likes</p>
                    <p class="text-3xl font-bold text-gray-900">200</p>
                </div>
                <div class="border-1 border-gray-200 p-6 rounded-lg  flex flex-col items-center ">
                    <div class="w-12 h-12 mb-2 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="#c70000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve" transform="rotate(0)matrix(1, 0, 0, -1, 0, 0)" stroke="#c70000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M10.5,21h-5C4.7,21,4,21.7,4,22.5v23C4,46.3,4.7,47,5.5,47H8c2.2,0,4-1.8,4-4V22.5C12,21.7,11.3,21,10.5,21 z"></path> <path d="M44,22h-6c-2.2,0-4-1.8-4-4V8c0-2.2-1.8-4-4-4h-2.5C26.7,4,26,4.7,26,5.5v6c0,5.3-3.7,10.5-8.5,10.5 c-0.8,0-1.5,0.7-1.5,1.5v20c0,0.8,0.6,1.5,1.4,1.5c6.8,0.3,9.1,3,16.2,3c7.5,0,14.4-0.8,14.4-9.5v-5V26C48,23.8,46.2,22,44,22z"></path> </g> </g></svg>
                    </div>
                    <p class="text-sm text-gray-500">Total dislikes</p>
                    <p class="text-3xl font-bold text-gray-900">50</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 ">
                <div class="md:col-span-2 p-6 rounded-lg border-1 border-gray-200 ">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Article performance</h3>
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    </div>
                    
                    <div class="chart-container">
                        <canvas id="performanceChart"></canvas>
                    </div>

                    <div class="mt-4 flex justify-center space-x-4 text-sm">
                        <span class="flex items-center">
                            <input type="checkbox" checked class="h-4 w-4 text-gray-600 border-gray-300 rounded focus:ring-gray-500">
                            <span class="ml-1 text-gray-700">All</span>
                        </span>
                        <span class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-1 rounded-full bg-purple-600"></span>
                            <span class="text-gray-700">Views</span>
                        </span>
                        <span class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-1 rounded-full bg-orange-500"></span>
                            <span class="text-gray-700">Reads</span>
                        </span>
                        <span class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-1 rounded-full bg-green-500"></span>
                            <span class="text-gray-700">Likes</span>
                        </span>
                        <span class="flex items-center">
                            <span class="inline-block w-2 h-2 mr-1 rounded-full bg-red-500"></span>
                            <span class="text-gray-700">Dislikes</span>
                        </span>
                    </div>
                </div>

                <div class="md:col-span-1 p-6 rounded-lg border-1 border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Most read articles</h3>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>

                    </div>
                <div class="flex justify-between text-sm font-medium text-gray-500 border-b pb-2">
                    <span>Article name</span>
                    <span>Duration</span>
                </div>

                <div class="mt-5">
                    <div class="flex justify-between text-sm text-gray-800">
                        <span>Why did we build Document ...</span>
                        <span class="font-bold">20 hrs</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full mt-3">
                        <div class="h-2 bg-purple-600 rounded-full" style="width: 100%;"></div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="flex justify-between text-sm text-gray-800">
                        <span>5 basic things to get started</span>
                        <span class="font-bold">15 hrs</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full mt-3">
                        <div class="h-2 bg-purple-600 rounded-full" style="width: 75%;"></div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="flex justify-between text-sm text-gray-800">
                        <span>Understanding drive</span>
                        <span class="font-bold">10 hrs</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full mt-3">
                        <div class="h-2 bg-purple-600 rounded-full" style="width: 50%;"></div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="flex justify-between text-sm text-gray-800">
                        <span>Understanding analytics</span>
                        <span class="font-bold">5 hrs</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full mt-3">
                        <div class="h-2 bg-purple-600 rounded-full" style="width: 25%;"></div>
                    </div>
                </div>
                 <div class="mt-5">
                    <div class="flex justify-between text-sm text-gray-800">
                        <span>Understanding glossary</span>
                        <span class="font-bold">2 hrs</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full mt-3">
                        <div class="h-2 bg-purple-600 rounded-full" style="width: 10%;"></div>
                    </div>
                </div>
            </div>
            </div>
            
            <div class="p-6 rounded-lg mb-8 border-1 border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Top articles</h3>
                    <a href="#" class="text-sm text-indigo-600 font-medium hover:text-indigo-800">View all</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Article Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contributors
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Views
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reads
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Likes
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dislikes
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Feedback
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-600">
                                    Why did we build Document 360?
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">20</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-600">
                                    5 best things to get started
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-600">
                                    Understanding drive
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">13</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">8</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">3</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-600">
                                    Understanding analytics
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-600">
                                    Understanding-Glossary    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

           <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
        
            <div class="md:col-span-8 border-1 border-gray-200 p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Location based views</h3>
                    <a href="#" class="text-sm text-indigo-600 font-medium hover:text-indigo-800">View all</a>
                </div>
                
                <div class="flex items-start">
                    <div class="w-2/3 h-64 bg-gray-100 rounded-lg relative overflow-hidden flex items-center justify-center p-2">
                        <img src="{{ asset('image/worldmap.png') }}" alt="World Map with top viewing countries highlighted" class="w-full h-full object-contain rounded-lg">
                    </div>
                    
                    <div class="w-1/3 ml-4">
                        <table class="w-full">
                            <thead class="border-b">
                                <tr>
                                    <th class="py-2 text-left text-xs font-medium text-gray-500 uppercase">Country</th>
                                    <th class="py-2 text-right text-xs font-medium text-gray-500 uppercase">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 text-sm text-gray-900">India</td>
                                    <td class="py-2 text-sm text-gray-900 text-right font-bold">200</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-sm text-gray-900">United States of America</td>
                                    <td class="py-2 text-sm text-gray-900 text-right font-bold">100</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-sm text-gray-900">France</td>
                                    <td class="py-2 text-sm text-gray-900 text-right font-bold">75</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-sm text-gray-900">United Kingdom</td>
                                    <td class="py-2 text-sm text-gray-900 text-right font-bold">75</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-sm text-gray-900">China</td>
                                    <td class="py-2 text-sm text-gray-900 text-right font-bold">25</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-sm text-gray-900">Others</td>
                                    <td class="py-2 text-sm text-gray-900 text-right font-bold">25</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="md:col-span-4 border-1 border-gray-200 p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Top categories</h3>
                    <a href="#" class="text-sm text-indigo-600 font-medium hover:text-indigo-800">View all</a>
                </div>

                <div class="flex justify-between text-sm font-medium text-gray-500 border-b pb-2 mb-2">
                    <span>Category</span>
                    <span>Total views</span>
                </div>

                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-800">Drive</span>
                    <span class="text-sm font-semibold text-gray-900">200</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-800">Getting started</span>
                    <span class="text-sm font-semibold text-gray-900">100</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-800">Analytics</span>
                    <span class="text-sm font-semibold text-gray-900">75</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-800">Settings</span>
                    <span class="text-sm font-semibold text-gray-900">25</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-sm text-gray-800">Glossary</span>
                    <span class="text-sm font-semibold text-gray-900">10</span>
                </div>
             </div>
           </div>
        </div>
                         <!-- Eddy AI -->
             <div x-show="currentPage === 'Eddy AI'" class="w-full">
                <h2 class="text-xl font-semibold border-b pb-4 mb-4 text-purple-700">Eddy AI Performance</h2>
                
                <div class="grid grid-cols-5 gap-6 mb-8">
                    <div class="border p-6 rounded-lg text-center bg-purple-50"><p class="text-sm text-gray-500">Total AI Queries</p><p class="text-3xl font-bold">450</p></div>
                    <div class="border p-6 rounded-lg text-center bg-blue-50"><p class="text-sm text-gray-500">Auto-Resolved</p><p class="text-3xl font-bold">380</p></div>
                    <div class="border p-6 rounded-lg text-center bg-red-50"><p class="text-sm text-gray-500">Agent Hand-off</p><p class="text-3xl font-bold">70</p></div>
                    <div class="border p-6 rounded-lg text-center bg-green-50"><p class="text-sm text-gray-500">AI Accuracy</p><p class="text-3xl font-bold">92%</p></div>
                    <div class="border p-6 rounded-lg text-center bg-yellow-50"><p class="text-sm text-gray-500">Avg.
                    Response Time</p><p class="text-3xl font-bold">0.8s</p></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 p-6 border rounded-lg h-80 flex items-center justify-center">Query Volume Trend Chart Placeholder</div>
                    <div class="md:col-span-1 p-6 border rounded-lg">Top Query Intents List Placeholder</div>
                </div>
            </div> 
                              <!-- Search -->
            <div x-show="currentPage === 'Search'" class="w-full">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" x-text="currentPage"></h2>
                <div class="p-6 bg-white border border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Selected Page: <span class="font-semibold text-indigo-600" x-text="currentPage"></span></p>
                    <p class="mt-2 text-sm text-gray-400">या पेजसाठी कंटेंट अजून तयार केलेला नाहीये. ही एक **डेमो पेज** आहे.</p>
                </div>
            </div>
                                <!-- Reader -->
                      <div x-show="currentPage === 'Reader'" class="w-full">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" x-text="currentPage"></h2>
                <div class="p-6 bg-white border border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Selected Page: <span class="font-semibold text-indigo-600" x-text="currentPage"></span></p>
                    <p class="mt-2 text-sm text-gray-400">या पेजसाठी कंटेंट अजून तयार केलेला नाहीये. ही एक **डेमो पेज** आहे.</p>
                </div>
            </div>
                                <!-- Team Account -->
                      <div x-show="currentPage === 'Team accounts'" class="w-full">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" x-text="currentPage"></h2>
                <div class="p-6 bg-white border border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Selected Page: <span class="font-semibold text-indigo-600" x-text="currentPage"></span></p>
                    <p class="mt-2 text-sm text-gray-400">या पेजसाठी कंटेंट अजून तयार केलेला नाहीये. ही एक **डेमो पेज** आहे.</p>
                </div>
            </div>
                                <!-- Feedback -->
                      <div x-show="currentPage === 'Feedback'" class="w-full">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" x-text="currentPage"></h2>
                <div class="p-6 bg-white border border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Selected Page: <span class="font-semibold text-indigo-600" x-text="currentPage"></span></p>
                    <p class="mt-2 text-sm text-gray-400">या पेजसाठी कंटेंट अजून तयार केलेला नाहीये. ही एक **डेमो पेज** आहे.</p>
                </div>
            </div>
                                <!-- Link Status -->
                      <div x-show="currentPage === 'Link status'" class="w-full">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" x-text="currentPage"></h2>
                <div class="p-6 bg-white border border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Selected Page: <span class="font-semibold text-indigo-600" x-text="currentPage"></span></p>
                    <p class="mt-2 text-sm text-gray-400">test</p>
                </div>
            </div>
                                    <!-- Page Not Found -->
                      <div x-show="currentPage === 'Page not found'" class="w-full">
                <h2 class="text-2xl font-bold text-gray-900 mb-4" x-text="currentPage"></h2>
                <div class="p-6 bg-white border border-dashed border-gray-300 rounded-lg">
                    <p class="text-gray-500">Selected Page: <span class="font-semibold text-indigo-600" x-text="currentPage"></span></p>
                    <p class="mt-2 text-sm text-gray-400">या पेजसाठी कंटेंट अजून तयार केलेला नाहीये. ही एक **डेमो पेज** आहे.</p>
                </div>
            </div>
                                     <!-- Ticket Deflector -->
                      <div x-show="currentPage === 'Ticket deflector'" class="w-full">
                         <span>test</span>
                </div>
            </div>

        </main></div>
        
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('performanceChart').getContext('2d');

            const data = {
                labels: ['10/10', '10/11', '10/12', '10/13', '10/14', '10/15', '10/16'],
                datasets: [
                    {
                        label: 'Reads',
                        data: [0, 0, 0.05, 0.4, 1.0, 0.4, 0.05], 
                        borderColor: '#f97316', 
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        tension: 0.4, 
                        fill: false,
                    },
                    
                    {
                        label: 'Views',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        borderColor: '#8b5cf6', 
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        tension: 0.4,
                        fill: false,
                    },
                    {
                        label: 'Likes',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        borderColor: '#10b981', 
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        tension: 0.4,
                        fill: false,
                    },
                    {
                        label: 'Dislikes',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        borderColor: '#ef4444', 
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        tension: 0.4,
                        fill: false,
                    }
                ]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false 
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 1.2,
                            ticks: {
                                stepSize: 0.2,
                                color: '#6b7280', 
                            },
                            grid: {
                                color: '#e5e7eb', 
                                drawBorder: false,
                            },
                        },
                        x: {
                            ticks: {
                                color: '#6b7280', 
                            },
                            grid: {
                                display: false,
                                drawBorder: true,
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
@endsection
