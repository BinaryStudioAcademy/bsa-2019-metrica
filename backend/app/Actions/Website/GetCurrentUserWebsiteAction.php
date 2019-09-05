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

    public function execute(string $websiteId): GetCurrentUserWebsiteResponse
    {
        if ((int)$websiteId === 0) {
            $website = $this->repository->getFirstExistingUserWebsite();
            return new GetCurrentUserWebsiteResponse($website);
        }

        $website = $this->repository->getCurrentWebsite((int)$websiteId);
        return new GetCurrentUserWebsiteResponse($website);
    }
}