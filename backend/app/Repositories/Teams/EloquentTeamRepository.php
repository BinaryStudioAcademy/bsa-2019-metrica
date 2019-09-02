<?php

declare(strict_types=1);

namespace App\Repositories\Teams;

use app\Repositories\Contracts\Teams\TeamRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentTeamRepository implements TeamRepository
{
    public function getTeamMembers(int $websiteId): Collection
    {
        return DB::table('users')
            ->websites()
            ->wherePivot('website_id', '=', $websiteId)
            ->wherePivot('role', '=', 'member')
            ->select('name', 'email')
            ->get();
    }
}