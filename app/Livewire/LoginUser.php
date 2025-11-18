<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class LoginUser extends Component
{
    public $email, $password;

    protected $rules = User::USER_LOGIN_RULES;

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $validatedData = $this->validate();

        if (auth()->attempt($validatedData)) {
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'Invalid email or password!');
        }
    }

    public function render()
    {
        return view('livewire.auth.login-user');
    }
}
