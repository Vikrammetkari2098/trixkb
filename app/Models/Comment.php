<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
       use SoftDeletes;
    protected $fillable = ['content', 'user_id'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_comment');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeOrderByDaysSinceUpdated($query)
    {
        return $query->orderByRaw('DATEDIFF(NOW(), updated_at) ASC');
    }
}
