<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;

interface TablePageViewsRepository
{
    public function getCountPageViewsByPage(string $from, string $to, int $pageId): int;

    public function getCountBounceRateByPage(string $from, string $to, int $pageId): int;
}