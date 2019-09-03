<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\TableValue;
use App\Exceptions\AppInvalidArgumentException;
use App\Repositories\Contracts\TableVisitRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsByParameterAction
{
    private $tableVisitsRepository;

    public function __construct(TableVisitRepository $tableVisitRepository)
    {
        $this->tableVisitsRepository = $tableVisitRepository;
    }

    public function execute(GetPageViewsByParameterRequest $request): GetPageViewsByParameterResponse
    {
        switch ($request->parameter()) {
            case 'city':
                $visits = $this->tableVisitsRepository
                    ->groupByCity(
                        $request->websiteId(),
                        $request->period()
                    );
                break;
            case 'country':
                $visits = $this->tableVisitsRepository
                    ->groupByCountry(
                        $request->websiteId(),
                        $request->period()
                    );
                break;
            case 'language':
                $visits = $this->tableVisitsRepository
                    ->groupByLanguage(
                        $request->websiteId(),
                        $request->period()
                    );
                break;
            case 'browser':
                $visits = $this->tableVisitsRepository
                    ->groupByBrowser(
                        $request->websiteId(),
                        $request->period()
                    );
                break;
            case 'operating_system':
                $visits = $this->tableVisitsRepository
                    ->groupByOperatingSystem(
                        $request->websiteId(),
                        $request->period()
                    );
                break;
            case 'screen_resolution':
                $visits = $this->tableVisitsRepository
                    ->groupByScreenResolution(
                        $request->websiteId(),
                        $request->period()
                    );
                break;
            default:
                throw new AppInvalidArgumentException(sprintf('The parameter "%s" is not valid.', $request->parameter()));
        }

        return new GetPageViewsByParameterResponse($visits->map(function ($item) {
            return new TableValue($item->parameter(), $item->parameterValue(), $item->total(), $item->percentage());
        }));
    }
}