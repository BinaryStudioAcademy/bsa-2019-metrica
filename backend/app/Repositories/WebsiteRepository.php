<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Website;
use App\Repositories\Contracts\EloquentWebsiteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class WebsiteRepository implements EloquentWebsiteRepository
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
}
