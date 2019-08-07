<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Website;
use App\Repositories\Contracts\EloquentWebsiteRepository;

final class WebsiteRepository implements EloquentWebsiteRepository
{
    public function save(Website $website): Website
    {
        $website->save();

        return $website;
    }
}
