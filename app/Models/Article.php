<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
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
