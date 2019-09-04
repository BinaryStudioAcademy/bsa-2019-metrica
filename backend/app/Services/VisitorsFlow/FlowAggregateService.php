<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Aggregates\VisitorsFlow\CountryAggregate;
use App\Entities\Visit;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\CountryRepository;
use Carbon\Carbon;

final class FlowAggregateService
{
    private $pageRepository;
    private $visitRepository;
    private $countryRepository;
    private $websiteRepository;
    private $geoPositionRepository;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository,
        CountryRepository $countryRepository,
        WebsiteRepository $websiteRepository,
        GeoPositionRepository $geoPositionRepository
    )
    {
        $this->pageRepository = $pageRepository;
        $this->visitRepository = $visitRepository;
        $this->countryRepository = $countryRepository;
        $this->websiteRepository = $websiteRepository;
        $this->geoPositionRepository = $geoPositionRepository;
    }

    public function aggregate(Visit $visit)
    {
        $previousVisit = $this->getPreviousVisit($visit);
        $isFirstInSession = $previousVisit === null;
        if (!$isFirstInSession) {
            $level = $this->getVisitsCount($visit);
        } else {
            $level = 1;
        }
        $countryAggregate = $this->countryRepository->getByParams(
            $visit->session->website_id,
            $visit->page->url,
            $level
        );
        $countryAggregate = null;

        if (!$countryAggregate) {
            $countryAggregate = $this->createCountryAggregate($visit, $level, $previousVisit);
            $countryAggregate = $this->countryRepository->save($countryAggregate);
        }
    }

    private
    function getPreviousVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last(function (Visit $visit) use ($currentVisit) {
                return $currentVisit->id !== $visit->id;
            });
    }

    private
    function getVisitsCount(Visit $currentVisit): int
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)->count();
    }

    private
    function createCountryAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit): CountryAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $geoPosition = $this->geoPositionRepository->getById($currentVisit->geo_position_id);
        $nextPage = null;
        $prevPage = null;
        if ($level !== 1) {
            //сделать
        }

        $isLatPage = true;
        $views = 1;
        return new CountryAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $nextPage,
            $prevPage,
            $views,
            $level,
            $isLatPage,
            $geoPosition->country
        );
    }
}
