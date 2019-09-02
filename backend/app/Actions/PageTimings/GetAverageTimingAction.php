<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use App\Actions\ButtonDataRequest;
use Illuminate\Support\Facades\Auth;

final class GetAverageTimingAction
{
    private $repository;

    public function __construct(ButtonDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ButtonDataRequest $request, $parameter): ButtonValue
    {
        $website_id = Auth::user()->website->id;
        $period = $request->period();

        $average = $this->repository
            ->getAverageTiming($period, $website_id, $parameter);
        return new ButtonValue(number_format($average));
    }
}
