<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface TablePageViewsRepository
{
    public function getPageViewsTableData(string $from, string $to, int $websiteId): Collection;
}