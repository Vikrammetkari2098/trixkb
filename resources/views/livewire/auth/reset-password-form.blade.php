<div>
    <form wire:submit.prevent="resetPassword">

        <div class="row mb-1">
            <div class="col px-5">
                <p class="fw-semibold mb-1" style="color: rgb(0,0,0);font-size: 14px;">New Password</p>
                <input wire:model.defer="password" id="password" type="password"
                    style="border: 1px solid rgba(0,0,0,0.22);border-radius: 5px;font-size: 14px;width: 100%;"
                    class="ps-2 pe-2 py-1" placeholder="Enter new password">
                @error('password') <span class="text-danger" style="font-size: 14px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col px-5">
                <p class="fw-semibold mb-1" style="color: rgb(0,0,0);font-size: 14px;">Confirm Password</p>
                <input wire:model.defer="password_confirmation" id="password_confirmation" type="password"
                    style="border: 1px solid rgba(0,0,0,0.22);border-radius: 5px;font-size: 14px;width: 100%;"
                    class="px-2 py-1" placeholder="Confirm new password">
            </div>
        </div>

        @if (session()->has('success'))
            <div class="row">
                <div class="col px-5">
                    <div class="alert alert-success py-1" role="alert">
                        <span style="font-size: 14px;"><strong>{{ session('success') }}</strong></span>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="row">
                <div class="col px-5">
                    <div class="alert alert-danger py-1" role="alert">
                        <span style="font-size: 14px;"><strong>{{ session('error') }}</strong></span>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-1">
            <div class="col px-5" style="text-align: center;">
                <button class="btn btn-primary" type="submit"
                    style="width: 50%; background: linear-gradient(-50deg, #0019ff, #00e0ff); border-width: 0px;">
                    Reset Password
                </button>
            </div>
        </div>
    </form>
</div>
