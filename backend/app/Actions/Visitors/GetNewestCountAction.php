<?php
declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Support\Facades\Auth;

final class GetNewestCountAction
{
    private $repository;

    public function __construct(VisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetNewestCountRequest $request): ButtonValue
    {
        $websiteId = Auth::user()->website->id;
        return new ButtonValue((string)$this->repository->newestCount($request->getFilterData(),$websiteId));
    }
}
