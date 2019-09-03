<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Http\Resources\SpeedOverviewTableResource;
use App\Repositories\Contracts\PageViews\TableDataRepository;
use Illuminate\Support\Facades\Auth;

class GetAverageTimingAction
{
    private $repository;

    public function __construct(TableDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAverageTimingRequest $request, string $value)
    {
        $period = $request->period();
        $parameter = $request->parameter();
        $website_id = Auth::user()->website->id;

        $result = null;
        switch($parameter) {
            case 'browser':
                $result = $this->repository->getAverageValueByBrowser($period, $website_id, $value);
                break;
            case 'country':
                $result = $this->repository->getAverageValueByCountry($period, $website_id, $value);
                break;
            case 'page':
                $result = $this->repository->getAverageValueByPage($period, $website_id, $value);
                break;
        }
        return $result;
    }
}
