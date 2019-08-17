<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TableVisitorRepository
{
    public function getAvgSessionsTimeByParameter(string $startDate, string $endDate, string $parameter): Collection;
}