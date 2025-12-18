<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\GeneralHelper;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone',
        'profile_photo',
        'team_id',
        'bio',
        'location',
        'website',
        'github_username',
        'linkedin_username',
        'skills',
        'timezone',
        'language',
        'notification_preferences',
    ];

    const USER_REGISTER_RULES = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'min:8'],
        'role' => ['required'],
        //'selectedTeamId' => 'required|exists:teams,id',
    ];

    const USER_REGISTER_MESSAGES = [
        'first_name.required' => 'First name is required',
        'last_name.required' => 'Last name is required',
        'email.required' => 'Email is required',
        'email.unique' => 'Email is already in use',
        'email.email' => 'Invalid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters long',
        'role.required' => 'Role is required'
    ];

        const USER_PROFILE_UPDATE_RULES = [
       'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
        'profile_photo' => ['nullable', 'image', 'max:1024'], // 1MB
    ];

    const USER_PROFILE_UPDATE_MESSAGES = [
        'first_name.required' => 'First name is required',
        'last_name.required' => 'Last name is required',
        'phone.max' => 'Phone number must not exceed 20 characters',
        'profile_photo.image' => 'The profile photo must be an image file',
        'profile_photo.max' => 'The profile photo must not be larger than 1MB',
    ];

    const USER_LOGIN_RULES = [
        'email' => ['required', 'email'],
        'password' => ['required', 'min:8']
    ];

    const USER_LOGIN_MESSAGES = [
        'email.email' => 'Invalid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters long',
    ];
    const USER_PASSWORD_CHANGE_RULES = [
    'old_password' => ['required', 'current_password'],
    'new_password' => ['required', 'min:8'],
    'confirm_password' => ['same:new_password'],
    ];

    const USER_PASSWORD_CHANGE_MESSAGES = [
        'old_password.required' => 'Old password is required',
        'old_password.current_password' => 'Old password is incorrect',
        'new_password.required' => 'New password is required',
        'new_password.min' => 'New password must be at least 8 characters',
        'confirm_password.same' => 'Confirm password must match the new password',
    ];

    const PASSWORD_OTP_RULES = [
        'email' => 'required|email|exists:users,email',
        'otp' => 'nullable|numeric|digits:6',
    ];

    const PASSWORD_OTP_MESSAGES = [
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be valid.',
        'email.exists' => 'We could not find a user with this email.',
        'otp.required' => 'OTP is required.',
        'otp.numeric' => 'OTP must be a number.',
        'otp.digits' => 'OTP must be 6 digits.',
    ];
      public const RESET_PASSWORD_RULES = [
        'password' => 'required|string|min:6|confirmed',
    ];

    public const RESET_PASSWORD_MESSAGES = [
        'password.required' => 'The password is required.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Passwords do not match.',
    ];

      const MEMBER_REGISTER_RULES = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name'  => ['required', 'string', 'max:255'],
        'email'      => ['required', 'email', 'unique:users'],
        'role'       => ['required'],
    ];

     const MEMBER_REGISTER_MESSAGES = [
        'first_name.required' => 'First name is required',
        'last_name.required'  => 'Last name is required',
        'email.required'      => 'Email is required',
        'email.unique'        => 'Email is already in use',
        'email.email'         => 'Invalid email address',
        'role.required'       => 'Role is required',
    ];

    /**
     * Validation rules specifically for Member update (password optional)
     */
     const MEMBER_UPDATE_RULES = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name'  => ['required', 'string', 'max:255'],
        'email'      => ['required', 'email', 'unique:users,email,{id}'], // {id} will be replaced in Livewire
        'role'       => ['required'],
    ];

     const MEMBER_UPDATE_MESSAGES = [
        'first_name.required' => 'First name is required',
        'last_name.required'  => 'Last name is required',
        'email.required'      => 'Email is required',
        'email.unique'        => 'Email is already in use',
        'email.email'         => 'Invalid email address',
        'role.required'       => 'Role is required',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_preferences' => 'array',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roles)
    {
        return $this->roles()->whereIn('id', $roles)->exists();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_user');
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
     public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function currentRole()
{
    // Return the actual Role model, not the relationship object
    return $this->belongsTo(Role::class, 'current_role_id');
}

    public function hasPermission($routePermissions)
    {
        $routePermissions = explode('|', $routePermissions);

        // Get the Role model instance
        $role = $this->currentRole; // <-- note: no parentheses

        if (!$role) return false;

        // Make sure the Role model has a 'permissions' relationship
        if (!$role->relationLoaded('permissions')) {
            $role->load('permissions');
        }

        foreach ($role->permissions as $permission) {
            foreach ($routePermissions as $routePer) {
                if ($permission->name === $routePer) {
                    return true;
                }
            }
        }

        return false;
    }
    public function getPKPUsers()
    {
        if ($this->user_type == GeneralHelper::internalUser()) {
            return User::whereHas('roles', function ($query) {
                        $query->where('role_id', GeneralHelper::userInternalPKPAgent());
                    })
                    ->distinct()
                    ->get();
        }
        elseif ($this->user_type == GeneralHelper::userExternalPKPAgent()) {
            return User::whereHas('roles', function ($query) {
                        $query->where('role_id', GeneralHelper::userExternalPKPAgent());
                    })
                    ->distinct()
                    ->get();
        }
        else {
            return User::whereHas('roles', function ($query) {
                        $query->whereIn('role_id', GeneralHelper::allPKPUsers());
                    })
                    ->distinct()
                    ->get();
        }
    }
     public function getMinistries()
    {
        return Ministry::join('organisations', 'ministry.ministry_id', '=', 'organisations.ministry_id')
                       ->where('organisations.category', GeneralHelper::getOrganisationCategory('Ministry'))
                       ->where('organisations.status', GeneralHelper::getActiveStatus());
    }
    public function getIPAddress()
    {
        return request()->ip();
    }
     public function articles()
    {
        return $this->hasMany(ArticleVersion::class, 'author_id');
    }
}
