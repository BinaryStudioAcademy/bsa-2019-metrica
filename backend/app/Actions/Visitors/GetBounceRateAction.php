<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;

final class GetBounceRateAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(): GetBounceRateResponse
    {
        $visitors = $this->visitorRepository->withSinglePageInactiveSession()->count();
        $allVisitors = $this->visitorRepository->all()->count();

        $bounceRate = $visitors/$allVisitors * 100;

        return new GetBounceRateResponse($bounceRate);
    }
}