<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\System;
use App\Repositories\Contracts\SystemRepository;

final class EloquentSystemRepository implements SystemRepository
{
    public function getByParameters(
        string $operatingSystem,
        string $device,
        string $browser,
        string $resolutionHeight,
        string $resolutionWidth
    ): ?System {
        return System::where([
            ['os', $operatingSystem],
            ['device', $device],
            ['browser', $browser],
            ['resolution_height', $resolutionHeight],
            ['resolution_width', $resolutionWidth]
        ])->first();
    }
}
