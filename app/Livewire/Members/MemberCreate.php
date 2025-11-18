<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Activity;
use TallStackUi\Traits\Interactions;

class MemberCreate extends Component
{
    use Interactions;

    public $first_name, $last_name, $email, $password, $roles, $role;
    public $users;

    protected $rules = User::MEMBER_REGISTER_RULES;
    protected $messages = User::MEMBER_REGISTER_MESSAGES;

    public function mount()
    {
        $this->roles = Role::all(); // All roles for select dropdown
        $this->users = User::all(); // Optional: if you need user list
    }

    public function refreshData()
    {
        $this->dispatch('refresh-members-list'); // Refresh parent/list component
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        $name = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $password = bcrypt($validatedData['password'] ?? 'password123'); // default if not provided

        $user = User::create([
            'name' => $name,
            'email' => $validatedData['email'],
            'password' => $password,
            'email_verified_at' => now(),
        ]);

        // Attach role
        $user->roles()->attach($validatedData['role']);

        // Log activity
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'created_member',
            'description' => 'Created new member: ' . $user->name,
            'ip_address' => request()->ip(),
        ]);

        // Close modal
        $this->dispatch('close-modal-create-member');

        // Success toast
        $this->toast()->success('Success', 'Member added successfully')->send();

        // Reset fields
        $this->reset(['first_name', 'last_name', 'email', 'password', 'role']);

        // Refresh parent/list
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.members.member-create');
    }
}
