<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartVisitRepository;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsAction
{
    private $visitRepository;

    public function __construct(ChartVisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function execute(GetPageViewsRequest $request): GetPageViewsResponse
    {
        $websiteId = $request->websiteId();

        $interval = $this->getInterval($request->interval());

        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval must more 1 s');
        }

        $data = $this->visitRepository->findByFilter(
            $request->period(),
            $interval,
            $websiteId
        );

        return new GetPageViewsResponse($data);
    }

    private function getInterval(string $interval): int
    {
        return (int) $interval;
    }
}
