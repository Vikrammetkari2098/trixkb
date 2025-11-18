<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'audit_trail';

    protected $fillable = ['action', 'subject', 'subject_id', 'user_id', 'ip_address'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function recordAuditLog($action, $subject, $subjectId)
    {

        $user = auth()->user();

        if($user)
        {
            AuditTrail::create([
                'action' => $action,
                'subject' => $subject,
                'subject_id' => $subjectId,
                'ip_address' => $user->getIPAddress(),
                'user_id' => $user->id,
            ]);
        }
    }

    public function unAuthAuditLog($action, $subject, $subjectId, $userId)
    {
        AuditTrail::create([
            'action' => $action,
            'subject' => $subject,
            'subject_id' => $subjectId,
            'ip_address' => request()->ip(),
            'user_id' => $userId,
        ]);
    }
}
