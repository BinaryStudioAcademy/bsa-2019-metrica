<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;

interface ChartPageTimingRepository
{
    public function getAvgPageLoadByDateRange(DatePeriod $datePeriod, string $period): array ;
    public function getAvgServerResponseByDateRange(DatePeriod $datePeriod, string $period): array ;
    public function getAvgDomainLookupByDateRange(DatePeriod $datePeriod, string $period): array ;
}
