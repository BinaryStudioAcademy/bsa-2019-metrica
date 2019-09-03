<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\Contracts\Aggregate;

class VisitorsFlowAggregate implements Aggregate
{
    public $url;
    public $nextPage;
    public $prevPage;
    public $count;
    public $level;
    public $isLastPage;

    public function toArray(): array
    {
    }

}
