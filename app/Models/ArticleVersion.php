<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleVersion extends Model
{
    use HasFactory;

    protected $table = 'article_versions';

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'content',
        'cover_image',
        'status',
        'published_at',
        'read_time',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Author relation
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
