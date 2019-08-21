<?php

namespace App\Repositories\Contracts;

use App\Entities\System;

interface SystemRepository
{
    public function getByParameters(
        string $operatingSystem,
        string $device,
        string $browser,
        string $resolutionHeight,
        string $resolutionWidth
    ): ?System;
}
