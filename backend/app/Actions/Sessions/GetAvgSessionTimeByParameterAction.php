<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Repositories\Contracts\TableSessionRepository;

final class GetAvgSessionTimeByParameterAction
{
    private $repository;

    public function __construct(TableSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAvgSessionTimeByParameterRequest $request): GetAvgSessionTimeByParameterResponse
    {
        $avgSessionsTimeCollection = $this->repository->getAvgSessionsTimeByParameter(
            $request->period(),
            $request->parameter()
        );

        return new GetAvgSessionTimeByParameterResponse($avgSessionsTimeCollection);
    }
}