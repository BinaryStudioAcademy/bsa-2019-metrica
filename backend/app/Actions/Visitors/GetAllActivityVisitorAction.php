<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Support\Facades\Auth;

final class GetAllActivityVisitorAction
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(): GetAllActivityVisitorResponse
    {
        try {
            $websiteId = Auth::user()->website->id;
        } catch (\Exception $exception) {
            throw new WebsiteNotFoundException();
        }
        $visitors = $this->visitorRepository->getAllActivityVisitors($websiteId);

        return new GetAllActivityVisitorResponse($visitors);
    }
}
