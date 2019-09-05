<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\DeviceAggregate;

interface VisitorFlowDeviceRepository extends VisitorFlowRepository
{
    public function save(Aggregate $deviceAggregate): Aggregate;

    public function update(Aggregate $deviceAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?DeviceAggregate;
}
