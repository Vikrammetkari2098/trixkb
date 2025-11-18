<?php

namespace App\Livewire\Teams;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Models\Activity;
use App\Models\Team;
class TeamCreate extends Component
{
    use Interactions;

    public $first_name, $last_name, $email, $password, $roles, $role, $users, $teams;
    public $selectedUserId, $selectedTeamId;
    protected $rules = User::USER_REGISTER_RULES;
    protected $messages = User::USER_REGISTER_MESSAGES;

    public function mount()
    {
        $this->users = User::all();
        $this->teams = Team::all();
        $this->roles = Role::all();
    }

    public function refreshData()
    {
        $this->dispatch('refresh-other-components');
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

   public function register()
{
    $validatedData = $this->validate();

    $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
    $validatedData['password'] = bcrypt($validatedData['password']);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => $validatedData['password'],
        'email_verified_at' => now(),
        'team_id' => $this->selectedTeamId, // ✅ Assign team_id here
    ]);

    Activity::create([
        'user_id' => auth()->id(),
        'action' => 'created_member',
        'description' => 'Created new user: ' . $user->name,
        'ip_address' => request()->ip(),
    ]);

    $user->roles()->attach($validatedData['role']);

    $this->dispatch('close-modal-create');
    $this->toast()->success('Success', 'Member added successfully')->send();
    $this->refreshData();
}


    public function render()
    {
        return view('livewire.teams.team-create');
    }
}
