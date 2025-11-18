<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

class ProfileEdit extends Component
{
    use Interactions, WithFileUploads;

    public $userId;
    public $first_name, $last_name, $email, $phone, $profile_photo;
    public $bio, $location, $website, $github_username, $linkedin_username;
    public $skills = [];
    public $timezone, $language, $notification_preferences = [];

    public function mount()
    {
        $user = Auth::user();
        $this->userId = $user->id;

        $parts = explode(' ', $user->name, 2);
        $this->first_name = $parts[0] ?? '';
        $this->last_name = $parts[1] ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->bio = $user->bio ?? '';
        $this->location = $user->location ?? '';
        $this->website = $user->website ?? '';
        $this->github_username = $user->github_username ?? '';
        $this->linkedin_username = $user->linkedin_username ?? '';
        $this->skills = $user->skills ? explode(',', $user->skills) : [];
        $this->timezone = $user->timezone ?? 'UTC';
        $this->language = $user->language ?? 'en';
        $this->notification_preferences = $user->notification_preferences ? json_decode($user->notification_preferences, true) : [
            'email_notifications' => true,
            'task_assignments' => true,
            'project_updates' => true,
            'team_mentions' => true,
        ];
    }

    #[On('loadData-edit-profile')]
    public function loadData($userId)
    {
        $user = User::findOrFail($userId);
        $this->userId = $user->id;

        $parts = explode(' ', $user->name, 2);
        $this->first_name = $parts[0] ?? '';
        $this->last_name = $parts[1] ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->bio = $user->bio ?? '';
        $this->location = $user->location ?? '';
        $this->website = $user->website ?? '';
        $this->github_username = $user->github_username ?? '';
        $this->linkedin_username = $user->linkedin_username ?? '';
        $this->skills = $user->skills ? explode(',', $user->skills) : [];
        $this->timezone = $user->timezone ?? 'UTC';
        $this->language = $user->language ?? 'en';
        $this->notification_preferences = $user->notification_preferences ? json_decode($user->notification_preferences, true) : [
            'email_notifications' => true,
            'task_assignments' => true,
            'project_updates' => true,
            'team_mentions' => true,
        ];
    }

    protected function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'max:1024'],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'github_username' => ['nullable', 'string', 'max:255'],
            'linkedin_username' => ['nullable', 'string', 'max:255'],
            'timezone' => ['required', 'string'],
            'language' => ['required', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'email.unique' => 'This email is already taken',
            'phone.max' => 'Phone number is too long',
            'profile_photo.image' => 'Profile photo must be an image',
            'profile_photo.max' => 'Profile photo must be less than 1MB',
            'bio.max' => 'Bio must be less than 500 characters',
            'website.url' => 'Please enter a valid website URL',
            'timezone.required' => 'Please select a timezone',
            'language.required' => 'Please select a language',
        ];
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function addSkill($skill)
    {
        if (!empty($skill) && !in_array($skill, $this->skills)) {
            $this->skills[] = $skill;
        }
    }

    public function removeSkill($index)
    {
        if (isset($this->skills[$index])) {
            unset($this->skills[$index]);
            $this->skills = array_values($this->skills);
        }
    }

    public function getTimezoneOptions()
    {
        return [
            'UTC' => 'UTC',
            'America/New_York' => 'Eastern Time (US)',
            'America/Chicago' => 'Central Time (US)',
            'America/Denver' => 'Mountain Time (US)',
            'America/Los_Angeles' => 'Pacific Time (US)',
            'Europe/London' => 'London',
            'Europe/Paris' => 'Paris',
            'Europe/Berlin' => 'Berlin',
            'Asia/Tokyo' => 'Tokyo',
            'Asia/Shanghai' => 'Shanghai',
            'Asia/Kolkata' => 'India',
            'Australia/Sydney' => 'Sydney',
        ];
    }

    public function getLanguageOptions()
    {
        return [
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'zh' => 'Chinese',
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $user = User::findOrFail($this->userId);
        
        $validated['name'] = trim($this->first_name . ' ' . $this->last_name);
        $validated['bio'] = $this->bio;
        $validated['location'] = $this->location;
        $validated['website'] = $this->website;
        $validated['github_username'] = $this->github_username;
        $validated['linkedin_username'] = $this->linkedin_username;
        $validated['skills'] = implode(',', $this->skills);
        $validated['timezone'] = $this->timezone;
        $validated['language'] = $this->language;
        $validated['notification_preferences'] = json_encode($this->notification_preferences);

        if ($user->email === $this->email) {
            unset($validated['email']);
        }

        if ($this->profile_photo && $this->profile_photo->getRealPath()) {
            $filename = time() . '_' . $this->profile_photo->getClientOriginalName();
            $destinationPath = public_path('profile-photos/' . $filename);

            if (!File::exists(public_path('profile-photos'))) {
                File::makeDirectory(public_path('profile-photos'), 0755, true);
            }
            File::copy($this->profile_photo->getRealPath(), $destinationPath);
            
            if (
                $user->profile_photo &&
                File::exists(public_path($user->profile_photo)) &&
                $user->profile_photo !== 'assets/img/avatars/avatar5.jpeg'
            ) {
                File::delete(public_path($user->profile_photo));
            }
            
            $validated['profile_photo'] = 'profile-photos/' . $filename;
        } else {
            unset($validated['profile_photo']);
        }

        $user->update($validated);
        
        $this->toast()->success('Success', 'Profile updated successfully')->send();
        $this->dispatch('loadData-profile');
        $this->dispatch('close-modal-edit-profile');
    }

    public function render()
    {
        return view('livewire.profile.profile-edit');
    }
}
