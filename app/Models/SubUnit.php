<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubUnit extends Model
{
    use HasFactory;

    protected $table = 'sub_unit';
    protected $primaryKey = 'sub_unit_id';

    protected $fillable = [
        'name',
        'status',
        'user_id',
        'slug',
    ];

    const SUB_UNIT_RULES = [
        'sub_unit_name' => 'required|min:2',
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
     * Create SubUnit
     */
    public function createSubUnit(array $data)
    {
        return $this->create([
            'name'    => $data['sub_unit_name'],
            'status'  => $data['is_active'] ?? 0,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Update SubUnit
     */
    public function updateSubUnit(array $data)
    {
        $isActive = $data['is_active'] ?? 0;

        return $this->update([
            'name'   => $data['sub_unit_name'],
            'status' => $isActive,
        ]);
    }

    /**
     * Clean name (remove codes at end)
     */
    public function getNameAttribute($value)
    {
        return preg_replace('/\s*\(\s*\d+\s*\)\s*$/', '', $value);
    }

    /**
     * Track changes
     */
    public function getSubUnitChanges(array $oldData, array $newData)
    {
        $keyMap = [
            'sub_unit_name' => 'name',
            'is_active'     => 'status',
        ];

        return getArrayChanges($oldData, $newData, $keyMap);
    }

    /**
     * Store logs
     */
    public function storeSubUnitLogChanges(self $subUnit, $changes)
    {
        DB::table('sub_unit_log')->insert([
            'sub_unit_id' => $subUnit->sub_unit_id,
            'name'        => $subUnit->name,
            'code'        => $subUnit->code ?? null,
            'slug'        => $subUnit->slug,
            'status'      => $subUnit->status,
            'changes'     => $changes,
            'user_id'     => $subUnit->user_id,
            'modified_by' => Auth::id(),
            'created_at'  => now(),
        ]);
    }

    /**
     * Relationships
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function organisations()
    {
        return $this->hasMany(Organisation::class, 'sub_unit_id');
    }
}
