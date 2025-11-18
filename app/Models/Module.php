<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'color'
    ];

    public function getNameAttribute($value)
    {
        return ucwords(html_entity_decode($value));
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_module');
    }

    /**
     * Get available TallStackUI badge colors
     */
    public static function getAvailableColors()
    {
        return [
            'slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber',
            'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue',
            'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose', 'black', 'white'
        ];
    }
}
