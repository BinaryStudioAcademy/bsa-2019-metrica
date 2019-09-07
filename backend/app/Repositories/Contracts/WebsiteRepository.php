<?php
declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Website;

interface WebsiteRepository
{
    public function save(Website $website): Website;
    public function getById(int $id): Website;
    public function getByTrackNumber(string $id): ?Website;
}
