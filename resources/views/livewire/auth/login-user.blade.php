<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="mx-auto w-fit bg-gradient-to-r from-[#09325d] to-[#0f4a7a] p-6 rounded-2xl shadow-lg mb-6">
                <img src="{{ asset('media/logo_trixcrm.png') }}" alt="TRIXCRM" class="h-16 w-auto" />
            </div>
            <div class="mb-4">
                <p class="text-lg text-gray-600 font-medium">Project Management System</p>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Welcome back</h2>
            <p class="mt-2 text-gray-600">Sign in to your account to continue</p>
        </div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white shadow-xl rounded-2xl px-8 py-10 border border-gray-100">
            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4">
                    <div class="flex items-center">
                        <span class="icon-[tabler--check-circle] text-emerald-500 w-5 h-5 mr-3"></span>
                        <div class="text-sm font-medium text-emerald-800">{{ session('success') }}</div>
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
                    <div class="flex items-center">
                        <span class="icon-[tabler--alert-circle] text-red-500 w-5 h-5 mr-3"></span>
                        <div class="text-sm font-medium text-red-800">{{ session('error') }}</div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent='login' class="space-y-6">
                <div>
                    <label class="label-text font-semibold text-gray-700" for="email">Email address</label>
                    <div class="input mt-2">
                        <span class="icon-[tabler--mail] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                        <input
                            type="email"
                            wire:model.defer="email"
                            id="email"
                            required
                            autocomplete="email"
                            placeholder="johndoe@gmail.com"
                            class="grow focus:ring-2 focus:ring-[#09325d] focus:border-[#09325d] transition-all duration-200"
                        />
                    </div>
                    @error('email')
                        <span class="helper-text text-red-600 flex items-center mt-2">
                            <span class="icon-[tabler--alert-circle] w-4 h-4 mr-1"></span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label class="label-text font-semibold text-gray-700" for="password">Password</label>
                    <div class="input mt-2">
                        <span class="icon-[tabler--lock] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                        <input
                            type="password"
                            wire:model.defer="password"
                            id="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="grow focus:ring-2 focus:ring-[#09325d] focus:border-[#09325d] transition-all duration-200"
                        />
                    </div>
                    @error('password')
                        <span class="helper-text text-red-600 flex items-center mt-2">
                            <span class="icon-[tabler--alert-circle] w-4 h-4 mr-1"></span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-[#09325d] focus:ring-[#09325d] border-gray-300 rounded"
                        />
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-semibold text-[#09325d] hover:text-[#0f4a7a] transition-colors">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-full py-3 bg-gradient-to-r from-[#09325d] to-[#0f4a7a] hover:from-[#0f4a7a] hover:to-[#09325d] border-none text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span class="icon-[tabler--login] w-5 h-5 mr-2"></span>
                        Sign in to your account
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">New to our platform?</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-2 border border-[#09325d] text-sm font-semibold rounded-xl text-[#09325d] bg-white hover:bg-[#09325d] hover:text-white transition-all duration-200">
                        <span class="icon-[tabler--user-plus] w-4 h-4 mr-2"></span>
                        Create an account
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} TRIXCRM. Streamline your project management.
            </p>
        </div>
    </div>
</div>
