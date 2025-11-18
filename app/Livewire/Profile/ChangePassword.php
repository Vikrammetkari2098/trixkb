<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use TallStackUi\Traits\Interactions;

class ChangePassword extends Component
{
    use Interactions;

    public $old_password, $new_password, $confirm_password;

    protected $rules = User::USER_PASSWORD_CHANGE_RULES;
    protected $messages = User::USER_PASSWORD_CHANGE_MESSAGES;

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function update()
    {
        $this->validate();

        $user = Auth::user();

        if (!Hash::check($this->old_password, $user->password)) {
            $this->addError('old_password', 'Old password is incorrect');
            return;
        }
        $user->password = Hash::make($this->new_password);
        $user->save();
        $this->reset(['old_password', 'new_password', 'confirm_password']);
        $this->dispatch('close-modal-change-password');
        $this->toast()->success('Success', 'Password changed successfully')->send();
    }
    public function render()
    {
        return view('livewire.profile.change-password');
    }
}
