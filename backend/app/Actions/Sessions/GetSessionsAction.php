<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

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

    public function execute(GetSessionsRequest $request)
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        $result = $this->sessionsRepository->findByFilter($request->period(), (int)$request->interval(), $websiteId);
        return new GetSessionsResponse($result);
    }
}
