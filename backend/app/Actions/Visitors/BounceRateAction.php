<?php
declare(strict_types=1);

namespace App\Actions\Visitors;


use App\Repositories\Contracts\ChartVisitorRepository;

final class BounceRateAction
{

    private $repository;

    public function __construct(ChartVisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(BounceRateRequest $request): BounceRateResponse
    {
        return new BounceRateResponse($this->repository->getBounceRateCollection($request->getFilterData()));
    }
}
