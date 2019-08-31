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

    public function groupByLanguage(int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->get(['id', 'language']);
        $session_count = $sessions->count();
        return $sessions->groupBy('language')
            ->map(function($item, $key) use ($session_count) {
                return new TableValue(
                    'language',
                    $key,
                    (string)$item->count(),
                    $item->count() / $session_count * 100
                );
            })->values();
    }

    public function groupByOs(int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['system:id,os'])
            ->get();
        $session_count = $sessions->count();
        return $sessions->groupBy('system.os')
            ->map(function($item, $key) use ($session_count) {
                return new TableValue(
                    'operating_system',
                    $key,
                    (string)$item->count(),
                    $item->count() / $session_count * 100
                );
            })->values();
    }

    public function groupByBrowser(int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['system:id,browser'])
            ->get();
        $session_count = $sessions->count();
        return $sessions->groupBy('system.browser')
            ->map(function($item, $key) use ($session_count) {
                return new TableValue(
                    'browser',
                    $key,
                    (string)$item->count(),
                    $item->count() / $session_count * 100
                );
            })->values();
    }

    public function groupByResolution(int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['system:id,resolution_width,resolution_height'])
            ->get();
        $sessions->each(function($item) {
            $item->setAttribute('resolution', "{$item->system->resolution_width}x{$item->system->resolution_height}");
        });
        $session_count = $sessions->count();
        return $sessions->groupBy('resolution')
            ->map(function($item, $key) use ($session_count) {
                return new TableValue(
                    'screen_resolution',
                    $key,
                    (string)$item->count(),
                    $item->count() / $session_count * 100
                );
            })->values();
    }

    public function groupByCity(int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['visit.geo_position:id,city'])
            ->get();
        $session_count = $sessions->count();
        return $sessions->groupBy('visit.geo_position.city')
            ->map(function($item, $key) use ($session_count) {
                return new TableValue(
                    'city',
                    $key,
                    (string)$item->count(),
                    $item->count() / $session_count * 100
                );
            })->values();
    }

    public function groupByCountry(int $website_id, DatePeriod $datePeriod): Collection
    {
        $sessions = Session::whereDateBetween($datePeriod)
            ->forWebsite($website_id)
            ->with(['visit.geo_position:id,country'])
            ->get();
        $session_count = $sessions->count();
        return $sessions->groupBy('visit.geo_position.country')
            ->map(function($item, $key) use ($session_count) {
                return new TableValue(
                    'country',
                    $key,
                    (string)$item->count(),
                    $item->count() / $session_count * 100
                );
            })->values();
    }
}
