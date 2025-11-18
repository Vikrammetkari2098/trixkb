<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function pages()
    {
        return $this->morphedByMany(Page::class, 'taggable');
    }
}
