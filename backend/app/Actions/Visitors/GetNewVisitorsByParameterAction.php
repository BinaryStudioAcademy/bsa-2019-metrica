<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\TableNewVisitorsRepository;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Auth;
use App\DataTransformer\TableValue;

final class GetNewVisitorsByParameterAction
{
    private $tableNewVisitorsRepository;

    public function __construct(TableNewVisitorsRepository $tableNewVisitorsRepository)
    {
        $this->tableNewVisitorsRepository = $tableNewVisitorsRepository;
    }

    public function execute(GetNewVisitorsByParameterRequest $request): GetVisitorsCountByParameterResponse
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
            default:
                throw new InvalidArgumentException(sprintf('The parameter "%s" is not valid.', $parameter));
        }

        $formattedVisitors = $visitors->map(function ($visitor) use ($parameter) {
            return new TableValue(
                $parameter,
                (string)$visitor->parameter_value,
                (string)$visitor->total,
                (float)$visitor->percentage
            );
        });

        return new GetVisitorsCountByParameterResponse($formattedVisitors);
    }
}

