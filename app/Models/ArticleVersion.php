<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleVersion extends Model
{
    protected $table = 'article_versions';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'article_id',
        'version_number',
        'status',
        'is_featured',
        'author_id',
        'editor_id',
        'views',
        'likes',
        'published_at',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }
}
