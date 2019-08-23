<?php


namespace App\Actions\Visitors;

use App\DataTransformer\ButtonValue;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Support\Facades\Auth;
use App\Actions\Visitors\CreateVisitorResponse;

class CreateVisitorAction
{
    private $repository;

    public function __construct(VisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $websiteId = Auth::user()->website->id;

        $visitorId = $this->repository->save($websiteId)->id;

        return new CreateVisitorResponse($visitorId);
    }
}
