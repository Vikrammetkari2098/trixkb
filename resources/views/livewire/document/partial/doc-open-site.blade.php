<div x-data="{ mobileMenuOpen: false }">
    
    <header class="shadow-sm bg-white">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 text-2xl font-bold text-purple-600">DOCUMENT360</div>
                
                <nav class="hidden md:flex space-x-8 items-center text-sm font-medium">
                    <a href="#" class="text-gray-600 hover:text-primary">Features</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Pricing</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Book a demo</a>
                    <a href="#" class="text-white bg-primary py-2 px-4 rounded-md shadow-lg hover:bg-opacity-90 transition">Sign up</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Glossary</a>
                    <button class="text-gray-600 hover:text-primary"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM12 18a2 2 0 11-4 0h4z"></path></svg></button>
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-semibold text-xs">JW</div>
                </nav>
                
                <button @click="mobileMenuOpen = true" class="md:hidden text-gray-600 hover:text-primary p-2 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden border-t border-gray-100 py-2">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Features</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pricing</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Book a demo</a>
            <a href="#" class="block mx-4 my-2 text-center text-white bg-primary py-2 px-4 rounded-md shadow-lg">Sign up</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Glossary</a>
        </div>
    </header>

    <section class="text-center py-16 sm:py-24" style="background-image: linear-gradient(135deg, #A74E91 0%, #6A329D 100%);">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-4 whitespace-nowrap">
                Welcome to Project project landing page
            </h1>
            <p class="mt-4 text-sm text-white">
                Comprehensive documentation to help your users get started with Project project.
            </p>
            <div class="mt-8">
                <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white bg-purple">
                    Documentation
                </a>
            </div>

            <div class="mt-12 mx-auto" x-data="{ search: '' }">
                <div class="max-w-xl mx-auto relative flex items-center bg-white border border-gray-300 rounded-md shadow-sm overflow-hidden focus-within:border-primary transition">
                    <span class="pl-4 text-gray-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </span>
                    <input type="search" placeholder="Search" x-model="search" class="w-full py-3 pl-2 pr-2 text-lg text-gray-800 focus:outline-none" aria-label="Search documentation">
                    <div class="bg-white text-gray-900 text-xs font-mono py-1 px-2 mr-2 rounded whitespace-nowrap border border-gray-300">
                        CTRL + K
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-20 bg-white">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Modules</h2>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6">
                    <div class="inline-block p-4 bg-secondary rounded-xl">
                        <svg class="w-10 h-10 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 0 100-2H10zm3 0a1 1 0 000 2h.01a1 1 0 100-2H13zM7 13a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 0 100-2H10zm3 0a1 1 0 000 2h.01a1 1 0 100-2H13z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Documentation</h3>
                    <p class="mt-2 text-gray-500 text-sm">
                        Create and manage knowledge base articles with powerful out-of-the-box features.
                    </p>
                </div>

                <div class="p-6">
                    <div class="inline-block p-4 bg-secondary rounded-xl">
                        <svg class="w-10 h-10 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7z"></path><path fill-rule="evenodd" d="M11 6a1 1 0 011 1v1l.786.643a1 1 0 01.35 1.118l-1.35 3.15a1 1 0 01-1.892.203l-1.074-2.148a1 1 0 00-.918-.592H7a1 1 0 01-1-1V7a1 1 0 011-1h4zM4 14v1a1 1 0 001 1h10a1 1 0 001-1v-1H4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Category Manager</h3>
                    <p class="mt-2 text-gray-500 text-sm">
                        Maintain your documentation effectively in a clean hierarchy based structure.
                    </p>
                </div>

                <div class="p-6">
                    <div class="inline-block p-4 bg-secondary rounded-xl">
                        <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9 5a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Editor</h3>
                    <p class="mt-2 text-gray-500 text-sm">
                        Handpicked features that will shift your writers' focus towards content than or formatting.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-black relative py-16" style="background-image: linear-gradient(158deg, #4a058bff 25%, #b56df8ff 35%, #6a1eb1ff 30%);">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl font-bold tracking-tight text-white">
                Discover how can we help your Business
            </h2>
            <p class="mt-3 text-xl text-indigo-100">
                30 days trial. Simple and Easy Setup.
            </p>
            <div class="mt-8 flex justify-center space-x-4">
                <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-primary transition">
                    BOOK A DEMO
                </a>
                <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-primary transition">
                    FREE TRIAL
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-20 bg-white">
        <div class=" mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Quick Links</h2>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-secondary p-8 rounded-lg shadow-md">
                    <div class="inline-block p-4 bg-white rounded-full">
                        <svg class="w-10 h-10 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.722-1.304l-2.072.345a1 1 0 00-1.15 1.15l-.345 2.072A18.841 18.841 0 0010 20c4.418 0 8-3.134 8-7V7z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Chat with us</h3>
                    <p class="mt-2 text-gray-500">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                    </p>
                </div>

                <div class="bg-secondary p-8 rounded-lg shadow-md">
                    <div class="inline-block p-4 bg-white rounded-full">
                        <svg class="w-10 h-10 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Email</h3>
                    <p class="mt-2 text-gray-500">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                    </p>
                </div>

                <div class="bg-secondary p-8 rounded-lg shadow-md">
                    <div class="inline-block p-4 bg-white rounded-full">
                        <svg class="w-10 h-10 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 3.697a1 1 0 01-.292.922l-1.42 1.42a8.7 8.7 0 005.106 5.106l1.42-1.42a1 1 0 01.922-.292l3.697.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2.153a1 1 0 01-.986-.836l-.74-3.697a1 1 0 01.292-.922l1.42-1.42a8.7 8.7 0 00-5.106-5.106l-1.42 1.42a1 1 0 01-.922.292l-3.697-.74A1 1 0 013 4.847V3z"></path></svg>
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Telephone</h3>
                    <p class="mt-2 text-gray-500">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 pt-10">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-8 text-sm">
                
                <div class="col-span-2 md:col-span-1">
                    <a href="#" class="text-xl font-semibold text-gray-800 mb-3 block">
                        <span class="text-purple-700 font-bold">DOCUMENT360</span> 
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed pr-8">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 uppercase">Products</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Business</a></li>
                        <li><a href="#" class="hover:text-blue-600">Compare</a></li>
                        <li><a href="#" class="hover:text-blue-600">Features</a></li>
                        <li><a href="#" class="hover:text-blue-600">Pricing</a></li>
                        <li><a href="#" class="hover:text-blue-600">Mobile</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 uppercase">Company</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">About Us</a></li>
                        <li><a href="#" class="hover:text-blue-600">Blog</a></li>
                        <li><a href="#" class="hover:text-blue-600">Customers</a></li>
                        <li><a href="#" class="hover:text-blue-600">Careers</a></li>
                        <li><a href="#" class="hover:text-blue-600">Newsroom</a></li>
                        <li><a href="#" class="hover:text-blue-600">Contact Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 uppercase">Top Features</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="#" class="hover:text-blue-600">Ticketing</a></li> <li><a href="#" class="hover:text-blue-600">Collaboration</a></li>
                        <li><a href="#" class="hover:text-blue-600">Automations</a></li>
                        <li><a href="#" class="hover:text-blue-600">Self Service</a></li>
                        <li><a href="#" class="hover:text-blue-600">Reporting & Analytics</a></li>
                        <li><a href="#" class="hover:text-blue-600">Customizations</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 uppercase">Solutions</h4>
                    <ul class="space-y-3 text-gray-600 mb-8">
                        <li><a href="#" class="hover:text-blue-600">Enterprise</a></li>
                        <li><a href="#" class="hover:text-blue-600">SMB</a></li>
                        <li><a href="#" class="hover:text-blue-600">E-commerce</a></li>
                        <li><a href="#" class="hover:text-blue-600">Healthcare</a></li>
                        <li><a href="#" class="hover:text-blue-600">Education</a></li>
                    </ul>
                </div>

                <div >
                    <h4 class="font-semibold text-gray-800 mb-4 uppercase">Existing Users</h4>
                    <button class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition duration-150 shadow-sm">
                        LOGIN
                    </button>
                    <div class="mt-6 md:mt-10 items-center">
                    <h4 class="font-semibold text-gray-800 uppercase text-xs mb-4">Connect with us</h4>
                    <div class="flex space-x-3 text-gray-400">
                        <a href="#" class="hover:text-blue-600" aria-label="Facebook"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.58 0 0 .58 0 1.294v21.412C0 23.42 0.58 24 1.325 24h11.28v-9.3H9.4v-3.665h3.205V8.14c0-3.178 1.943-4.918 4.773-4.918 1.365 0 2.53.1 2.87.147v3.19l-1.88.001c-1.54 0-1.84.734-1.84 1.82v2.39h3.69l-.6 3.665h-3.09V24h6.035c.745 0 1.32-.58 1.32-1.294V1.294C24 .58 23.42 0 22.675 0z"/></svg></a>
                        <a href="#" class="hover:text-blue-600" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="hover:text-blue-600" aria-label="LinkedIn"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.58 0 0 .58 0 1.294v21.412C0 23.42 0.58 24 1.325 24h21.35C23.42 24 24 23.42 24 22.706V1.294C24 .58 23.42 0 22.675 0zM7.325 20.706H3.39V9.75h3.935v10.956zM5.357 8.14c-1.354 0-2.285-.92-2.285-2.052 0-1.15.93-2.053 2.285-2.053 1.35 0 2.285.903 2.285 2.053 0 1.132-.935 2.052-2.285 2.052zM20.61 20.706h-3.935v-6.38c0-1.52-.54-2.56-1.933-2.56-1.05 0-1.675.71-1.955 1.42-.1.25-.125.6-.125.96v6.56h-3.935s.05-10.155 0-11.238h3.935v1.734c.54-.836 1.51-2.02 3.48-2.02 2.53 0 4.42 1.628 4.42 5.122v7.362z"/></svg></a>
                        <a href="#" class="hover:text-blue-600" aria-label="YouTube"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.02 3.02 0 00-2.122-2.122C19.954 3.5 12 3.5 12 3.5s-7.954 0-9.376.564a3.02 3.02 0 00-2.122 2.122C.5 7.64 0 12 0 12s.5 4.36 1.122 5.814a3.02 3.02 0 002.122 2.122C4.046 20.5 12 20.5 12 20.5s7.954 0 9.376-.564a3.02 3.02 0 002.122-2.122C23.5 16.36 24 12 24 12s-.5-4.36-1.122-5.814zM9.545 15.535V8.465l6.59 3.535-6.59 3.535z"/></svg></a>
                    </div>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 mb-8 flex flex-col items-end w-full"> 
                
                <div class="flex justify-end w-full">
                    <div class="w-1/2 border-t border-gray-300"></div>
                </div>

                <div class="flex space-x-8 mt-4 text-sm">
                    <h4 class="font-semibold text-gray-800 uppercase text-sm">Sales and Support</h4>
                    
                    <div class="flex space-x-8 justify-end text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.424 5.424l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                            +1 (125) 225-0025
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.84 5.23L19 8m-2 4v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7"></path></svg>
                            support@document360.com
                        </span>
                    </div>
                </div>
            </div>

        </div> 
        <div class="w-full bg-gray-200 py-3 text-xs text-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center px-4 sm:px-6 lg:px-8"> 
                
                <div class="flex flex-wrap space-x-4 mb-2 md:mb-0">
                    <a href="#" class="hover:text-gray-900">Terms of Services</a>
                    <a href="#" class="hover:text-gray-900">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-900">GDPR</a>
                    <a href="#" class="hover:text-gray-900">Site Map</a>
                </div>
                
                <div>
                    Copyright &copy; All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'dark-gray': '#374151', 
                        'custom-purple': '#6842a2', 
                    }
                }
            }
        }
    </script>
    <style>
       
        :root {
            --color-primary: #5267ff; 
            --color-secondary: #f0f4f7; 
            --color-dark: #374151; 
        }
        .bg-primary { background-color: var(--color-primary); }
        .text-primary { color: var(--color-primary); }
        .border-primary { border-color: var(--color-primary); }
        .bg-secondary { background-color: var(--color-secondary); }
        .text-dark-gray { color: var(--color-dark); }
       
        .hero-heading { font-size: 2.5rem; }
        @media (min-width: 640px) {
            .hero-heading { font-size: 3rem; }
        }
    </style>
</div>
