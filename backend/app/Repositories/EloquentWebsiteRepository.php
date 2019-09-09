<?php
declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Websites\WebsitesRelateToUser;
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

    public function setWebsiteOwner(User $user, int $websiteId): void
    {
        $user->websites()->attach($websiteId, [
            'role' => 'owner',
            'permitted_menu' => config('sidebar.partial_access_menu_items')
            ]);
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

    public function getRelateUserWebsites(int $userId): Collection
    {
        return User::find($userId)->websites()
            ->withPivot('role', 'permitted_menu')
            ->get()
            ->map(function($website) {
                return new WebsitesRelateToUser(
                    $website->id,
                    $website->name,
                    $website->domain,
                    $website->single_page,
                    $website->tracking_number,
                    $website->pivot->role,
                    $website->pivot->permitted_menu
                );
            });
    }

    public function getRelateUserWebsite(int $userId, int $websiteId): Website
    {
        $website = User::find($userId)->websites()
            ->where('website_id', $websiteId)
            ->withPivot('role', 'permitted_menu')
            ->first();
        $website->role = $website->pivot->role;
        $website->permitted_menu = $website->pivot->permitted_menu;

        return $website;
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
