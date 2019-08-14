<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\VisitorsBounceRateFilterData;
use App\Entities\Visitor;
use App\Repositories\Contracts\ChartVisitorRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class EloquentChartVisitorRepository implements ChartVisitorRepository
{

    public function getBounceRateCollection(VisitorsBounceRateFilterData $filterData): Collection
    {
        $from = $filterData->getStartDate();
        $to = $filterData->getEndDate();

        $allVisitorsByTimeFrame = Visitor::whereCreatedAtBetween($from, $to)
            ->selectRaw('COUNT (*)')
            ->selectRaw(' (extract(epoch FROM created_at) - MOD( (CAST (extract(epoch FROM created_at) AS INTEGER)), ? )) AS period', [$filterData->getTimeFrame()])
            ->groupBy('period')
            ->get();



        $bounceVisitorsByTimeFrame =  Visitor::whereCreatedAtBetween($from, $to)
            ->has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($from, $to) {
                $query->whereBetween('start_session', [$from, $to])
                    ->has('visits', '=', '1');
            })
            ->selectRaw('COUNT (*)')
            ->selectRaw(' (extract(epoch FROM created_at) - MOD( (CAST (extract(epoch FROM created_at) AS INTEGER)), ? )) AS period', [$filterData->getTimeFrame()])
            ->groupBy('period')
            ->get();
        return new Collection();
    }
}
