<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasFactory;

    protected $table = 'ministry';

    protected $primaryKey = 'ministry_id';
    protected $fillable = ['name', 'short_name', 'status', 'slug'];
      public function organisations()
    {
        return $this->hasMany(Organisation::class, 'ministry_id')
                    ->where('category', 1)
                    ->where('status', 1);
    }

}
