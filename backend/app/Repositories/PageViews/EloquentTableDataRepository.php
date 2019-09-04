<?php

declare(strict_types=1);

namespace App\Repositories\PageViews;

use App\Contracts\Common\DatePeriod;
use App\DataTransformer\SpeedOverviewTableValue;
use App\Entities\Website;
use App\Repositories\Contracts\PageViews\TableDataRepository;
use Illuminate\Support\Collection;

class EloquentTableDataRepository implements TableDataRepository
{
    public function getAverageTimingByBrowser(DatePeriod $period, int $website_id, string $value): Collection
    {
        $res = Website::find($website_id)
            ->visits()
            ->whereDateBetween($period)
            ->select('visits.id', 'visits.session_id', 'visits.' . $value)
            ->with(['session' => function($query) {
                $query->select('sessions.id', 'sessions.system_id')
                    ->with('system:id,browser');
            }])
            ->get();

        return $res->groupBy('session.system.browser')
            ->map(function($item, $key) use ($value) {
                return new SpeedOverviewTableValue(
                    'browser',
                    $key,
                    intval($item->average($value))
                );
            })->sortByDesc(function(SpeedOverviewTableValue $item) {
                return $item->timing();
            })
            ->values();
    }

    public function getAverageValueByCountry(DatePeriod $period, int $website_id, string $value): Collection
    {
        $res = Website::find($website_id)
            ->visits()
            ->whereDateBetween($period)
            ->select('visits.id', 'visits.geo_position_id', 'visits.' . $value)
            ->with('geo_position:id,country')
            ->get();

        return $res->groupBy('geo_position.country')
            ->map(function($item, $key) use ($value) {
                return new SpeedOverviewTableValue(
                    'country',
                    $key,
                    intval($item->average($value))
                );
            })->sortByDesc(function(SpeedOverviewTableValue $item) {
                return $item->timing();
            })
            ->values();
    }

    public function getAverageValueByPage(DatePeriod $period, int $website_id, string $value): Collection
    {
        $res = Website::find($website_id)
            ->visits()
            ->whereDateBetween($period)
            ->select('visits.id', 'visits.' . $value, 'visits.page_id')
            ->with('page:id,url')
            ->get();
        return $res->groupBy('page.url')
            ->map(function($item, $key) use ($value) {
                return new SpeedOverviewTableValue(
                    'page',
                    $key,
                    intval($item->average($value))
                );
            })->sortByDesc(function(SpeedOverviewTableValue $item) {
                return $item->timing();
            })
            ->values();
    }
}
