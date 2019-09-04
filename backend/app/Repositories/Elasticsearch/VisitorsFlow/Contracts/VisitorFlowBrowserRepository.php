<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;

interface VisitorFlowBrowserRepository
{
    public function save(Aggregate $browserAggregate): Aggregate;

    public function update(Aggregate $browserAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?BrowserAggregate;
}
