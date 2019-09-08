<?php

namespace App\Repositories\Contracts\ErrorReport;

use App\Entities\Error;
use Illuminate\Support\Collection;
use App\Utils\DatePeriod;

interface ErrorReportRepository
{
    public function save(Error $visitor): Error;

    public function getErrorItemsGroupByPage (int $websiteId, DatePeriod $datePeriod): Collection;
}
