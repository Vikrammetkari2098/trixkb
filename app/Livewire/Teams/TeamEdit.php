<?php

namespace App\Livewire\Teams;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;
use App\Models\Activity;
use App\Models\Team;
class TeamEdit extends Component
{
    use Interactions;

    public $first_name, $last_name, $email, $password = '', $password_confirmation = '', $role, $roles, $userId;
    public $teams, $selectedTeamId;

    protected $messages = User::USER_REGISTER_MESSAGES;
    protected $rules = User::USER_REGISTER_RULES;

    public function mount()
    {
        $this->roles = Role::all();
        $this->teams = Team::all();
        $this->initializeRules();
    }

    #[On('loadUser')]
    public function loadData($userId)
    {
        $this->userId = $userId;
        $user = User::findOrFail($userId);

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role = $user->roles->first()->id ?? null;
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedTeamId = $user->team_id;

        if (empty($this->first_name) && empty($this->last_name) && !empty($user->name)) {
            $nameParts = explode(' ', $user->name, 2);
            $this->first_name = $nameParts[0] ?? '';
            $this->last_name = $nameParts[1] ?? '';
        }

        $this->initializeRules();
        $this->resetValidation();
        $this->dispatch('open-modal-edit');
    }

    protected function initializeRules()
    {
        $this->rules = User::USER_REGISTER_RULES;
        $this->rules['email'] = 'required|email|unique:users,email,' . ($this->userId ?? 'NULL');
        $this->rules['selectedTeamId'] = 'required|exists:teams,id';
        if (empty($this->password)) {
            unset($this->rules['password'], $this->rules['password_confirmation']);
        }
    }
    public function updated($propertyName)
    {
        $this->initializeRules();
        $this->validateOnly($propertyName);
    }
    public function update()
    {
        $this->initializeRules();
        $validated = $this->validate();

        $user = User::findOrFail($this->userId);
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->email = $validated['email'];
        $user->team_id = $validated['selectedTeamId'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        $user->roles()->sync([$validated['role']]);
        $this->dispatch('close-modal-edit');
            Activity::create([
            'user_id' => auth()->id(),
            'action' => 'updated_member',
            'description' => 'Updated user: ' . $user->name,
            'ip_address' => request()->ip(),
        ]);
        $this->toast()->success('Success', 'Member updated successful')->send();
        $this->refreshData();
    }
    public function refreshData()
    {
        $this->dispatch('refresh-other-components');
    }
    public function render()
    {
        return view('livewire.teams.team-edit');
    }
}
