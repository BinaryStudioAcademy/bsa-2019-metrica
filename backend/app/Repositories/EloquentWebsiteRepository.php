<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Website;
use App\Repositories\Contracts\WebsiteRepository;
use App\Exceptions\WebsiteNotFoundException;

final class EloquentWebsiteRepository implements WebsiteRepository
{
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
        $userWebsitesIds = auth()->user()
                                ->websites
                                ->pluck('id');

        if ($userWebsitesIds->contains($websiteId)) {
            return $this->getById($websiteId);
        } else {
            throw new WebsiteNotFoundException;
        }
    }

    public function getFirstExistingUserWebsite(): Website
    {
        $userWebsites = auth()->user()->websites;

        $firstOwnWebsite = $userWebsites->filter(function($website) {
            return $website->pivot->role == 'owner';
        })->first();

        if ($firstOwnWebsite) {
            return $firstOwnWebsite;
        } else {
            $firstTeamMemberWebsite = $userWebsites->filter(function($website) {
                return $website->pivot->role == 'member';
            })->first();
        }

        if ($firstTeamMemberWebsite) {
            return $firstTeamMemberWebsite;
        } else {
            throw new WebsiteNotFoundException;
        }
    }
}
