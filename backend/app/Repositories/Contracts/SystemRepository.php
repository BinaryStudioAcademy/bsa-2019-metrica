<?php

namespace App\Repositories\Contracts;

use App\Entities\System;
use App\Utils\DatePeriod;

interface SystemRepository
{
    public function getByParameters(
        string $operatingSystem,
        string $device,
        string $browser,
        int $resolutionHeight,
        int $resolutionWidth
    ): ?System;

    public function save(System $system): System;

    public function getMostPopularSystems(int $website_id, DatePeriod $period);

    public function getDevicesStats(int $website_id, DatePeriod $period);
}
