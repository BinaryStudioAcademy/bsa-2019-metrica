<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Repositories\Contracts\SessionRepository;
use App\Actions\Sessions\GetAvgSessionRequest;

final class GetAvgSessionAction
{
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function execute(GetAvgSessionRequest $request): GetAvgSessionResponse
    {

        $avgSessionInSeconds = $this->sessionRepository->getAvgSession($request);

        return new GetAvgSessionResponse($avgSessionInSeconds);
    }
}