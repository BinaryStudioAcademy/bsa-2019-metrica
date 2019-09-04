<?php

declare(strict_types=1);

namespace App\Repositories\Teams;

use App\Entities\Website;
use app\Repositories\Contracts\Teams\TeamRepository;
use Illuminate\Support\Collection;

final class EloquentTeamRepository implements TeamRepository
{
    public function getTeamMembers(int $websiteId): Collection
    {
        return Website::find($websiteId)->users()
            ->wherePivot('role', '=', 'member')
            ->get(['users.id', 'name', 'email']);
    }
}