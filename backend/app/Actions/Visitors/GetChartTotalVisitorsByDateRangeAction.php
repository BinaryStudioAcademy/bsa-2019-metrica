<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\ChartValue;
use App\Repositories\Contracts\ChartVisitorRepository;
use Illuminate\Support\Facades\Auth;

final class GetChartTotalVisitorsByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetChartTotalVisitorsByDateRangeRequest $request)
    {
        $response = $this->repository->getTotalVisitorsByDateRange(
            $request->period(), $request->interval(), $request->websiteId()
        )->map(function ($item) {
            return new ChartValue($item->date(), $item->value());
        });

        return new GetChartTotalVisitorsByDateRangeResponse($response);
    }
}