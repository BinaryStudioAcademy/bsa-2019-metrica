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

    public function execute(GetBounceRateRequest $request): GetBounceRateResponse
    {
        $visitors = $this->visitorRepository
            ->countSinglePageInactiveSessionBetweenDate(
                $request->startDate(),
                $request->endDate()
            );
        $allVisitors = $this->visitorRepository
            ->countVisitorsBetweenDate(
                $request->startDate(),
                $request->endDate()
            );

        $bounceRate = $visitors/$allVisitors * 100;

        return new GetBounceRateResponse($bounceRate);
    }
}