<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Support\Facades\Auth;
use App\Actions\Visitors\GetAllActivityVisitorRequest;

final class GetAllActivityVisitorAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetAllActivityVisitorRequest $request): GetAllActivityVisitorResponse
    {
        $websiteId = $request->websiteId();

        $visitors = $this->visitorRepository->getAllActivityVisitors($websiteId);

        return new GetAllActivityVisitorResponse($visitors);
    }
}
