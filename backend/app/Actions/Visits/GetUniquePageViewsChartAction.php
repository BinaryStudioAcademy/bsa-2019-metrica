<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartVisitRepository;
use Illuminate\Support\Facades\Auth;

class GetUniquePageViewsChartAction
{
    private $repository;

    public function __construct(ChartVisitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUniquePageViewsChartRequest $request): GetUniquePageViewsChartResponse
    {
        $websiteId = $request->websiteId();

        $response = $this->repository->getUniquePageViews(
            $request->period(),
            (int)$request->interval(),
            $websiteId);

        return new GetUniquePageViewsChartResponse($response);
    }
}
