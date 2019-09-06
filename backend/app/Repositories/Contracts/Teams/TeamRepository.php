<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\Teams;

use Illuminate\Support\Collection;

interface TeamRepository
{
    public function getTeamMembers(int $websiteId): Collection;
    public function updatePermittedMenu(int $websiteId, Collection $updateMenuLinks): Collection;
}