<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\WidgetValue;
use App\Entities\Session;
use App\Entities\System;
use App\Repositories\Contracts\SystemRepository;
use App\Utils\DatePeriod;

final class EloquentSystemRepository implements SystemRepository
{
    public function getByParameters(
        string $operatingSystem,
        string $device,
        string $browser,
        int $resolutionHeight,
        int $resolutionWidth
    ): ?System {
        return System::where([
            ['os', $operatingSystem],
            ['device', $device],
            ['browser', $browser],
            ['resolution_height', $resolutionHeight],
            ['resolution_width', $resolutionWidth]
        ])->first();
    }

    public function save(System $system): System
    {
        $system->save();
        return $system;
    }

    public function getMostPopularSystems(int $website_id, DatePeriod $datePeriod) {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['system:id,os'])
            ->get();
        $session_count = $sessions->count();
        return $sessions->groupBy('system.os')
            ->map(function($item, $key) use ($session_count) {
                return new WidgetValue(
                    $key,
                    $item->count() / $session_count * 100
                );
            })
            ->sortByDesc(function ($item){
                return $item->percent();
            })->take(2)
            ->values();
    }

    public function getDevicesStats(int $website_id, DatePeriod $datePeriod) {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['system:id,device'])
            ->get();
        $session_count = $sessions->count();
        return $sessions->groupBy('system.device')
            ->map(function($item, $key) use ($session_count) {
                return new WidgetValue(
                    $key,
                    $item->count() / $session_count * 100
                );
            })
            ->sortByDesc(function ($item){
                return $item->percent();
            })->take(3)
            ->values();
    }
}
