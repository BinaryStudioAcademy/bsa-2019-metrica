<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\ButtonValue;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use Illuminate\Support\Facades\Auth;

final class GetBounceRatePageViewsButtonAction
{
    private $repository;

    public function __construct(ButtonDataRepository $repository)
    {
        $this->repository = $repository;
    }
    public function execute(GetBounceRatePageViewsButtonRequest $request): ButtonValue
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }
        $allPageViewsCount = $this->repository->getCountPageViewsPageBetweenDate($request->period(), $websiteId);
        $bouncedPageViewsCount = $this->repository->getBouncedPagePageBetweenDate($request->period(), $websiteId);

        $response = (int)(($allPageViewsCount === 0) ? 0 : ($bouncedPageViewsCount/$allPageViewsCount*100));

        return new ButtonValue((string)$response);
    }
}