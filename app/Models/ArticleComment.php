<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleComment extends Model
{
    
    public $timestamps = false;
    protected $table = 'article_comments';

    protected $fillable = [
        'article_id', 'user_id', 'parent_id', 'comment', 'is_approved', 'created_at'
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function replies(): HasMany
    {
        return $this->hasMany(ArticleComment::class, 'parent_id')->with('user');
    }
}