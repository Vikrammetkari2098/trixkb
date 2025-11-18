<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $table = 'categories';

    // Primary key (if it's not 'id')
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
    ];
    public function wikis()
    {
        return $this->belongsToMany(Wiki::class, 'wiki_categories', 'category_id', 'wiki_id');
    }

}
