<?php

namespace App\Actions\System;

use App\Repositories\Contracts\SystemRepository;

class GetMostPopularOsAction
{
    private $repository;

    public function __construct(SystemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetMostPopularOsRequest $request)
    {
        $period = $request->period();
        $website_id = $request->websiteId();
        $systems = $this->repository->getMostPopularSystems($website_id, $period);
        return new GetMostPopularOsResponse($systems);
    }
}
