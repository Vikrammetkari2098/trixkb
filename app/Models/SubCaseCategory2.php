<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCaseCategory2 extends Model
{
    use HasFactory;

    protected $table = 'sub_case_categories_2';
     protected $primaryKey = 'id';

    protected $attributes = [
        'status' => 1,
    ];

    protected $fillable = [
        'name',
        'slug',
        'status',
        'user_id',
        'created_by',
    ];

    public function categoryMatrices()
    {
        return $this->hasMany(CategoryMatrix::class, 'sub_category_2_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createWithSlug(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['user_id'] = auth()->id();
        $data['created_by'] = auth()->id();
        return self::create($data);
    }
}
