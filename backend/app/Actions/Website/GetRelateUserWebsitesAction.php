<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Repositories\Contracts\WebsiteRepository;
use Illuminate\Support\Facades\Auth;

final class GetRelateUserWebsitesAction
{
    private $repository;

    public function __construct(WebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $id = Auth::id();
        $websites = $this->repository->getRelateUserWebsite($id);

        return new GetRelateUserWebsitesResponse($websites);

    }
}