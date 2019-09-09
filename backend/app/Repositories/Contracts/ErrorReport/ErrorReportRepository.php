<?php

namespace App\Repositories\Contracts\ErrorReport;

use Illuminate\Support\Collection;
use App\Entities\Error;

interface ErrorReportRepository
{
    public function save(Error $visitor): Error;

    public function getErrorsCountByDate(
        string $startData,
        string $endData,
        string $interval,
        int $websiteId
    ): Collection;
}
