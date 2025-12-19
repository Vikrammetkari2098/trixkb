<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'author_id',
        'status',
        'is_featured',
        'current_version_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Auto-generate unique slug
     */
    protected static function booted()
    {
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $slug = Str::slug($article->title);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                $article->slug = $slug;
            }
        });
    }

    /* ==========================
       Relationships
       ========================== */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function currentVersion()
    {
        return $this->belongsTo(ArticleVersion::class, 'current_version_id');
    }
    public function versions()
    {
        return $this->hasMany(ArticleVersion::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
