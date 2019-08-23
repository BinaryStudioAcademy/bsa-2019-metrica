<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\VisitorRepository;

final class GetBounceRateAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetBounceRateRequest $request): ButtonValue
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
            return new ButtonValue((string)0);
        }

        $bounceRate = round($visitors / $allVisitors * 100, 2);

        return new ButtonValue((string)$bounceRate);
    }
}
