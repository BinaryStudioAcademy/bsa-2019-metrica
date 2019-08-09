<?php
declare(strict_types=1);

namespace App\Actions\Website;

use App\Entities\TrackingInfo;
use App\Entities\Website;
use App\Repositories\Contracts\EloquentTrackingInfoRepository;
use App\Repositories\Contracts\EloquentWebsiteRepository;
use Illuminate\Support\Facades\Auth;

class AddWebsiteAction
{
    private $websiteRepository;
    private $trackingInfoRepository;

    public function __construct(
        EloquentWebsiteRepository $websiteRepository,
        EloquentTrackingInfoRepository $trackingInfoRepository
    ) {
        $this->websiteRepository = $websiteRepository;
        $this->trackingInfoRepository = $trackingInfoRepository;
    }

    public function execute(AddWebsiteRequest $request): AddWebsiteResponse
    {
        $website = new Website();

        $website->name = $request->getName();
        $website->domain = $request->getDomain();
        $website->single_page = $request->getSinglePage();
        $website->user_id = Auth::id();

        $this->websiteRepository->save($website);

        return new AddWebsiteResponse($website);
    }
}
