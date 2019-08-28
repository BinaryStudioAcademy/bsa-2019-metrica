<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\Visitors\BounceRateVisitors;
use App\Repositories\Contracts\TableVisitorsRepository;

final class GetVisitorsBounceRateByParameterAction
{
    private $tableVisitorsRepository;

    public function __construct(TableVisitorsRepository $tableVisitorsRepository)
    {
        $this->tableVisitorsRepository = $tableVisitorsRepository;
    }

    public function execute(GetVisitorsBounseRateByParameterRequest $request): GetVisitorsBounseRateByParameterResponce
    {
        $parameter = $request->parameter();
        switch ($parameter) {
            case 'city':
                $visitorsCountCollection = collect(
                    $this->tableVisitorsRepository
                    ->getCountVisitorsGroupByCity(
                        $request->period()
                    )
                    ->keyBy('city')
                    ->toArray()
                );
                $bounceRateCollection = collect(
                    $this->tableVisitorsRepository
                    ->getBounceRateGroupByCity(
                        $request->period()
                    )
                    ->keyBy('city')
                    ->toArray()
                );
                break;
            case 'country':
                $visitorsCountCollection = collect(
                    $this->tableVisitorsRepository
                    ->getCountVisitorsGroupByCountry(
                        $request->period()
                    )
                    ->keyBy('country')
                    ->toArray()
                );
                $bounceRateCollection = collect(
                    $this->tableVisitorsRepository
                    ->getBounceRateGroupByCountry(
                        $request->period()
                    )
                    ->keyBy('country')
                    ->toArray()
                );
                break;
            case 'language':
                $visitorsCountCollection = collect(
                    $this->tableVisitorsRepository
                    ->getCountVisitorsGroupByLanguage(
                        $request->period()
                    )
                    ->keyBy('language')
                    ->toArray()
                );
                $bounceRateCollection = collect(
                    $this->tableVisitorsRepository
                    ->getBounceRateRateGroupByLanguage(
                        $request->period()
                    )
                    ->keyBy('language')
                    ->toArray()
                );
                break;
            case 'browser':
                $visitorsCountCollection = collect(
                    $this->tableVisitorsRepository
                    ->getCountVisitorsGroupByBrowser(
                        $request->period()
                    )
                    ->keyBy('browser')
                    ->toArray()
                );
                $bounceRateCollection = collect(
                    $this->tableVisitorsRepository
                    ->getBounceRateGroupByBrowser(
                        $request->period()
                    )
                    ->keyBy('browser')
                    ->toArray()
                );
                break;
            case 'operating_system':
                $visitorsCountCollection = collect(
                    $this->tableVisitorsRepository
                    ->getCountVisitorsGroupByOperatingSystem(
                        $request->period()
                    )
                    ->keyBy('operating_system')
                    ->toArray()
                );
                $bounceRateCollection = collect(
                    $this->tableVisitorsRepository
                    ->getBounceRateGroupByOperatingSystem(
                        $request->period()
                    )
                    ->keyBy('operating_system')
                    ->toArray()
                );
                break;
            case 'screen_resolution':
                $visitorsCountCollection = collect(
                    $this->tableVisitorsRepository
                    ->getCountVisitorsRateGroupByScreenResolution(
                        $request->period()
                    )
                    ->keyBy('screen_resolution')
                    ->toArray()
                );
                $bounceRateCollection = collect(
                    $this->tableVisitorsRepository
                    ->getBounceRateGroupByScreenResolution(
                        $request->period()
                    )
                    ->keyBy('screen_resolution')
                    ->toArray()
                );
                break;
        }

        $collection = $visitorsCountCollection->mergeRecursive($bounceRateCollection);

        $response = $collection->map(function ($item) use ($parameter){
            return new BounceRateVisitors(
                $parameter,
                $item[$parameter],
                isset($item['bounced_visitors_count']) ? $item['visitors_count'] / $item['bounced_visitors_count'] : 0
            );
        })->flatten();

        return new GetVisitorsBounseRateByParameterResponce($response);
    }
}

