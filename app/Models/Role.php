<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'team_id',
        'is_public',
    ];

    // Validation constants
    public const ROLE_CREATE_RULES = [
        'name'        => 'required|string|max:255',
        'users'       => 'nullable|array',
        'permissions' => 'nullable|array',
    ];

    public const ROLE_UPDATE_RULES = self::ROLE_CREATE_RULES;

    public const ROLE_CREATE_MESSAGES = [
        'name.required' => 'Role name is required.',
        'name.string'   => 'Role name must be a valid string.',
        'name.max'      => 'Role name cannot exceed 255 characters.',
    ];

    public const ROLE_UPDATE_MESSAGES = self::ROLE_CREATE_MESSAGES;

    // Accessor
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    // Relationships
    public function members()
    {
        return $this->belongsToMany(User::class, 'users_roles', 'role_id', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }

}
