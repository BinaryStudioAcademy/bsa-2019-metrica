<?php
declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Website;
use App\Entities\User;
use Illuminate\Support\Collection;

interface WebsiteRepository
{
    public function save(Website $website): Website;
    public function getById(int $id): Website;
    public function getByTrackNumber(int $id): ?Website;
    public function setWebsiteOwner(User $user, int $websiteId): void;
    public function addTeamMemberToWebsite(User $user, int $websiteId): void;
    public function removeMemberFromWebsiteTeam(User $user): Website;
    public function getRelateUserWebsites(int $userId): Collection;
    public function getUsersWithPermittedMenu(int $websiteId): Collection;
    public function getRelateUserWebsite(int $userId, int $websiteId): Website;
}
