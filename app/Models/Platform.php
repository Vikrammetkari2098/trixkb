<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'is_active',
        'url_pattern'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all meetings using this platform
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    /**
     * Scope to get only active platforms
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
