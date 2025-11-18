<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Segment extends Model
{
    use HasFactory;

    protected $table = 'segment';
    protected $primaryKey = 'segment_id';

    protected $fillable = [
        'name',
        'status',
        'user_id',
        'slug',
    ];

    const SEGMENT_RULES = [
        'segment_name' => 'required|min:2',
    ];

    /**
     * Slug configuration
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
     * Relationships
     */
    public function organisations()
    {
        return $this->hasMany(Organisation::class, 'segment_id')->where('status', 1);
    }

    /**
     * Create Segment
     */
    public function createSegment(array $data)
    {
        return $this->create([
            'name'    => $data['segment_name'],
            'status'  => $data['is_active'] ?? 0,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Update Segment
     */
    public function updateSegment(array $data)
    {
        $isActive = $data['is_active'] ?? 0;

        return $this->update([
            'name'   => $data['segment_name'],
            'status' => $isActive,
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
    public function getSegmentChanges(array $oldData, array $newData)
    {
        $keyMap = [
            'segment_name' => 'name',
            'is_active'    => 'status',
        ];

        return getArrayChanges($oldData, $newData, $keyMap);
    }

    /**
     * Store log changes
     */
    public function storeSegmentLogChanges(self $segment, $changes)
    {
        DB::table('segment_log')->insert([
            'segment_id'  => $segment->segment_id,
            'name'        => $segment->name,
            'code'        => $segment->code ?? null,
            'slug'        => $segment->slug,
            'status'      => $segment->status,
            'changes'     => $changes,
            'user_id'     => $segment->user_id,
            'modified_by' => Auth::id(),
            'created_at'  => now(),
        ]);
    }
}
