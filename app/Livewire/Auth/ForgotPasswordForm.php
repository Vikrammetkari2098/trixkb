<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Carbon;

class ForgotPasswordForm extends Component
{
    use Interactions;

    public $email, $otp, $step = 1, $generatedOtp;
    public $otpExpiresAt;
    protected $rules = User::PASSWORD_OTP_RULES;
    protected $messages = User::PASSWORD_OTP_MESSAGES;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function sendOtp()
    {
        $this->validateOnly('email');

        $this->generatedOtp = rand(100000, 999999);
        $this->otpExpiresAt = now()->addMinutes(5);

        // Store OTP and expiry
        Session::put('password_reset_otp', $this->generatedOtp);
        Session::put('password_reset_email', $this->email);
        Session::put('password_reset_expires_at', $this->otpExpiresAt);

        try {
            Mail::raw("Your OTP is: {$this->generatedOtp}", function ($message) {
                $message->to($this->email)->subject('Your Password Reset OTP');
            });
            $this->toast()->success('Success', 'OTP sent to your email.')->send();
            $this->step = 2;
            //   \Log::info("vikram");

        } catch (\Exception $e) {
        //    \Log::info("metkari");
        //    \Log::info($e->getMessage());
            $this->addError('email', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function resendOtp()
    {
        $this->sendOtp();
        $this->toast()->info('Resent', 'OTP has been resent to your email.')->send();
    }

    public function verifyOtp()
    {
        $this->validateOnly('otp');

        $storedOtp = Session::get('password_reset_otp');
        $expiry = Session::get('password_reset_expires_at');

        if (now()->greaterThan(Carbon::parse($expiry))) {
            $this->addError('otp', 'OTP has expired. Please resend.');
            return;
        }

        if ($this->otp == $storedOtp) {
            $this->toast()->success('Verified', 'OTP verified.')->send();
            return redirect()->route('password.reset');
        }

        $this->addError('otp', 'Invalid OTP. Please try again.');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-form');
    }
}
