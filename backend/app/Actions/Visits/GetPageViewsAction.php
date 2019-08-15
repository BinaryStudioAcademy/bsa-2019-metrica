<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Repositories\Contracts\VisitRepository;

final class GetPageViewsAction
{
    private $visitRepository;

    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function execute(): GetPageViewsResponse
    {
        $views = $this->visitRepository->getPageViews();

        return new GetPageViewsResponse($views);
    }
}