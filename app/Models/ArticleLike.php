<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    
    public $timestamps = false;
    protected $table = 'article_likes';

    protected $fillable = [
        'article_id', 
        'user_id', 
        'ip_address', 
        'created_at'
    ];
}