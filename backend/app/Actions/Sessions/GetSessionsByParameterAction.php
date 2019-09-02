<?php

namespace App\Actions\Sessions;

use App\Repositories\Contracts\TableSessionRepository;
use Illuminate\Support\Facades\Auth;
use App\Actions\Sessions\GetSessionsByParameterResponse;

class GetSessionsByParameterAction
{
    private $repository;

    public function __construct(TableSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetSessionsByParameterRequest $request)
    {
        $parameter = $request->parameter();
        $period = $request->period();
        $website_id = $request->websiteId();
        switch ($parameter) {
            case 'language':
                $sessions = $this->repository->groupByLanguage($website_id, $period);
                break;
            case 'browser':
                $sessions = $this->repository->groupByBrowser($website_id, $period);
                break;
            case 'operating_system':
                $sessions = $this->repository->groupByOs($website_id, $period);
                break;
            case 'screen_resolution':
                $sessions = $this->repository->groupByResolution($website_id, $period);
                break;
            case 'city':
                $sessions = $this->repository->groupByCity($website_id, $period);
                break;
            case 'country':
                $sessions = $this->repository->groupByCountry($website_id, $period);
                break;
        }
        return new GetSessionsByParameterResponse($sessions);
    }
}