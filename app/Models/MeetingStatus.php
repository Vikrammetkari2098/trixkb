<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingStatus extends Model
{
    protected $fillable = [
        'name', 
        'color'
    ];

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'status_id');
    }
}
