<?php

namespace App\Listeners\Visitors;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Visitors\VisitorCreated;
use App\Repositories\ElasticSearch\ElasticSearchVisitorsRepository;
 
class CreateVisitorAggregate
{
    private $repository;

    public function __construct(ElasticSearchVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(VisitorCreated $event)
    {
        $this->repository->save($event->visitor);
    }
}
