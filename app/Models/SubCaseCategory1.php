<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCaseCategory1 extends Model
{
    use HasFactory;

    protected $table = 'sub_case_categories_1';
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
        return $this->hasMany(CategoryMatrix::class, 'sub_category_1_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper for creating with slug
    public static function createWithSlug($data)
    {
        return self::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'status' => $data['status'] ?? 1,
            'user_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);
    }
}
