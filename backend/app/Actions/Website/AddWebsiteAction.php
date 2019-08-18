<?php
declare(strict_types=1);

namespace App\Actions\Website;

use App\Entities\Website;
use App\Repositories\Contracts\WebsiteRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddWebsiteAction
{
    private $websiteRepository;

    public function __construct(
        WebsiteRepository $websiteRepository
    ) {
        $this->websiteRepository = $websiteRepository;
    }

    public function execute(AddWebsiteRequest $request): AddWebsiteResponse
    {
        $website = new Website();

        $website->name = $request->getName();
        $website->domain = $request->getDomain();
        $website->single_page = $request->getSinglePage();
        $website->user_id = Auth::id();
        $website->tracking_number = $this->getLastTrackingNumber() + 1;

        $this->websiteRepository->save($website);

        return new AddWebsiteResponse($website);
    }

    private function getLastTrackingNumber(): int
    {
        $last = DB::table('websites')->latest('tracking_number')->first();

        return $last ? $last->tracking_number : 0;
    }
}
