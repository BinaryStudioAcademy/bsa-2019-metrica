<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use Illuminate\Support\Facades\Auth;

final class GetAverageTimingAction
{
    private $repository;

    public function __construct(ButtonDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAverageTimingRequest $request): ButtonValue
    {
        $website_id = $request->websiteId();
        $period = $request->period();
        $column = $request->column();

        $average = $this->repository
            ->getAverageTiming($period, $website_id, $column);
        return new ButtonValue((string)$average);
    }
}
