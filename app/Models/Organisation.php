<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Organisation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'organisations';

    protected $fillable = [
        'name',
        'ministry_id',
        'department_id',
        'segment_id',
        'unit_id',
        'sub_unit_id',
        'status',
        'deleted_by',
        'created_by',
        'last_updated_by',
        'category',
        'code',
        'slug'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    const ORGANISATION_CREATE_RULES = [
        'name' => ['required', 'string'],
        'ministry_id' => ['required', 'exists:ministry,ministry_id'],
        'department_id' => ['nullable', 'exists:department,department_id'],
        'segment_id' => ['nullable', 'exists:segment,segment_id'],
        'unit_id' => ['nullable', 'exists:unit,unit_id'],
        'sub_unit_id' => ['nullable', 'exists:sub_unit,sub_unit_id'],
        'status' => ['required', 'boolean'],
    ];

    const ORGANISATION_CREATE_MESSAGES = [
        'name.required' => 'Organisation name is required',
        'ministry_id.required' => 'Ministry is required',
        'ministry_id.exists' => 'Selected ministry is invalid',
        'department_id.exists' => 'Selected department is invalid',
        'segment_id.exists' => 'Selected segment is invalid',
        'unit_id.exists' => 'Selected unit is invalid',
        'sub_unit_id.exists' => 'Selected sub-unit is invalid',
        'status.required' => 'Status is required',
    ];

    const ORGANISATION_UPDATE_RULES = self::ORGANISATION_CREATE_RULES;
    const ORGANISATION_UPDATE_MESSAGES = self::ORGANISATION_CREATE_MESSAGES;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'maxLength' => 50,
            ],
        ];
    }

    // Relationships
    public function ministry()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class, 'segment_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function subUnit()
    {
        return $this->belongsTo(SubUnit::class, 'sub_unit_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'organisation_user');
    }

    public function logs()
    {
        return $this->hasMany(OrganisationLog::class);
    }

    public function getMinistriesForChatbot()
    {
        return Ministry::whereHas('organisations', function($q){
            $q->where('category', 1)->where('status', 1);
        })
        ->select('ministry_id', 'name')
        ->get();
    }
       public static function getDepartmentsByMinistry($ministryId)
    {
        return Department::where('ministry_id', $ministryId)->get();
    }

}
