<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Repositories\Contracts\ErrorReport\ErrorReportRepository;
use Illuminate\Support\Facades\Auth;

class GetErrorTableItemsAction
{
    const COUNTRY = 'country';
    const BROWSER = 'browser';
    const PAGE = 'page';

    private $repository;

    public function __construct(ErrorReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetErrorTableItemsRequest $request): GetErrorTableItemsResponse
    {
        $period = $request->period();
        $parameter = $request->parameter();
        $website_id = Auth::user()->website->id;

        switch ($parameter) {
            case self::PAGE:
                $errors = $this->repository->getErrorItemsGroupByPage($website_id, $period);
                break;
        }

        return new GetErrorTableItemsResponse($errors);
    }
}
