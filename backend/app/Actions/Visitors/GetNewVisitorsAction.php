<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;

final class GetNewVisitorsAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetAllActivityVisitorRequest $request): GetNewVisitorsResponse
    {
        $visitors = $this->visitorRepository->newest()
                       ->filter(function($visitor) use($request) {
                            return $visitor->website_id == $request->websiteId();
                        });
        return new GetNewVisitorsResponse($visitors);
    }
}