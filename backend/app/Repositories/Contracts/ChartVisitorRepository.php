<?php

namespace App\Repositories\Contracts;

use App\Contracts\Visitors\VisitorsBounceRateFilterData;
use Illuminate\Support\Collection;

interface ChartVisitorRepository
{
    public function getBounceRateCollection(VisitorsBounceRateFilterData $filterData): Collection;
}
