<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\ButtonValue;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsAvgTimeAction
{
    private $repository;

    public function __construct(ButtonDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPageViewsAvgTimeRequest $request): ButtonValue
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }

        return new ButtonValue((string)$this->repository->getAvgTimeOnPageBetweenDate($request->period(), $websiteId));
    }
}
