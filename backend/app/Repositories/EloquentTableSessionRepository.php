<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Sessions\TableSession;
use App\Entities\Session;
use App\DataTransformer\TableValue;
use App\Repositories\Contracts\TableSessionRepository;
use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

final class EloquentTableSessionRepository implements TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(DatePeriod $datePeriod, string $parameter): Collection
    {
        return Session::whereDateBetween($datePeriod)
            ->avgSessionTime()
            ->groupByParameter($parameter)
            ->calculateAvgSessionTimePercentage()
            ->get()
            ->map(function (Session $session) use ($parameter) {
                return new TableSession(
                    $parameter,
                    $session->parameter_value,
                    $session->avg_session_time,
                    $session->avg_session_time_percentage
                );
            });
    }

    public function groupByParameter(string $parameter, int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
        ->forWebsite($website_id)
        ->with([
                'system:id,os,browser,resolution_width,resolution_height',
                'visit.geo_position:id,country,city'
            ])
        ->get();
        $sessions->each(function($item) {
            $item->setAttribute('city', $item->visit->geo_position->city);
            $item->setAttribute('country', $item->visit->geo_position->country);
            $item->setAttribute('screen_resolution', "{$item->system->resolution_width}x{$item->system->resolution_height}");
            $item->setAttribute('browser', $item->system->browser);
            $item->setAttribute('operating_system', $item->system->os);
        });
        $session_count = $sessions->count();
        return $sessions->groupBy($parameter)
            ->map(function($item, $key) use ($session_count, $parameter) {
                return new TableValue(
                    $parameter,
                    $key,
                    strval($item->count()),
                    $item->count() / $session_count * 100
                );
            })->values();
    }
}