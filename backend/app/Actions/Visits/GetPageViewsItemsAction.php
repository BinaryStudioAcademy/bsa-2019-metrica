<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Repositories\Contracts\TablePageViewsRepository;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsItemsAction
{
    private $visitRepository;

    public function __construct(TablePageViewsRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function execute(GetPageViewsItemsRequest $request): GetPageViewsItemsResponse
    {
        $from = $request->startDate();
        $to = $request->endDate();
        $websiteId = Auth::user()->website->id;

        $tableData = $this->visitRepository->getPageViewsTableData($from, $to, $websiteId);

        return new GetPageViewsItemsResponse($tableData);
    }
}