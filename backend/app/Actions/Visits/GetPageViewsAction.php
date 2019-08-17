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
        try{
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        if($request->getInterval() < 1) {
            throw new AppInvalidArgumentException('Interval must more 1000 ms');
        }


        $data = $this->visitRepository->findByFilter(
            $request->getFilterData(),
            $request->getInterval(),
            $websiteId
        );

        return new GetPageViewsResponse($data);
    }
}
