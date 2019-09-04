<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Entities\Website;
use App\Repositories\Contracts\WebsiteRepository;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Collection;
use App\DataTransformer\Teams\MemberWithMenuItems;

final class EloquentWebsiteRepository implements WebsiteRepository
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(Website $website): Website
    {
        $website->save();

        return $website;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Website
    {
        return Website::findOrFail($id);
    }

    public function getByTrackNumber(int $trackNumber): ?Website
    {
        try {
            return Website::where('tracking_number', $trackNumber)->firstOrFail();
        } catch (\Exception $e) {
            throw new WebsiteNotFoundException;
        }
    }

    public function getCurrentWebsite(int $websiteId): Website
    {
        $userWebsitesIds = $this->userRepository
                                ->getAllUserWebsites(auth()->id())
                                ->pluck('id');

        if ($userWebsitesIds->contains($websiteId)) {
            return $this->getById($websiteId);
        }

        throw new WebsiteNotFoundException;
    }

    public function getFirstExistingUserWebsite(): Website
    {
        $userWebsites = $this->userRepository->getAllUserWebsites(auth()->id());

        $firstOwnWebsite = $userWebsites->filter(function($website) {
            return $website->pivot->role === 'owner';
        })->first();

        if ($firstOwnWebsite) {
            return $firstOwnWebsite;
        }

        $firstTeamMemberWebsite = $userWebsites->filter(function($website) {
            return $website->pivot->role === 'member';
        })->first();

        if ($firstTeamMemberWebsite) {
            return $firstTeamMemberWebsite;
        }

        throw new WebsiteNotFoundException;
    }

    public function setWebsiteOwner(User $user, int $websiteId): void
    {
        $user->websites()->attach($websiteId, [
            'role' => 'owner']
        );
    }

    public function addTeamMemberToWebsite(User $user, int $websiteId): void
    {
        $user->websites()->attach($websiteId, [
            'role' => 'member'
        ]);
    }

    public function removeMemberFromWebsiteTeam(User $user, int $websiteId): void
    {
        $user->websites()->detach($websiteId);
    }

    public function getUsersWithPermittedMenu(int $websiteId): Collection
    {
        return Website::find($websiteId)
                    ->users()
                    ->wherePivot('role', 'member')
                    ->get()
                    ->map(function($member) use ($websiteId) {
                        $menuItems = explode(', ', $member->pivot->permitted_menu);
                        return new MemberWithMenuItems($member->id, $websiteId, $menuItems);
                      });
    }

}
