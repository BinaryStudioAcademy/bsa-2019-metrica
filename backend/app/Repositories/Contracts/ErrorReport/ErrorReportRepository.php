<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\ErrorReport;

use Illuminate\Support\Collection;
use App\Entities\Error;
use Illuminate\Support\Collection;
use App\Utils\DatePeriod;

interface ErrorReportRepository
{
    public function save(Error $visitor): Error;

    public function getErrorItemsGroupByPage (int $websiteId, DatePeriod $datePeriod): Collection;

    public function getErrorsCountByDate(
        string $startData,
        string $endData,
        string $interval,
        int $websiteId
    ): Collection;
}
