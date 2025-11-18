<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\OrganisationHelpers;
use App\Models\User;

class Space extends Model
{
    use HasFactory, OrganisationHelpers;

    protected $fillable = [
        'name',
        'color',
        'slug',
        'outline',
        'user_id',
        'team_id',
        'organisation_id',
        'ministry_id',
        'department_id',
        'is_read',
        'deleted_at'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function wikis()
    {
        return $this->hasMany(Wiki::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function getTeamSpaces($teamId)
    {
        $user = auth()->user();

        // Admin / KetuaBahagian / Internal PKP Agent
        if ($user->hasPermission('admin')
            || $user->current_role_id == $this->userKetuaBahagian()
            || $user->current_role_id == $this->userInternalPKPAgent()) {

            return $this->whereHas('organisation', fn($q) => $q->where('status', 1))
                        ->where('team_id', $teamId)
                        ->where('name', '!=', 'Default')
                        ->with(['team', 'organisation'])
                        ->orderBy('name', 'asc')
                        ->get();
        }
        // External Content Creator / SPARK / External PKP Agent
        elseif ($user->current_role_id == $this->userExternalContentCreator()
            || $user->current_role_id == $this->userSPARK()
            || $user->current_role_id == $this->userExternalPKPAgent()) {

            return $this->whereHas('organisation', fn($q) => $q->where('status', 1))
                        ->where('team_id', $teamId)
                        ->where('name', '!=', 'Default')
                        ->whereIn('organisation_id', User::getDeptsBasedMinistry($user))
                        ->orderBy('name', 'asc')
                        ->get();
        }
        // Default fallback
        else {
            return $this->whereHas('organisation', fn($q) => $q->where('status', 1))
                        ->where('team_id', $teamId)
                        ->where('name', '!=', 'Default')
                        ->with(['team', 'organisation'])
                        ->orderBy('name', 'asc')
                        ->get();
        }
    }
}
