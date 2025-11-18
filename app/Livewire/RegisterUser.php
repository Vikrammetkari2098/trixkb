<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class RegisterUser extends Component
{
    public $first_name, $last_name, $email, $password, $roles, $role;

    protected $rules = User::USER_REGISTER_RULES;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        $validated['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $validated['email'] = $validatedData['email'];
        $validated['password'] = bcrypt($validatedData['password']);

        $user = User::create($validated);
        $user->roles()->attach($validatedData['role']);
        session()->flash('success', 'User registered successfully!');
    }

    public function render()
    {
        return view('livewire.auth.register-user');
    }
}
