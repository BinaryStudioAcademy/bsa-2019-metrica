<?php

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

interface TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(DatePeriod $datePeriod, string $parameter): Collection;
}