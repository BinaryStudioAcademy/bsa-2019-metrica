<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Events\VisitCreated;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\BrowserCriteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;

class FlowBrowserAggregateService extends FlowAggregateService
{
    private $pageRepository;
    private $websiteRepository;
    private $geoPositionRepository;
    private $visitorFlowBrowserRepository;
    private $visit;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository,
        WebsiteRepository $websiteRepository,
        GeoPositionRepository $geoPositionRepository,
        VisitorFlowBrowserRepository $visitorFlowBrowserRepository
    ) {
        parent::__construct($visitRepository);
        $this->pageRepository = $pageRepository;
        $this->websiteRepository = $websiteRepository;
        $this->geoPositionRepository = $geoPositionRepository;
        $this->visitorFlowBrowserRepository = $visitorFlowBrowserRepository;
    }

    public function aggregate(Visit $visit): void
    {
        $this->visit = $visit;
        $previousVisit = $this->getLastVisit($visit);
        $isFirstInSession = $previousVisit === null;
        $level = $this->getLevel($visit, $isFirstInSession);

        $browserAggregate = $this->getAggregate($visit, $level, $isFirstInSession, $previousVisit);

        $this->updateAggregate($visit, $level, $previousVisit, $browserAggregate);
    }

    private function updateAggregate(
        Visit $visit,
        int $level,
        ?Visit $previousVisit,
        ?BrowserAggregate $browserAggregate
    ): void {
        if (!$browserAggregate) {
            $browserAggregate = $this->createAggregate($visit, $level, $previousVisit);
            $this->visitorFlowBrowserRepository->save($browserAggregate);
            return;
        }
        if ($level > self::FIRST_LEVEL) {
            $this->updatePreviousAggregate($previousVisit, $level);
        }
        $browserAggregate->views++;
        $browserAggregate->exitCount++;
        $this->visitorFlowBrowserRepository->save($browserAggregate);
    }

    private function createAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit): BrowserAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $prevPage = new PageValue();
        if ($level !== self::FIRST_LEVEL) {
            $previousAggregate = $this->updatePreviousAggregate($previousVisit, $level);
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->targetUrl);
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

    private function updatePreviousAggregate(Visit $previousVisit, int $level):Aggregate
    {
        $previousAggregate = $this->getPreviousAggregate(
            $this->visitorFlowBrowserRepository,
            $previousVisit,
            $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
            $level
        );
        $previousAggregate->isLastPage = false;
        $previousAggregate->exitCount--;
        $this->visitorFlowBrowserRepository->save($previousAggregate);
        return $previousAggregate;
    }

    private function getAggregate(
        Visit $visit,
        int $level,
        bool $isFirstInSession,
        ?Visit $previousVisit
    ): ?BrowserAggregate {
        return $this->visitorFlowBrowserRepository->getByCriteria(
            BrowserCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $isFirstInSession ? 'null' : $previousVisit->page->url,
                $visit->session->system->browser
            )
        );
    }

    private function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowBrowserRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ): Aggregate {
        return $visitorFlowBrowserRepository->getByCriteria(
            BrowserCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $previousVisitUrl,
                $visit->session->system->browser
            )
        );
    }
}
