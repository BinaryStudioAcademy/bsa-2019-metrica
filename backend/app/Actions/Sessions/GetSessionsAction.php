<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Exceptions\AppInvalidArgumentException;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ChartSessionsRepository;
use Illuminate\Support\Facades\Auth;

final class GetSessionsAction
{
    private $sessionsRepository;

    public function __construct(ChartSessionsRepository $sessionsRepository)
    {
        $this->sessionsRepository = $sessionsRepository;
    }

    public function execute(GetSessionsRequest $request): GetSessionsRequest
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        $interval = $this->getInterval($request->interval());

        if ($interval < 1) {
            throw new AppInvalidArgumentException('Interval must more 500 ms');
        }

        $data = $this->sessionsRepository->findByFilter(
            $request->period(),
            $interval,
            $websiteId
        );

        return new GetSessionsResponse($data);
    }

    private function getInterval(string $interval): int
    {
        return (int) \round($interval/1000, 0);
    }
}