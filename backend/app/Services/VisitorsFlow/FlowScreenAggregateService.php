<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\ScreenAggregate;
use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowScreenRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\ScreenCriteria;

class FlowScreenAggregateService extends FlowAggregateService
{
    private $pageRepository;
    private $websiteRepository;
    private $geoPositionRepository;
    private $visitorFlowScreenRepository;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository,
        WebsiteRepository $websiteRepository,
        GeoPositionRepository $geoPositionRepository,
        VisitorFlowScreenRepository $visitorFlowScreenRepository
    ) {
        parent::__construct($visitRepository);
        $this->pageRepository = $pageRepository;
        $this->websiteRepository = $websiteRepository;
        $this->geoPositionRepository = $geoPositionRepository;
        $this->visitorFlowScreenRepository = $visitorFlowScreenRepository;
    }


    public function aggregate(Visit $visit): void
    {
        $previousVisit = $this->getLastVisit($visit);
        $isFirstInSession = $previousVisit === null;
        $level = $this->getLevel($visit, $isFirstInSession);

        $screenAggregate = $this->getScreenAggregate($visit, $level, $isFirstInSession, $previousVisit);

        $this->updateScreenAggregate($visit, $level, $previousVisit, $screenAggregate);
    }

    private function updateScreenAggregate(
        Visit $visit,
        int $level,
        ?Visit $previousVisit,
        ?ScreenAggregate $screenAggregate
    ): void {
        if (!$screenAggregate) {
            $screenAggregate = $this->createScreenAggregate($visit, $level, $previousVisit);
            $this->visitorFlowScreenRepository->save($screenAggregate);
            return;
        }
        if ($level > self::FIRST_LEVEL) {
            $previousAggregate = $this->getPreviousScreenAggregate(
                $this->visitorFlowScreenRepository,
                $previousVisit,
                $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
                $level
            );
            $previousAggregate->isLastPage = false;
            $previousAggregate->exitCount--;
            $this->visitorFlowScreenRepository->save($previousAggregate);
        }
        $screenAggregate->views++;
        $screenAggregate->exitCount++;
        $this->visitorFlowScreenRepository->save($screenAggregate);
    }

    private function createScreenAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit): ScreenAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $prevPage = new PageValue();
        if ($level !== self::FIRST_LEVEL) {
            $previousAggregate = $this->getPreviousScreenAggregate(
                $this->visitorFlowScreenRepository,
                $previousVisit,
                $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
                $level
            );
            $previousAggregate->isLastPage = false;
            $previousAggregate->exitCount--;
            $this->visitorFlowScreenRepository->save($previousAggregate);
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->targetUrl);
        }
        $exitCount = 1;
        $isLatPage = true;
        $views = 1;
        return new ScreenAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLatPage,
            $exitCount,
            $currentVisit->session->system->resolution_width,
            $currentVisit->session->system->resolution_height,
            $prevPage
        );
    }

    private function getScreenAggregate(Visit $visit, int $level, bool $isFirstInSession, ?Visit $previousVisit): ?ScreenAggregate
    {
        return $this->visitorFlowScreenRepository->getByCriteria(
            ScreenCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $isFirstInSession ? 'null' : $previousVisit->page->url,
                $visit->session->system->resolution_width,
                $visit->session->system->resolution_height
            )
        );
    }

    private  function getPreviousScreenAggregate(
        VisitorFlowRepository $visitorFlowScreenRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ): Aggregate {
        return $visitorFlowScreenRepository->getByCriteria(
            ScreenCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $previousVisitUrl,
                $visit->session->system->resolution_width,
                $visit->session->system->resolution_height
            )
        );
    }
}


