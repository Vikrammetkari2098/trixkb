<div>
<header class="shadow-sm bg-white">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 text-2xl font-bold text-purple-600">DOCUMENT360</div>
                
                <nav 
                        x-data="{ active: 'articles' }"
                        class="hidden md:flex space-x-2 items-center text-sm font-medium"
                         >
                        <a href="#"
                        @click.prevent="active = 'features'"
                        :class="active === 'features'
                                ? 'bg-gray-200 text-primary px-3 py-1 rounded-md'
                                : 'text-gray-600 hover:text-primary px-3 py-1'"
                        >Features</a>

                        <a href="#"
                        @click.prevent="active = 'pricing'"
                        :class="active === 'pricing'
                                ? 'bg-gray-200 text-primary px-3 py-1 rounded-md'
                                : 'text-gray-600 hover:text-primary px-3 py-1'"
                        >Pricing</a>

                        <a href="#"
                        @click.prevent="active = 'demo'"
                        :class="active === 'demo'
                                ? 'bg-gray-200 text-primary px-3 py-1 rounded-md'
                                : 'text-gray-600 hover:text-primary px-3 py-1'"
                        >Book a demo</a>

                        <a href="#articles"
                        @click="active = 'articles'"
                        :class="active === 'articles'
                                ? 'bg-gray-200 text-primary px-3 py-1 rounded-md'
                                : 'text-gray-600 hover:text-primary px-3 py-1'"
                        >Articles</a>

                        <a href="#"
                        @click.prevent="active = 'signup'"
                        :class="active === 'signup'
                                ? 'bg-gray-200 text-primary px-3 py-1 rounded-md'
                                : 'text-gray-600 hover:text-primary px-3 py-1'"
                        >Sign up</a>

                        <a href="#"
                        @click.prevent="active = 'glossary'"
                        :class="active === 'glossary'
                                ? 'bg-gray-200 text-primary px-3 py-1 rounded-md'
                                : 'text-gray-600 hover:text-primary px-3 py-1'"
                        >Glossary</a>

                        <button class="text-gray-600 hover:text-primary ml-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM12 18a2 2 0 11-4 0h4z"></path>
                            </svg>
                        </button>

                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-semibold text-xs">
                            JW
                        </div>
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
            <a href="#articles" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Articles</a>
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

</div> 