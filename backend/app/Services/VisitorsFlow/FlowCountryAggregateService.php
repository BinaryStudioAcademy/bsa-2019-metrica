<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;
use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowCountryRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\CountryCriteria;

final class FlowCountryAggregateService extends FlowAggregateService
{
    private $pageRepository;
    private $visitRepository;
    private $visitorFlowCountryRepository;
    private $websiteRepository;
    private $geoPositionRepository;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository,
        VisitorFlowCountryRepository $visitorFlowCountryRepository,
        WebsiteRepository $websiteRepository,
        GeoPositionRepository $geoPositionRepository
    ) {
        parent::__construct($visitRepository);
        $this->pageRepository = $pageRepository;
        $this->visitRepository = $visitRepository;
        $this->visitorFlowCountryRepository = $visitorFlowCountryRepository;
        $this->websiteRepository = $websiteRepository;
        $this->geoPositionRepository = $geoPositionRepository;
    }

    public function aggregate(Visit $visit): void
    {
        $previousVisit = $this->getPreviousVisit($visit);
        $isFirstInSession = $previousVisit === null;
        $level = $this->getLevel($visit, $isFirstInSession);
        $nextVisit = $this->getNextVisit($visit);
        $countryAggregate = $this->getAggregate($visit, $level, $isFirstInSession, $previousVisit);

        $this->updateAggregate($visit, $level, $previousVisit, $countryAggregate, $nextVisit);
    }

    private function updateAggregate(
        Visit $visit,
        int $level,
        ?Visit $previousVisit,
        ?CountryAggregate $countryAggregate,
        ?Visit $nextVisit
    ): void {
        if (!$countryAggregate) {
            $countryAggregate = $this->createAggregate($visit, $level, $previousVisit, $nextVisit);
            $this->visitorFlowCountryRepository->save($countryAggregate);
            return;
        }
        if ($level > self::FIRST_LEVEL) {
            $this->updatePreviousAggregate($previousVisit, $level);
        }
        $countryAggregate->views++;
        $countryAggregate->exitCount++;
        $this->visitorFlowCountryRepository->save($countryAggregate);
    }

    private function createAggregate(
        Visit $currentVisit,
        int $level,
        ?Visit $previousVisit,
        ?Visit $nextVisit
    ): CountryAggregate {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $geoPosition = $this->geoPositionRepository->getById($currentVisit->geo_position_id);
        $prevPage = new PageValue();
        $isLastPage = true;
        $exitCount = 1;
        $views = 1;

        if ($nextVisit) {
            $nextAggregate = $this->getNextAggregate(
                $this->visitorFlowCountryRepository,
                $nextVisit,
                'null',
                $level + 1
            );
            if ($nextAggregate) {
                $prevPage = new PageValue($currentVisit->id, $page->url);
                $nextAggregate->setPrevPage($prevPage);
                $this->visitorFlowCountryRepository->save($nextAggregate);

                $exitCount = 0;
                $isLastPage = false;
            }
        }
        if ($level !== self::FIRST_LEVEL) {
            $previousAggregate = $this->updatePreviousAggregate($previousVisit, $level);
            if ($previousAggregate === null) {
                return new CountryAggregate(
                    $currentVisit->id,
                    $website->id,
                    $page->url,
                    $page->name,
                    $views,
                    $level,
                    $isLastPage,
                    $exitCount,
                    $geoPosition->country,
                    $prevPage
                );
            }
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->targetUrl);
        }
        return new CountryAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLastPage,
            $exitCount,
            $geoPosition->country,
            $prevPage
        );
    }

    private function updatePreviousAggregate(Visit $previousVisit, int $level): ?Aggregate
    {
        $previousAggregate = $this->getPreviousAggregate(
            $this->visitorFlowCountryRepository,
            $previousVisit,
            $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
            $level
        );
        if ($previousAggregate === null) {
            return null;
        }
        $previousAggregate->isLastPage = false;
        $previousAggregate->exitCount--;
        $this->visitorFlowCountryRepository->save($previousAggregate);
        return $previousAggregate;
    }

    private function getAggregate(
        Visit $visit,
        int $level,
        bool $isFirstInSession,
        ?Visit $previousVisit
    ): ?CountryAggregate {
        return $this->visitorFlowCountryRepository->getByCriteria(
            CountryCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $isFirstInSession ? 'null' : $previousVisit->page->url,
                $visit->geo_position->country
            )
        );
    }

    private function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowCountryRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ):?Aggregate {
        return $visitorFlowCountryRepository->getByCriteria(
            CountryCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $previousVisitUrl,
                $visit->geo_position->country
            )
        );
    }

    private function getNextAggregate(
        VisitorFlowRepository $visitorFlowCountryRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ):?Aggregate {
        return $visitorFlowCountryRepository->getByCriteria(
            CountryCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $previousVisitUrl,
                $visit->geo_position->country
            )
        );
    }
}
