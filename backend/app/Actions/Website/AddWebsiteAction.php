<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Repositories\Contracts\WebsiteRepository;
use App\Entities\Website;
use App\Actions\Website\AddWebsiteRequest;
use App\Actions\Website\AddWebsiteResponse;


final class AddWebsiteAction
{
    private $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    public function execute(AddWebsiteRequest $request): AddWebsiteResponse
    {
        $website = new Website();
        $website->name = $request->getName();
        $website->domain = $request->getDomain();
        $website->single_page = $request->getSinglePage();
        $website->tracking_number = $request->getTrackingNumber();
        $website->user_id = auth('jwt')->id();

        $this->websiteRepository->save($website);

        return new AddWebsiteResponse($website);
    }
}
