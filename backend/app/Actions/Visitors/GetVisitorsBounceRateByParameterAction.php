<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\Visitors\BounceRateVisitors;
use App\Repositories\Contracts\TableVisitorsRepository;

final class GetVisitorsBounceRateByParameterAction
{
    const CITY = 'city';
    const COUNTRY = 'country';
    const LANGUAGE = 'language';
    const OS = 'operating_system';
    const BROWSER = 'browser';
    const SCREEN_RESOLUTION = 'screen_resolution';

    private $tableVisitorsRepository;

    public function __construct(TableVisitorsRepository $tableVisitorsRepository)
    {
        $this->tableVisitorsRepository = $tableVisitorsRepository;
    }

    public function execute(GetVisitorsBounceRateByParameterRequest $request): GetVisitorsBounceRateByParameterResponse
    {
        $parameter = $request->parameter();
        $websiteId = $request->websiteId();

        switch ($parameter) {
            case self::CITY:
                $visitorsCountCollection = collect($this->tableVisitorsRepository
                    ->getCountVisitorsGroupByCity($request->period(),$websiteId)
                    ->keyBy(self::CITY)
                    ->toArray()
                );
                $bounceRateCollection = collect($this->tableVisitorsRepository
                    ->getBounceRateGroupByCity($request->period(),$websiteId)
                    ->keyBy(self::CITY)
                    ->toArray()
                );
                break;
            case self::COUNTRY:
                $visitorsCountCollection = collect($this->tableVisitorsRepository
                    ->getCountVisitorsGroupByCountry($request->period(),$websiteId)
                    ->keyBy(self::COUNTRY)
                    ->toArray()
                );
                $bounceRateCollection = collect($this->tableVisitorsRepository
                    ->getBounceRateGroupByCountry($request->period(),$websiteId)
                    ->keyBy(self::COUNTRY)
                    ->toArray()
                );
                break;
            case self::LANGUAGE:
                $visitorsCountCollection = collect($this->tableVisitorsRepository
                    ->getCountVisitorsGroupByLanguage($request->period(), $websiteId)
                    ->keyBy(self::LANGUAGE)
                    ->toArray()
                );
                $bounceRateCollection = collect($this->tableVisitorsRepository
                    ->getBounceRateRateGroupByLanguage($request->period(), $websiteId)
                    ->keyBy(self::LANGUAGE)
                    ->toArray()
                );
                break;
            case self::BROWSER:
                $visitorsCountCollection = collect($this->tableVisitorsRepository
                    ->getCountVisitorsGroupByBrowser($request->period(), $websiteId)
                    ->keyBy(self::BROWSER)
                    ->toArray()
                );
                $bounceRateCollection = collect($this->tableVisitorsRepository
                    ->getBounceRateGroupByBrowser($request->period(), $websiteId)
                    ->keyBy(self::BROWSER)
                    ->toArray()
                );
                break;
            case self::OS:
                $visitorsCountCollection = collect($this->tableVisitorsRepository
                        ->getCountVisitorsGroupByOperatingSystem($request->period(), $websiteId)
                    ->keyBy(self::OS)
                    ->toArray()
                );
                $bounceRateCollection = collect($this->tableVisitorsRepository
                    ->getBounceRateGroupByOperatingSystem($request->period(), $websiteId)
                    ->keyBy(self::OS)
                    ->toArray()
                );
                break;
            case self::SCREEN_RESOLUTION:
                $visitorsCountCollection = collect($this->tableVisitorsRepository
                    ->getCountVisitorsRateGroupByScreenResolution($request->period(), $websiteId)
                    ->keyBy(self::SCREEN_RESOLUTION)
                    ->toArray()
                );
                $bounceRateCollection = collect($this->tableVisitorsRepository
                    ->getBounceRateGroupByScreenResolution($request->period(), $websiteId)
                    ->keyBy(self::SCREEN_RESOLUTION)
                    ->toArray()
                );
                break;
        }

        $collection = $visitorsCountCollection->mergeRecursive($bounceRateCollection);

        $response = $collection->map(function ($item) use ($parameter) {
            $bounce_rate = isset($item['bounced_visitors_count']) ? $item['bounced_visitors_count'] / $item['visitors_count'] : 0;
            return new BounceRateVisitors(
                $parameter,
                $item[$parameter],
                $bounce_rate
            );
        })->flatten();

        return new GetVisitorsBounceRateByParameterResponse($response);
    }
}

