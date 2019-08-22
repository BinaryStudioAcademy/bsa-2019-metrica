<?php

namespace App\Repositories\Contracts;

use App\Entities\System;

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
}
