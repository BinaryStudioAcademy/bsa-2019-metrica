<?php

namespace App\Contracts\Sessions;

use App\Contracts\Common\DatePeriod;
use App\Contracts\Common\DateTimeFrame;

interface AverageSessionByIntervalFilterData extends DatePeriod, DateTimeFrame
{
}
