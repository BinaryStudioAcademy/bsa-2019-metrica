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
                $request->period()
            );
        $allVisitors = $this->visitorRepository
            ->countVisitorsBetweenDate(
                $request->period()
            );

        if ($allVisitors === 0) {
            return new GetBounceRateResponse(0);
        }

        $bounceRate = $visitors/$allVisitors * 100;

        return new GetBounceRateResponse($bounceRate);
    }
}
