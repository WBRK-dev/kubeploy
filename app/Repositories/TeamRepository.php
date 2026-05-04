<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Team;

class TeamRepository
{
    public function getBySlug(string $slug): ?Team
    {
        return Team::where('slug', $slug)->first();
    }
}
