<?php

namespace App\Services;

use App\Models\Wiki;

class WikiService
{
   public function getArticles($user)
    {
        return Wiki::where('wiki_type', 'article')
                ->whereNull('user_id'); // or other conditions
    }

    public function getDirectoriesByRoles($user)
    {
        return Wiki::where('wiki_type', 'directory');
    }

}
