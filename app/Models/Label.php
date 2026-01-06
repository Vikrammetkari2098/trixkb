<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_label');
    }
}
