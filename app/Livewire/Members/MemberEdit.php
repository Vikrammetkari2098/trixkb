<?php
namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\User;
use App\Models\Role; // ✅ Import Role model
use App\Models\Activity;
use TallStackUi\Traits\Interactions;

class MemberEdit extends Component
{
    use Interactions;
    public $userId;
    public $first_name;
    public $last_name;
    public $email;
    public $role;
    public $roles;

    protected $listeners = ['loadData-edit-member' => 'loadMember'];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function loadMember($id)
    {
        $this->userId = $id;
        $user = User::with('roles')->findOrFail($id);
        $this->first_name = explode(' ', $user->name)[0];
        $this->last_name = explode(' ', $user->name)[1] ?? '';
        $this->email = $user->email;
        $this->role = $user->roles->pluck('id')->first() ?? null;

        $this->dispatch('open-modal-edit-member');
    }

    public function update()
    {
        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
        ]);

        // Sync role
        $user->roles()->sync([$this->role]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'updated_member',
            'description' => 'Updated member: ' . $user->name,
            'ip_address' => request()->ip(),
        ]);
        $this->toast()->success('Success', 'Member updated successfully')->send();
        $this->dispatch('close-modal-edit-member');
        $this->dispatch('refresh-members-list');
    }

    public function render()
    {
        return view('livewire.members.member-edit');
    }
}
