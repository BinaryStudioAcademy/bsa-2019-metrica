<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\PageViews\ChartDataRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Actions\Visits\GetPageViewsChartResponse;

final class GetPageViewsChartAvgTimeAction
{
    private $repository;

    public function __construct(ChartDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPageViewsAvgTimeRequest $request): GetPageViewsChartResponse
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        $chartData = $this->repository->getChartAvgTimeOnPageBetweenDate(
            $request->period(), (int)$request->interval(), $websiteId
        );

        return new GetPageViewsChartResponse($chartData);
    }
}
