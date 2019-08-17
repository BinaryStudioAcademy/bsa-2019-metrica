<?php


namespace App\Contracts\Visitors;

use App\Contracts\Common\DatePeriod;
use App\Contracts\Common\DateTimeFrame;

interface VisitorsBounceRateFilterData extends DatePeriod, DateTimeFrame
{
}
