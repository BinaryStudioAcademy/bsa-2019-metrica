<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;

final class GetNewVisitorsAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(): GetNewVisitorsResponse
    {
        $visitors = $this->visitorRepository->newest();
        return new GetNewVisitorsResponse($visitors);
    }
}