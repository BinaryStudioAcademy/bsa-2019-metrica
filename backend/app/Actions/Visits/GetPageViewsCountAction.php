<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\ButtonValue;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsCountAction
{
    private $repository;

    public function __construct(ButtonDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPageViewsCountRequest $request): ButtonValue
    {
        $websiteId = $request->websiteId();

        return new ButtonValue((string)$this->repository->countBetweenDate($request->period(), $websiteId));
    }
}
