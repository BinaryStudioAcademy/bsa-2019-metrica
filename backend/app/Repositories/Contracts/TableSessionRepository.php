<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(string $startDate, string $endDate, string $parameter): Collection;
}