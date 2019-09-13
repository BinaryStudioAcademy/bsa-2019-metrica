<?php
declare(strict_types=1);

namespace App\Events;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;


class UpdatePrevious extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aggregate;
    public $repository;


    public function __construct(VisitorFlowRepository $repository, Aggregate $aggregate)
    {
        $this->aggregate = $aggregate;
        $this->repository = $repository;
    }
}
