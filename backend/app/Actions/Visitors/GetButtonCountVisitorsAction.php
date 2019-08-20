<?php


namespace App\Actions\Visitors;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\ButtonVisitorsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetButtonCountVisitorsAction
{
    private $repository;

    public function __construct(ButtonVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetButtonCountVisitorsRequest $request)
    {
        $websiteId = Auth::user()->website->id;
        $count = $this->repository->getVisitorsCount($request->period(), $websiteId, Auth::user()->id);
        return new ButtonValue($count);
    }
}
