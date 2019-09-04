<?php

declare(strict_types = 1);

namespace App\Actions\Website;

use App\Repositories\Contracts\WebsiteRepository;

final class GetCurrentUserWebsiteAction
{
    private $repository;

    public function __construct(WebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $websiteId): GetCurrentUserWebsiteResponse
    {
        if ($websiteId === 0) {
            $website = $this->repository->getFirstExistingUserWebsite();
            return new GetCurrentUserWebsiteResponse($website);
        }

        $website = $this->repository->getCurrentWebsite($websiteId);
        return new GetCurrentUserWebsiteResponse($website);
    }
}