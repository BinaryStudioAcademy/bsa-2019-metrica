<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;

final class GetAllVisitorsAction
{
    private $visitorRepository;
    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }
    public function execute(GetAllActivityVisitorRequest $request): GetAllVisitorsResponse
    {
        $visitors = $this->visitorRepository->all()
                        ->filter(function($visitor) use ($request) {
                            return $visitor->website_id == $request->websiteId();
                        });
        return new GetAllVisitorsResponse($visitors);
    }
}