<?php

namespace App\Actions\System;

use App\Repositories\Contracts\SystemRepository;

class GetDeviceTypeStatsAction
{
    private $repository;

    public function __construct(SystemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetDeviceTypeStatsRequest $request): GetDeviceTypeStatsResponse
    {
        $period = $request->period();
        $website_id = $request->websiteId();
        $devices = $this->repository->getDevicesStats($website_id, $period);
        return new GetDeviceTypeStatsResponse($devices);
    }
}
