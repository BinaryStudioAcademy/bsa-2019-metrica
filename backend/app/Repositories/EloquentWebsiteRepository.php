<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Website;
use App\Repositories\Contracts\WebsiteRepository;
use App\Exceptions\UserWebsiteNotFoundException;

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

    public function getCurrentWebsite(): ?Website
    {
        try {
            $websiteId = auth()->user()->website->id;
            return Website::findOrFail($websiteId);
        } catch (\Exception $e) {
            throw new UserWebsiteNotFoundException;
        }
    }

}
