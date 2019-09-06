<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\WidgetValue;
use App\Entities\Session;
use App\Entities\System;
use App\Repositories\Contracts\SystemRepository;
use App\Utils\DatePeriod;
use App\Entities\Website;
use Illuminate\Support\Facades\DB;

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

    public function getMostPopularSystems(int $website_id, DatePeriod $datePeriod)
    {
        $sessions = Website::find($website_id)
            ->sessions()
            ->whereDateBetween($datePeriod)
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
            ->sortByDesc(function ($item) {
                return $item->percent();
            })->take(2)
            ->values();
    }

    public function getDevicesStats(int $website_id, DatePeriod $datePeriod)
    {
        DB::enableQueryLog();
        $sessions = Website::find($website_id)
            ->sessions()
            ->whereDateBetween($datePeriod)
            ->join('systems', 'sessions.system_id', '=', 'systems.id')
            ->select(DB::raw('count (*) as count, LOWER(device) as device'))
            ->groupBy(DB::raw('LOWER(device)'))
            ->orderBy('count', 'desc')
            ->get();
        $session_count = $sessions->sum('count');
        return $sessions
            ->map(function($item) use ($session_count) {
                return new WidgetValue(
                    $item->device,
                    $item->count / $session_count * 100
                );
            })->take(3)
            ->values();
    }
}
