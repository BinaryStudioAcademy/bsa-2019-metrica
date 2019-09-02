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
            ->select('name', 'email')
            ->whereHas('websites', function ($q) use ($websiteId) {
                $q->where('id', '=', $websiteId);
            })
            ->find($websiteId)
            ->users()
            ->wherePivot('roles', 'member')
            ->get();
//            ->has('us')
//            ->join('users', 'users_id')
//            ->join('user_role', 'websites.user_id', '=', 'user_role.user_id')
//            ->select()
//            ->where('user_role.role_id', '=', 2)
    }
}