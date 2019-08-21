<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\VisitorRepository;

final class GetNewestCountAction
{
    private $repository;

    public function __construct(VisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetNewestCountRequest $request): GetNewestCountResponse
    {
        return new GetNewestCountResponse($this->repository->newestCount($request->getFilterData()));
    }
}
