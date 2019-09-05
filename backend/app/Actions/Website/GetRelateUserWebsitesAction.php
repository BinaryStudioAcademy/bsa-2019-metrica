<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\DataTransformer\WebsiteValue;
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

        return new GetRelateUserWebsitesResponse($websites->map(function($item) {
            return new WebsiteValue($item->id, $item->domain, $item->role);
        }));

    }
}