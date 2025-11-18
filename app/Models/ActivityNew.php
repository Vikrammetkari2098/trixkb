<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityNew extends Model
{
     use HasFactory;

    protected $fillable = [
        'subject_id',
        'subject_type',
        'name',
        'user_id',
        'team_id',
    ];
}
