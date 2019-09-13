<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\VisitCreated;
use App\Services\VisitorsFlow\FlowBrowserAggregateService;
use App\Services\VisitorsFlow\FlowCountryAggregateService;
use App\Services\VisitorsFlow\FlowDeviceAggregateService;
use App\Services\VisitorsFlow\FlowScreenAggregateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateVisitAggregate implements ShouldQueue
{
    private $flowCountryAggregateService;
    private $flowBrowserAggregateService;
    private $flowDeviceAggregateService;
    private $flowScreenAggregateService;

    public function __construct(
        FlowCountryAggregateService $flowCountryAggregateService,
        FlowBrowserAggregateService $flowBrowserAggregateService,
        FlowDeviceAggregateService $flowDeviceAggregateService,
        FlowScreenAggregateService $flowScreenAggregateService
    ) {
        $this->flowCountryAggregateService = $flowCountryAggregateService;
        $this->flowBrowserAggregateService = $flowBrowserAggregateService;
        $this->flowDeviceAggregateService = $flowDeviceAggregateService;
        $this->flowScreenAggregateService = $flowScreenAggregateService;
    }

    public function handle(VisitCreated $event)
    {
            $this->flowCountryAggregateService->aggregate($event->visit);
//            $this->flowBrowserAggregateService->aggregate($event->visit);
//            $this->flowDeviceAggregateService->aggregate($event->visit);
//            $this->flowScreenAggregateService->aggregate($event->visit);
    }

}
