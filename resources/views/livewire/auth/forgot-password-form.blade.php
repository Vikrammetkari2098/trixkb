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
            <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
            @if ($step == 1)
                <p class="mt-2 text-gray-600">Enter your email to receive a verification code</p>
            @else
                <p class="mt-2 text-gray-600">Enter the verification code sent to your email</p>
            @endif
        </div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white shadow-xl rounded-2xl px-8 py-10 border border-gray-100">
            @if ($step == 1)
                <form wire:submit.prevent="sendOtp" class="space-y-6">
                    <div>
                        <label class="label-text font-semibold text-gray-700" for="email">Email address</label>
                        <div class="input mt-2">
                            <span class="icon-[tabler--mail] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                            <input 
                                type="email" 
                                wire:model="email" 
                                id="email"
                                required
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
                        <button type="submit" class="btn btn-primary w-full py-3 bg-gradient-to-r from-[#09325d] to-[#0f4a7a] hover:from-[#0f4a7a] hover:to-[#09325d] border-none text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span class="icon-[tabler--send] w-5 h-5 mr-2"></span>
                            Send Verification Code
                        </button>
                    </div>
                </form>

            @elseif ($step == 2)
                <form wire:submit.prevent="verifyOtp" class="space-y-6">
                    <div>
                        <label class="label-text font-semibold text-gray-700" for="otp">Verification Code</label>
                        <div class="input mt-2">
                            <span class="icon-[tabler--key] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                            <input 
                                type="text" 
                                wire:model="otp" 
                                id="otp"
                                required
                                placeholder="Enter 6-digit code"
                                maxlength="6"
                                class="grow focus:ring-2 focus:ring-[#09325d] focus:border-[#09325d] transition-all duration-200"
                            />
                        </div>
                        @error('otp')
                            <span class="helper-text text-red-600 flex items-center mt-2">
                                <span class="icon-[tabler--alert-circle] w-4 h-4 mr-1"></span>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-full py-3 bg-gradient-to-r from-[#09325d] to-[#0f4a7a] hover:from-[#0f4a7a] hover:to-[#09325d] border-none text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span class="icon-[tabler--check] w-5 h-5 mr-2"></span>
                            Verify Code
                        </button>
                    </div>

                    <div class="text-center">
                        <button type="button" 
                                wire:click="resendOtp" 
                                class="text-sm text-[#09325d] hover:text-[#0f4a7a] font-semibold transition-colors">
                            Didn't receive the code? Resend
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            <span class="icon-[tabler--clock] w-4 h-4 inline mr-1"></span>
                            Code expires in 5 minutes
                        </p>
                    </div>
                </form>
            @endif

            <!-- Back to Login -->
            <div class="mt-8 text-center">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Remember your password?</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2 border border-[#09325d] text-sm font-semibold rounded-xl text-[#09325d] bg-white hover:bg-[#09325d] hover:text-white transition-all duration-200">
                        <span class="icon-[tabler--arrow-left] w-4 h-4 mr-2"></span>
                        Back to Sign In
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
