<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\VisitorsBounceRateFilterData;
use App\Entities\Visitor;
use App\Model\Visitors\VisitorsBounceRateResponseItem;
use App\Repositories\Contracts\ChartVisitorRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class EloquentChartVisitorRepository implements ChartVisitorRepository
{
    public function getBounceRateCollection(VisitorsBounceRateFilterData $filterData): Collection
    {
        $from = $filterData->getStartDate();
        $to = $filterData->getEndDate();
        $timeFrame = $filterData->getTimeFrame();
        $allVisitorsByTimeFrame = Visitor::whereCreatedAtBetween($from, $to)
            ->selectRaw('COUNT (*)')
            ->selectRaw(' (extract(epoch FROM created_at) - MOD( (CAST (extract(epoch FROM created_at) AS INTEGER)), ? )) AS period', [$timeFrame])
            ->groupBy('period')
            ->get();


        $allVisitorsByTimeFrameValues = array_column($allVisitorsByTimeFrame->toArray(), 'count', 'period');

        $bounceVisitorsByTimeFrame =  Visitor::whereCreatedAtBetween($from, $to)
            ->has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($from, $to) {
                $query->whereBetween('start_session', [$from, $to])
                    ->has('visits', '=', '1');
            })
            ->selectRaw('COUNT (*)')
            ->selectRaw(' (extract(epoch FROM created_at) - MOD( (CAST (extract(epoch FROM created_at) AS INTEGER)), ? )) AS period', [$timeFrame])
            ->groupBy('period')
            ->get();

        $bounceVisitorsByTimeFrameValues = array_column($bounceVisitorsByTimeFrame->toArray(), 'count', 'period');

        $start = $from->getTimestamp() - ($from->getTimestamp()%$timeFrame);
        $end = $to->getTimestamp() - ($to->getTimestamp()%$timeFrame);
        $collection = new Collection();
        do {
            $all = $allVisitorsByTimeFrameValues[$start]??0;
            $bounced = $bounceVisitorsByTimeFrameValues[$start]??0;
            $rate = ($all === 0) ? 0 : ($bounced / $all);
            $collection->add(new VisitorsBounceRateResponseItem($start, $rate));
        } while (($start+=$timeFrame)<=$end);

        return $collection;
    }
}
