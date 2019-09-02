<?php

declare(strict_types = 1);

namespace App\Actions\Website;

use App\Exceptions\UserWebsiteNotFoundException;
use App\Repositories\Contracts\WebsiteRepository;
use App\Actions\Website\GetcurrentWebsiteRequest;

final class GetCurrentUserWebsiteAction
{
    private $repository;

    public function __construct(WebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetcurrentWebsiteRequest $request): GetCurrentUserWebsiteResponse
    {
        $id = $request->getId();

        if ($id === 0) {
            $website = $this->repository->getFirstExistingUserWebsite();
        } else {
            $website = $this->repository->getCurrentWebsite($id);
        }

        return new GetCurrentUserWebsiteResponse($website);
    }
}