<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\Visits\VisitDensityItem;
use App\Repositories\Contracts\VisitRepository;
use Illuminate\Support\Facades\Auth;

final class GetVisitsDensityAction
{
    private $repository;

    public function __construct(VisitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetVisitsDensityRequest $request): GetVisitsDensityResponse
    {
        $websiteId = Auth::user()->website->id;
        $response = $this->repository->getVisitsCountByHourAndDay(
            $request->startDate(),
            $request->endDate(),
            $websiteId
        );

        $response = $response->map(function ($item) {
            return new VisitDensityItem(
                (int) $item->day,
                (int) $item->hour,
                $item->visits
            );
        });

        return new GetVisitsDensityResponse($response);
    }
}