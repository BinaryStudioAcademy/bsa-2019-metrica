<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableVisitorsRepository;
use http\Exception\InvalidArgumentException;

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
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'country':
                $visitors = $this->tableVisitorsRepository
                    ->groupByCountry(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'language':
                $visitors = $this->tableVisitorsRepository
                    ->groupByLanguage(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'browser':
                $visitors = $this->tableVisitorsRepository
                    ->groupByBrowser(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'operating_system':
                $visitors = $this->tableVisitorsRepository
                    ->groupByOperatingSystem(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            case 'screen_resolution':
                $visitors = $this->tableVisitorsRepository
                    ->groupByScreenResolution(
                        $request->startDate(),
                        $request->endDate()
                    );
                break;
            default:
                throw new InvalidArgumentException(sprintf('The parameter "%s" is not valid.', $request->parameter()));
        }



        return new GetVisitorsByParameterResponse($visitors);
    }
}

