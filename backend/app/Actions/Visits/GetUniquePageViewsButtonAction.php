<?php
declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\ButtonValue;
use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use Illuminate\Support\Facades\Auth;

class GetUniquePageViewsButtonAction
{
    private $repository;

    public function __construct(ButtonDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUniquePageViewsButtonRequest $request): ButtonValue
    {
        $websiteId = $request->websiteId();

        $response = $this->repository->uniqueCount($request->period(), $websiteId);
        return new ButtonValue((string)$response);
    }
}
