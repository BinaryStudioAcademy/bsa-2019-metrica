<?php

declare(strict_types=1);

namespace App\Actions\Visits;

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
        $startDate = Carbon::createFromTimestampUTC(
            $request->period()->getStartDate()->getTimestamp()
        )->toDateTimeString();
        $endDate = Carbon::createFromTimestampUTC(
            $request->period()->getEndDate()->getTimestamp()
        )->toDateTimeString();

        switch ($request->parameter()) {
            case 'city':
                $visits = $this->tableVisitsRepository
                    ->groupByCity(
                        Auth::user()->website->id,
                        $startDate,
                        $endDate
                    );
                break;
            case 'country':
                $visits = $this->tableVisitsRepository
                    ->groupByCountry(
                        Auth::user()->website->id,
                        $startDate,
                        $endDate
                    );
                break;
            case 'language':
                $visits = $this->tableVisitsRepository
                    ->groupByLanguage(
                        Auth::user()->website->id,
                        $startDate,
                        $endDate
                    );
                break;
            case 'browser':
                $visits = $this->tableVisitsRepository
                    ->groupByBrowser(
                        Auth::user()->website->id,
                        $startDate,
                        $endDate
                    );
                break;
            case 'operating_system':
                $visits = $this->tableVisitsRepository
                    ->groupByOperatingSystem(
                        Auth::user()->website->id,
                        $startDate,
                        $endDate
                    );
                break;
            case 'screen_resolution':
                $visits = $this->tableVisitsRepository
                    ->groupByScreenResolution(
                        Auth::user()->website->id,
                        $startDate,
                        $endDate
                    );
                break;
            default:
                throw new AppInvalidArgumentException(sprintf('The parameter "%s" is not valid.', $request->parameter()));
        }

        return new GetPageViewsByParameterResponse($visits);
    }
}