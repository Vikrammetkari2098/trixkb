<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ArticleVersion extends Model
{
    use HasFactory;

    protected $table = 'article_version';

    protected $fillable = [
        'article_id',
        'editor_id',
        'title',
        'slug',
        'content',
        'status',
        'is_featured',
        'views',
        'likes',
        'published_at',
        'read_time',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_version_id', 'tag_id')
                    ->withTimestamps();
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
