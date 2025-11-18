<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApprovalLevel;
use App\Models\User;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'slug',
    'is_private',
    'is_public',
    'is_default',
    'color',
    'created_by',
    'last_updated_by',
];


    // Relationships
    public function approvalLevelsFrom() {
        return $this->hasMany(ApprovalLevel::class, 'status_from_id');
    }

    public function approvalLevelsTo() {
        return $this->hasMany(ApprovalLevel::class, 'status_to_id');
    }

    public function createdByUser() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser() {
        return $this->belongsTo(User::class, 'last_updated_by');
    }
}
