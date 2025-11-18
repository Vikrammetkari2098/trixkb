<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Wiki extends Model
{
    use HasFactory;

    protected $table = 'wiki';

    protected $fillable = [
        'wiki_type',
        'wiki_source',
        'name',
        'slug',
        'outline',
        'description',
        'user_id',
        'team_id',
        'organisation_id',
        'ministry_id',
        'department_id',
        'segment_id',
        'unit_id',
        'sub_unit_id',
        'attachments',

        //  Added fields for Directory
        'space_id',
        'dial_code',
        'extension_number',
        'office_number',
        'office_number_2',
        'office_number_3',
        'office_number_4',
        'mobile_number',
        'fax',
        'designation',
        'grade',
        'work_scope',
        'email',
        'address',
        'remark',
        'created_by',
    ];

    protected $casts = [
        'space_ids' => 'array',
    ];

    // Automatically generate slug when creating
    protected static function booted()
    {
        static::creating(function ($wiki) {
            if (empty($wiki->slug)) {
                $wiki->slug = Str::slug($wiki->name) . '-' . time();
            }
        });
    }

    // Relationships
    public function space()
    {
        return $this->belongsTo(Space::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'wiki_categories', 'wiki_id', 'category_id')
                    ->select('categories.*');
    }

    public function spaces()
    {
        return $this->belongsToMany(Space::class, 'wiki_space', 'wiki_id', 'space_id');
    }


    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function subUnit()
    {
        return $this->belongsTo(SubUnit::class, 'sub_unit_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
