<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\ButtonVisitorsRepository;
use Illuminate\Support\Facades\Auth;

final class GetButtonCountVisitorsAction
{
    private $repository;

    public function __construct(ButtonVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetButtonCountVisitorsRequest $request)
    {
        $websiteId = $request->websiteId();
        $count = $this->repository->getVisitorsCount($request->period(), $websiteId, Auth::user()->id);
        return new ButtonValue((string) $count);
    }
}
