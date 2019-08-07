<?php
declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Website;

interface EloquentWebsiteRepository
{
    public function save(Website $website): Website;
}
