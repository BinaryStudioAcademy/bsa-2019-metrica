<?php

declare(strict_types=1);

namespace App\Actions\PageTimings;

use App\Repositories\Contracts\PageViews\TableDataRepository;
use Illuminate\Support\Facades\Auth;

class GetAverageTimingByParamAction
{
    private $repository;

    public function __construct(TableDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAverageTimingByParamRequest $request)
    {
        $period = $request->period();
        $parameter = $request->parameter();
        $website_id = Auth::user()->website->id;
        $value = $request->column();

        $result = null;
        switch($parameter) {
            case 'browser':
                $result = $this->repository->getAverageTimingByBrowser($period, $website_id, $value);
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
