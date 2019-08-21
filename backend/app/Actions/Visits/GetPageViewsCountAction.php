<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\ButtonDataPageViews;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsCountAction
{
    private $repository;

    public function __construct(ButtonDataPageViews $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPageViewsCountRequest $request): GetPageViewsCountResponse
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        return new GetPageViewsCountResponse($this->repository->countBetweenDate($request->period(), $websiteId));
    }
}
