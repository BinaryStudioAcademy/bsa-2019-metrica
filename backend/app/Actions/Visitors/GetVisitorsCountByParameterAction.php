<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Support\Facades\Auth;

final class GetVisitorsCountByParameterAction
{
    private $tableVisitorsRepository;

    public function __construct(TableVisitorsRepository $tableVisitorsRepository)
    {
        $this->tableVisitorsRepository = $tableVisitorsRepository;
    }

    public function execute(GetVisitorsCountByParameterRequest $request): GetVisitorsCountByParameterResponse
    {
        switch ($request->parameter()) {
            case 'city':
                $visitors = $this->tableVisitorsRepository
                    ->groupByCity(
                        $request->websiteId(),
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'country':
                $visitors = $this->tableVisitorsRepository
                    ->groupByCountry(
                        $request->websiteId(),
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'language':
                $visitors = $this->tableVisitorsRepository
                    ->groupByLanguage(
                        $request->websiteId(),
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'browser':
                $visitors = $this->tableVisitorsRepository
                    ->groupByBrowser(
                        $request->websiteId(),
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'operating_system':
                $visitors = $this->tableVisitorsRepository
                    ->groupByOperatingSystem(
                        $request->websiteId(),
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'screen_resolution':
                $visitors = $this->tableVisitorsRepository
                    ->groupByScreenResolution(
                        $request->websiteId(),
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
        }

        return new GetVisitorsCountByParameterResponse($visitors);
    }
}

