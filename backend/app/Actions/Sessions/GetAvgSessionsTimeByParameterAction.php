<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Repositories\Contracts\TableSessionRepository;

final class GetAvgSessionsTimeByParameterAction
{
    private $repository;

    public function __construct(TableSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAvgSessionsTimeByParameterRequest $request): GetAvgSessionsTimeByParameterResponse
    {
        $avgSessionsTimeCollection = $this->repository->getAvgSessionsTimeByParameter(
            $request->startDate(),
            $request->endDate(),
            $request->parameter()
        );

        return new GetAvgSessionsTimeByParameterResponse($avgSessionsTimeCollection);
    }
}