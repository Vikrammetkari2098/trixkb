<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit';
    protected $primaryKey = 'unit_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'user_id',
        'slug',
    ];

    /**
     * Validation rules
     */
    const UNIT_RULES = [
        'unit_name' => 'required|min:2',
    ];

    /**
     * Sluggable config
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Create new unit
     */
    public function createUnit($data)
    {
        return $this->create([
            'name'    => $data['unit_name'],
            'status'  => $data['is_active'] ?? 0,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Update existing unit
     */
    public function updateUnit($data)
    {
        $isActive = isset($data['is_active']) ? $data['is_active'] : 0;

        return $this->update([
            'name'   => $data['unit_name'],
            'status' => $isActive,
        ]);
    }

    /**
     * Accessor - remove unwanted code pattern from name
     */
    public function getNameAttribute($value)
    {
        return preg_replace('/\s*\(\s*\d+\s*\)\s*$/', '', $value);
    }

    /**
     * Compare old/new data for changes
     */
    public function getUnitChanges($oldData, $newData)
    {
        $keyMap = [
            'unit_name' => 'name',
            'is_active' => 'status',
        ];

        return getArrayChanges($oldData, $newData, $keyMap);
    }

    /**
     * Store log changes
     */
    public function storeUnitLogChanges($unit, $changes)
    {
        DB::table('unit_log')->insert([
            'unit_id'     => $unit->unit_id,
            'name'        => $unit->name,
            'code'        => $unit->code ?? null,
            'slug'        => $unit->slug,
            'status'      => $unit->status,
            'changes'     => $changes,
            'user_id'     => $unit->user_id,
            'modified_by' => Auth::id(),
            'created_at'  => now(),
        ]);
    }

    /**
     * Relationships
     */
    public function organisations()
    {
        return $this->hasMany(Organisation::class, 'unit_id');
    }
}
