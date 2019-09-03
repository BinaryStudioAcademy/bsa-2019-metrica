<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\PageViews;

use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;

interface TableDataRepository
{
    public function getAverageValueByBrowser(DatePeriod $period, int $website_id, string $value): Collection;

    public function getAverageValueByCountry(DatePeriod $period, int $website_id, string $value): Collection;

    public function getAverageValueByPage(DatePeriod $period, int $website_id, string $value): Collection;
}
