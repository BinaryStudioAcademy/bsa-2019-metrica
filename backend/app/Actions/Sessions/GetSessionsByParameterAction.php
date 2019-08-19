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
        $sessions = $this->repository->groupByParameter(
            $request->parameter(),
            Auth::user()->website->id,
            $request->period()
        );

        return new GetSessionsByParameterResponse($sessions);
    }
}