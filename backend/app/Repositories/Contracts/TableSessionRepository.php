<?php

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Collection;

interface TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(DatePeriod $datePeriod, string $parameter): Collection;
}