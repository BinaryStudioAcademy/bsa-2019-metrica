<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Support\Facades\Auth;

final class GetVisitorsByParameterAction
{
    private $tableVisitorsRepository;

    public function __construct(TableVisitorsRepository $tableVisitorsRepository)
    {
        $this->tableVisitorsRepository = $tableVisitorsRepository;
    }

    public function execute(GetVisitorsByParameterRequest $request): GetVisitorsByParameterResponse
    {
        switch ($request->parameter()) {
            case 'city':
                $visitors = $this->tableVisitorsRepository
                    ->groupByCity(
                        Auth::user()->website->id,
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'country':
                $visitors = $this->tableVisitorsRepository
                    ->groupByCountry(
                        Auth::user()->website->id,
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'language':
                $visitors = $this->tableVisitorsRepository
                    ->groupByLanguage(
                        Auth::user()->website->id,
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'browser':
                $visitors = $this->tableVisitorsRepository
                    ->groupByBrowser(
                        Auth::user()->website->id,
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'operating_system':
                $visitors = $this->tableVisitorsRepository
                    ->groupByOperatingSystem(
                        Auth::user()->website->id,
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'screen_resolution':
                $visitors = $this->tableVisitorsRepository
                    ->groupByScreenResolution(
                        Auth::user()->website->id,
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
        }



        return new GetVisitorsByParameterResponse($visitors);
    }
}

