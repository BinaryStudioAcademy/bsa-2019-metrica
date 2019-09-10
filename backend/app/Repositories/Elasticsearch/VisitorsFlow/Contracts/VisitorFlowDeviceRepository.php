<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\DeviceAggregate;
use App\DataTransformer\VisitorsFlow\ParameterFlowCollection;
use App\DataTransformer\VisitorsFlow\ParametersCollection;

interface VisitorFlowDeviceRepository extends VisitorFlowRepository
{
    public function save(Aggregate $deviceAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?DeviceAggregate;

    public function getFlow(int $websiteId, int $level): ParameterFlowCollection;

    public function getViewsByEachDevice(string $type, int $websiteId): ParametersCollection;
}
