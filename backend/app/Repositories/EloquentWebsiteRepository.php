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
}
