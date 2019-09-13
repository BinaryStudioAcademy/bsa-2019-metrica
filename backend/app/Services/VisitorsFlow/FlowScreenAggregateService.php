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
        $previousVisit = $this->getPreviousVisit($visit);
        $isFirstInSession = $previousVisit === null;
        $level = $this->getLevel($visit, $isFirstInSession);
        $nextVisit = $this->getNextVisit($visit);
        $screenAggregate = $this->getAggregate($visit, $level, $isFirstInSession, $previousVisit);

        $this->updateAggregate($visit, $level, $previousVisit, $screenAggregate, $nextVisit);
    }

    private function updateAggregate(
        Visit $visit,
        int $level,
        ?Visit $previousVisit,
        ?ScreenAggregate $screenAggregate,
        ?Visit $nextVisit
    ): void {
        if (!$screenAggregate) {
            $screenAggregate = $this->createAggregate($visit, $level, $previousVisit, $nextVisit);

            $this->visitorFlowScreenRepository->save($screenAggregate);
            return;
        }
        if ($level > self::FIRST_LEVEL) {
            $this->updatePrevious($previousVisit, $level);
        }
        $screenAggregate->views++;
        $screenAggregate->exitCount++;
        $this->visitorFlowScreenRepository->save($screenAggregate);
    }

    private function createAggregate(
        Visit $currentVisit,
        int $level,
        ?Visit $previousVisit,
        ?Visit $nextVisit
    ): ScreenAggregate {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $prevPage = new PageValue();
        $isLastPage = true;
        $exitCount = 1;
        $views = 1;
        if ($nextVisit) {
            $nextAggregate = $this->getNextAggregate(
                $this->visitorFlowScreenRepository,
                $nextVisit,
                'null',
                $level + 1
            );
            if ($nextAggregate) {
                $prevPage = new PageValue($currentVisit->id, $page->url);
                $nextAggregate->setPrevPage($prevPage);
                $this->visitorFlowScreenRepository->save($nextAggregate);
                $exitCount = 0;
                $isLastPage = false;
            }
        }

        if ($level !== self::FIRST_LEVEL) {
            $previousAggregate = $this->updatePrevious($previousVisit, $level);
            if ($previousAggregate === null) {
                return new ScreenAggregate(
                    $currentVisit->id,
                    $website->id,
                    $page->url,
                    $page->name,
                    $views,
                    $level,
                    $isLastPage,
                    $exitCount,
                    $currentVisit->session->system->resolution_width,
                    $currentVisit->session->system->resolution_height,
                    $prevPage
                );
            }
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->targetUrl);
        }

        return new ScreenAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLastPage,
            $exitCount,
            $currentVisit->session->system->resolution_width,
            $currentVisit->session->system->resolution_height,
            $prevPage
        );
    }

    private function updatePrevious(Visit $previousVisit, int $level):Aggregate
    {
        $previousAggregate = $this->getPreviousAggregate(
            $this->visitorFlowScreenRepository,
            $previousVisit,
            $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
            $level
        );
        $previousAggregate->isLastPage = false;
        $previousAggregate->exitCount--;
        $this->visitorFlowScreenRepository->save($previousAggregate);
        return  $previousAggregate;
    }

    private function getAggregate(
        Visit $visit,
        int $level,
        bool $isFirstInSession,
        ?Visit $previousVisit
    ): ?ScreenAggregate {
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

    private function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowScreenRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ):?Aggregate {
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

    private function getNextAggregate(
        VisitorFlowRepository $visitorFlowScreenRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ):?Aggregate {
        return $visitorFlowScreenRepository->getByCriteria(
            ScreenCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $previousVisitUrl,
                $visit->session->system->resolution_width,
                $visit->session->system->resolution_height
            )
        );
    }
}


