<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Actions\Visits\GetPageViewsRequest;
use App\Repositories\Contracts\ChartVisitRepository;

final class GetPageViewsAction
{
    private $visitRepository;

    public function __construct(ChartVisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function execute(GetPageViewsRequest $request): GetPageViewsResponse
    {
        return new GetPageViewsResponse($this->visitRepository->findByFilter($request->getFilterData(), $request->getInterval()));
    }
}
