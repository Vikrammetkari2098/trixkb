<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-lg">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="mx-auto w-fit bg-gradient-to-r from-[#09325d] to-[#0f4a7a] p-6 rounded-2xl shadow-lg mb-6">
                <img src="{{ asset('media/logo_trixcrm.png') }}" alt="TRIXCRM" class="h-16 w-auto" />
            </div>
            <div class="mb-4">
                <p class="text-lg text-gray-600 font-medium">Project Management System</p>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Join our platform</h2>
            <p class="mt-2 text-gray-600">Create your account and start managing projects efficiently</p>
        </div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-lg">
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

            <form wire:submit.prevent='register' class="space-y-6">
                @csrf
                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="label-text font-semibold text-gray-700" for="first_name">First name</label>
                        <div class="input mt-2">
                            <span class="icon-[tabler--user] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                            <input
                                type="text"
                                wire:model.defer="first_name"
                                id="first_name"
                                required
                                autocomplete="given-name"
                                placeholder="John"
                                class="grow focus:ring-2 focus:ring-[#09325d] focus:border-[#09325d] transition-all duration-200"
                            />
                        </div>
                        @error('first_name')
                            <span class="helper-text text-red-600 flex items-center mt-2">
                                <span class="icon-[tabler--alert-circle] w-4 h-4 mr-1"></span>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="label-text font-semibold text-gray-700" for="last_name">Last name</label>
                        <div class="input mt-2">
                            <span class="icon-[tabler--user] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                            <input
                                type="text"
                                wire:model.defer="last_name"
                                id="last_name"
                                required
                                autocomplete="family-name"
                                placeholder="Doe"
                                class="grow focus:ring-2 focus:ring-[#09325d] focus:border-[#09325d] transition-all duration-200"
                            />
                        </div>
                        @error('last_name')
                            <span class="helper-text text-red-600 flex items-center mt-2">
                                <span class="icon-[tabler--alert-circle] w-4 h-4 mr-1"></span>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Email Field -->
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

                <!-- Password Field -->
                <div>
                    <label class="label-text font-semibold text-gray-700" for="password">Password</label>
                    <div class="input mt-2">
                        <span class="icon-[tabler--lock] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                        <input
                            type="password"
                            wire:model.defer="password"
                            id="password"
                            required
                            autocomplete="new-password"
                            placeholder="Create a strong password"
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

                <!-- Role Field -->
                <div>
                    <label class="label-text font-semibold text-gray-700" for="role">Role</label>
                    <div class="input mt-2">
                        <span class="icon-[tabler--briefcase] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                        <select
                            wire:model.defer="role"
                            id="role"
                            required
                            class="grow focus:ring-2 focus:ring-[#09325d] focus:border-[#09325d] transition-all duration-200 appearance-none bg-transparent"
                        >
                            <option value="">Select your role...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ str_replace('_', ' ', ucwords($role->name, '_')) }}</option>
                            @endforeach
                        </select>
                        <span class="icon-[tabler--chevron-down] text-gray-400 my-auto ms-3 size-5 shrink-0"></span>
                    </div>
                    @error('role')
                        <span class="helper-text text-red-600 flex items-center mt-2">
                            <span class="icon-[tabler--alert-circle] w-4 h-4 mr-1"></span>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        required
                        class="h-4 w-4 text-[#09325d] focus:ring-[#09325d] border-gray-300 rounded"
                    />
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        I agree to the
                        <a href="#" class="text-[#09325d] hover:text-[#0f4a7a] font-semibold">Terms of Service</a>
                        and
                        <a href="#" class="text-[#09325d] hover:text-[#0f4a7a] font-semibold">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-primary w-full py-3 bg-gradient-to-r from-[#09325d] to-[#0f4a7a] hover:from-[#0f4a7a] hover:to-[#09325d] border-none text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span class="icon-[tabler--user-plus] w-5 h-5 mr-2"></span>
                        Create your account
                    </button>
                </div>
            </form>

            <!-- Sign In Link -->
            <div class="mt-8 text-center">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Already have an account?</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2 border border-[#09325d] text-sm font-semibold rounded-xl text-[#09325d] bg-white hover:bg-[#09325d] hover:text-white transition-all duration-200">
                        <span class="icon-[tabler--login] w-4 h-4 mr-2"></span>
                        Sign in to your account
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
