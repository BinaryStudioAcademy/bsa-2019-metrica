<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;
use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\BrowserCriteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowCountryRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\CountryCriteria;
use Carbon\Carbon;

final class FlowAggregateService
{
    private $pageRepository;
    private $visitRepository;
    private $visitorFlowCountryRepository;
    private $websiteRepository;
    private $geoPositionRepository;
    private $visitorFlowBrowserRepository;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository,
        VisitorFlowCountryRepository $visitorFlowCountryRepository,
        WebsiteRepository $websiteRepository,
        GeoPositionRepository $geoPositionRepository,
        VisitorFlowBrowserRepository $visitorFlowBrowserRepository
    )
    {
        $this->pageRepository = $pageRepository;
        $this->visitRepository = $visitRepository;
        $this->visitorFlowCountryRepository = $visitorFlowCountryRepository;
        $this->websiteRepository = $websiteRepository;
        $this->geoPositionRepository = $geoPositionRepository;
        $this->visitorFlowBrowserRepository = $visitorFlowBrowserRepository;
    }

    public function aggregate(Visit $visit)
    {
        $previousVisit = $this->getLastVisit($visit);
        $isFirstInSession = $previousVisit === null;
        if (!$isFirstInSession) {
            $level = $this->getVisitsCount($visit);
        } else {
            $level = 1;
        }
        $countryAggregate = $this->visitorFlowCountryRepository->getByCriteria(
            CountryCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $visit->geo_position->country,
                $isFirstInSession ? 'null' : $previousVisit->page->url
            )
        );
        $browserAggregate = $this->visitorFlowBrowserRepository->getByCriteria(
            BrowserCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $visit->session->system->browser,
                $isFirstInSession ? 'null' : $previousVisit->page->url
            )
        );
        if (!$countryAggregate) {
            $countryAggregate = $this->createCountryAggregate($visit, $level, $previousVisit);
            $countryAggregate = $this->visitorFlowCountryRepository->save($countryAggregate);
        } else {
            $countryAggregate->views++;
            $countryAggregate = $this->visitorFlowCountryRepository->update($countryAggregate);
        }

        if (!$browserAggregate) {
            $browserAggregate = $this->createBrowserAggregate($visit, $level, $previousVisit);
            $browserAggregate = $this->visitorFlowBrowserRepository->save($browserAggregate);
            dd($browserAggregate);
        } else {
            $browserAggregate->views++;
            $browserAggregate = $this->visitorFlowBrowserRepository->update($browserAggregate);
            dd($browserAggregate);
        }
    }

    private function getLastVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last(function (Visit $visit) use ($currentVisit) {
                return $currentVisit->id !== $visit->id;
            });
    }

    private function getPreviousVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)
            ->filter(function (Visit $visit) use ($currentVisit) {
                return (new Carbon($currentVisit->visit_time))->greaterThan(new Carbon($visit->visit_time));
            })
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last();
    }

    private function getVisitsCount(Visit $currentVisit): int
    {
        return $this->visitRepository->findBySessionId($currentVisit->session_id)->count();
    }

    private function createCountryAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit): CountryAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $geoPosition = $this->geoPositionRepository->getById($currentVisit->geo_position_id);
        $prevPage = new PageValue();
        if ($level !== 1) {

            $previousAggregate = $this->visitorFlowCountryRepository->getByCriteria(
                CountryCriteria::getCriteria(
                    $previousVisit->session->website_id,
                    $previousVisit->page->url,
                    $level - 1,
                    $previousVisit->geo_position->country,
                    $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null'
                )
            );
            $previousAggregate->isLastPage = false;
            $previousAggregate->exitCount--;
            $this->visitorFlowCountryRepository->update($previousAggregate);
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->url);
        }

        $isLatPage = true;
        $exitCount = 1;
        $views = 1;
        return new CountryAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLatPage,
            $exitCount,
            $geoPosition->country,
            $prevPage
        );
    }

    private function createBrowserAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit): BrowserAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $prevPage = new PageValue();
        if ($level !== 1) {
            $previousAggregate = $this->visitorFlowBrowserRepository->getByCriteria(
                BrowserCriteria::getCriteria(
                    $previousVisit->session->website_id,
                    $previousVisit->page->url,
                    $level - 1,
                    $currentVisit->session->system->browser,
                    $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null'
                )
            );
            $previousAggregate->isLastPage = false;
            $previousAggregate->exitCount--;
            $this->visitorFlowBrowserRepository->update($previousAggregate);
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->url);
        }
        $exitCount = 1;
        $isLatPage = true;
        $views = 1;
        return new BrowserAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLatPage,
            $exitCount,
            $currentVisit->session->system->browser,
            $prevPage
        );
    }
}
