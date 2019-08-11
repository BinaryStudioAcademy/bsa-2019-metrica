<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Website;
use App\Repositories\Contracts\WebsiteRepository;

final class EloquentWebsiteRepository implements WebsiteRepository
{
    public function save(Website $website): Website
    {
        $website->save();

        return $website;
    }
}