<?php

declare(strict_types=1);

namespace App\Actions\GeoLocation;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Support\Facades\Auth;

final class GetAllVisitorsCountAction
{
    private $visitorRepository;

    public function __construct(TableVisitorsRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetAllVisitorsCountRequest $request): GetAllVisitorsCountResponse
    {
        $websiteId = Auth::user()->website->id;
        $countAllVisitors = $this->visitorRepository->groupByCountry($websiteId, $request->startDate(), $request->endDate());

        return new GetAllVisitorsCountResponse($countAllVisitors);
    }
}