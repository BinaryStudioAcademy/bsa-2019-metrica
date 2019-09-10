<?php

declare(strict_types=1);

namespace App\Repositories\Teams;

use App\Entities\Website;
use App\Repositories\Contracts\Teams\TeamRepository;
use Illuminate\Support\Collection;
use App\DataTransformer\Teams\MemberWithMenuItems;

final class EloquentTeamRepository implements TeamRepository
{
    public function getTeamMembers(int $websiteId): Collection
    {
        return Website::find($websiteId)->users()
            ->wherePivot('role', '=', 'member')
            ->get(['users.id', 'name', 'email']);
    }

    public function updatePermittedMenu(int $websiteId, Collection $updateMenuLinks): Collection
    {
        return Website::find($websiteId)
                ->users
                ->map(function($user) use ($updateMenuLinks, $websiteId) {
                    if ($updateMenuLinks->has($user->id)) {
                        $user->websites()
                             ->wherePivot('role', 'member')
                             ->updateExistingPivot($websiteId, [
                                'permitted_menu' => $updateMenuLinks[$user->id]
                            ]);
                        $menuLinks = explode(', ', $updateMenuLinks[$user->id]);
                        return new MemberWithMenuItems($user->id, $websiteId, $menuLinks);
                    }
                })->filter(function($item) {
                    return $item !== null;
                });
    }
}