<?php
declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Website;

interface WebsiteRepository
{
    public function save(Website $website): Website;
}
