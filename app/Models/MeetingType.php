<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingType extends Model
{
    protected $fillable = ['name'];

 public function meetings()
    {
        return $this->hasMany(Meeting::class, 'meeting_type_id');
    }
}
