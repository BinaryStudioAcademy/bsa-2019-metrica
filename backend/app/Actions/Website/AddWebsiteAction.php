<?php
declare(strict_types=1);

namespace App\Actions\Website;

use App\Entities\Website;
use App\Repositories\Contracts\EloquentWebsiteRepository;
use Illuminate\Support\Facades\Auth;

class AddWebsiteAction
{
    private $websiteRepository;

    public function __construct(
        EloquentWebsiteRepository $websiteRepository
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

        $this->websiteRepository->save($website);

        return new AddWebsiteResponse($website);
    }
}
