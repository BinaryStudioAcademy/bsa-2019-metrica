<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableNewVisitorsRepository;
use Illuminate\Support\Facades\Auth;
use App\DataTransformer\TableValue;

final class GetNewVisitorsCountAction
{
    private $tableNewVisitorsRepository;

    public function __construct(TableNewVisitorsRepository $tableNewVisitorsRepository)
    {
        $this->tableNewVisitorsRepository = $tableNewVisitorsRepository;
    }

    public function execute(GetNewVisitorsCountRequest $request): GetVisitorsByParameterResponse
    {
        $parameter = $request->parameter();
        $arguments = [
            (int)Auth::user()->website->id,
            $request->startDate(),
            $request->endDate()
        ];

        switch ($parameter) {
            case 'city':
                $visitors = $this->tableNewVisitorsRepository->groupByCity(...$arguments);
                break;
            case 'country':
                $visitors = $this->tableNewVisitorsRepository->groupByCountry(...$arguments);
                break;
            case 'language':
                $visitors = $this->tableNewVisitorsRepository->groupByLanguage(...$arguments);
                break;
            case 'browser':
                $visitors = $this->tableNewVisitorsRepository->groupByBrowser(...$arguments);
                break;
            case 'operating_system':
                $visitors = $this->tableNewVisitorsRepository->groupByOperatingSystem(...$arguments);
                break;
            case 'screen_resolution':
                $visitors = $this->tableNewVisitorsRepository->groupByScreenResolution(...$arguments);
                break;
        }

        $formattedVisitors = $visitors->map(function ($visitor) use ($parameter) {
            return new TableValue(
                $parameter,
                (string)$visitor->parameter_value,
                (string)$visitor->total,
                (float)$visitor->percentage
            );
        });

        return new GetVisitorsByParameterResponse($formattedVisitors);
    }
}

