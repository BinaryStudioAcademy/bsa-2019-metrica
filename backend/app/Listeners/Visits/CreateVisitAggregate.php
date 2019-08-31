<?php

namespace App\Listeners\Visits;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Visits\VisitCreated;
use App\Repositories\Elasticsearch\PageViews\ElasticsearchTableRepository;
use App\Aggregates\PageViews\TableAggregate;
use App\Services\PageViews\TableAggregateService;

class CreateVisitAggregate
{
    private $aggregateService;

    public function __construct(TableAggregateService $aggregateService)
    {
        $this->aggregateService = $aggregateService;
    }

    public function handle(VisitCreated $event)
    {
        $this->aggregateService->aggregate($event->visit);
    }
}
