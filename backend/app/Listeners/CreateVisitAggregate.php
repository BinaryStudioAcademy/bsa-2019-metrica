<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\VisitCreated;
use App\Services\VisitorsFlow\FlowAggregateService;

class CreateVisitAggregate
{
    private $flowAggregateService;

    public function __construct(FlowAggregateService $flowAggregateService)
    {
        $this->flowAggregateService = $flowAggregateService;
    }

    public function handle(VisitCreated $event)
    {
        $this->flowAggregateService->aggregate($event->visit);
    }
}
