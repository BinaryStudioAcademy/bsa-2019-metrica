<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Repositories\Contracts\ErrorReport\ErrorReportRepository;
use Illuminate\Support\Facades\Auth;

class GetErrorTableItemsAction
{
    private $repository;

    public function __construct(ErrorReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetErrorTableItemsRequest $request): GetErrorTableItemsResponse
    {
        $period = $request->period();
        $website_id = $request->websiteId();

        $errors = $this->repository->getErrorItemsGroupByPage($website_id, $period);

        return new GetErrorTableItemsResponse($errors);
    }
}
