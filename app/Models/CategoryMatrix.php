<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMatrix extends Model
{
    use HasFactory;

    protected $table = 'category_matrices';

    protected $attributes = [
        'status' => 1,
    ];
    protected $fillable = [
        'name',
        'slug',
        'status',
        'ministry_id',
        'department_id',
        'case_category_id',
        'sub_category_1_id',
        'sub_category_2_id',
        'created_by',
    ];


    const CATEGORY_MATRIX_SCC2 = [
        'sub_case_category_1' => 'required',
        'case_category' => 'required',
        'ministry_id' => 'required',
    ];

    const CATEGORY_MATRIX_SCC1 = [
        'case_category' => 'required',
        'ministry_id' => 'required',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Str::slug($model->name);
            }
        });
    }


    // 🔹 Relationships
    public function ministry()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function caseCategory()
    {
        return $this->belongsTo(CaseCategory::class, 'case_category_id');
    }

    public function subCategory1()
    {
        return $this->belongsTo(SubCaseCategory1::class, 'sub_category_1_id');
    }

    public function subCategory2()
    {
        return $this->belongsTo(SubCaseCategory2::class, 'sub_category_2_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Accessors
    public function getNameAttribute($value)
    {
        return str_replace('->', '➔', $value);
    }
}
