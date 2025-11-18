<?php

namespace App\Services;

use App\Models\Space; // assuming you have a Space model

class SpaceService
{
    public function getTeamSpaces($teamId)
    {
        return Space::where('team_id', $teamId)->get();
    }
}
