<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;

class ApprovalLevel extends Model
{
    use HasFactory;

    protected $table = 'approval_level';

    protected $fillable = [
        'role_id',
        'order',
        'status_from_id',
        'status_to_id',
        'created_by',
        'last_updated_by'
    ];

    // Relationships
    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function statusFrom() {
        return $this->belongsTo(Status::class, 'status_from_id');
    }

    public function statusTo() {
        return $this->belongsTo(Status::class, 'status_to_id');
    }

    public function createdByUser() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser() {
        return $this->belongsTo(User::class, 'last_updated_by');
    }
}
