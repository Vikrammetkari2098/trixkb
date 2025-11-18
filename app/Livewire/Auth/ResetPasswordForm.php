<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use TallStackUi\Traits\Interactions;

class ResetPasswordForm extends Component
{
    use Interactions;

    public $password, $password_confirmation;

    protected $rules = User::RESET_PASSWORD_RULES;
    protected $messages = User::RESET_PASSWORD_MESSAGES;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetPassword()
    {
        $validated = $this->validate();

        $email = Session::get('password_reset_email');
        if (!$email) {
            session()->flash('error', 'Session expired or email not found. Please start again.');
            return;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        // Clear session
        Session::forget('password_reset_email');
        Session::forget('password_reset_otp');
        Session::forget('password_reset_expires_at');

        session()->flash('success', 'Password reset successful. Please log in.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.reset-password-form');
    }
}
