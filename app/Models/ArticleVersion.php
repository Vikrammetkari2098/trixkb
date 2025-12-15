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
        'status',
        'is_featured',
        'author_id',
        'editor_id',
        'published_at',
    ];
}
