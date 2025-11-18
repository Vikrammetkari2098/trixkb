<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'name',
        'short_name',
        'status',
        'user_id',
        'slug',
        'team_id',
    ];

    const DEPARTMENT_RULES = [
        'department_name' => 'required|min:2',
        'department_short_name' => 'required|min:2',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Relationships
     */
    public function organisations()
    {
        return $this->hasMany(Organisation::class, 'department_id')->where('category', 2)->where('status', 1);
    }

    /**
     * Create Department
     */
    public function createDepartment(array $data)
    {
        return $this->create([
            'name'       => $data['department_name'],
            'short_name' => $data['department_short_name'],
            'status'     => $data['is_active'] ?? 0,
            'user_id'    => Auth::id(),
        ]);
    }

    /**
     * Update Department
     */
    public function updateDepartment(array $data)
    {
        $isActive = $data['is_active'] ?? 0;

        return $this->update([
            'name'       => $data['department_name'],
            'short_name' => $data['department_short_name'],
            'status'     => $isActive,
        ]);
    }

    /**
     * Clean name attribute
     */
    public function getNameAttribute($value)
    {
        return preg_replace('/\s*\(\s*\d+\s*\)\s*$/', '', $value);
    }

    /**
     * Track changes
     */
    public function getDepartmentChanges(array $oldData, array $newData)
    {
        $keyMap = [
            'department_name'       => 'name',
            'department_short_name' => 'short_name',
            'is_active'             => 'status',
        ];

        return getArrayChanges($oldData, $newData, $keyMap);
    }

    /**
     * Store log changes
     */
    public function storeDepartmentLogChanges(self $department, $changes)
    {
        DB::table('department_log')->insert([
            'department_id' => $department->department_id,
            'name'          => $department->name,
            'short_name'    => $department->short_name,
            'code'          => $department->code ?? null,
            'slug'          => $department->slug,
            'status'        => $department->status,
            'changes'       => $changes,
            'user_id'       => $department->user_id,
            'modified_by'   => Auth::id(),
            'created_at'    => now(),
        ]);
    }
}
