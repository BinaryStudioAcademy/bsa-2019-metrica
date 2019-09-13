<?php
declare(strict_types=1);

namespace App\Services\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\DeviceAggregate;
use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowDeviceRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\DeviceCriteria;

class FlowDeviceAggregateService extends FlowAggregateService
{
    private $pageRepository;
    private $websiteRepository;
    private $geoPositionRepository;
    private $visitorFlowDeviceRepository;

    public function __construct(
        PageRepository $pageRepository,
        VisitRepository $visitRepository,
        WebsiteRepository $websiteRepository,
        GeoPositionRepository $geoPositionRepository,
        VisitorFlowDeviceRepository $visitorFlowDeviceRepository
    ) {
        parent::__construct($visitRepository);
        $this->pageRepository = $pageRepository;
        $this->websiteRepository = $websiteRepository;
        $this->geoPositionRepository = $geoPositionRepository;
        $this->visitorFlowDeviceRepository = $visitorFlowDeviceRepository;
    }

    public function aggregate(Visit $visit): void
    {
        $previousVisit = $this->getPreviousVisit($visit);
        $isFirstInSession = $previousVisit === null;
        $level = $this->getLevel($visit, $isFirstInSession);
        $nextVisit = $this->getNextVisit($visit);
        $deviceAggregate = $this->getAggregate($visit, $level, $isFirstInSession, $previousVisit);

        $this->updateAggregate($visit, $level, $previousVisit, $deviceAggregate, $nextVisit);
    }

    private function updateAggregate(
        Visit $visit,
        int $level,
        ?Visit $previousVisit,
        ?DeviceAggregate $deviceAggregate,
        ?Visit $nextVisit
    ): void {
        if (!$deviceAggregate) {
            $deviceAggregate = $this->createAggregate($visit, $level, $previousVisit,$nextVisit);
            $this->visitorFlowDeviceRepository->save($deviceAggregate);
            return;
        }
        if ($level > self::FIRST_LEVEL) {
            $this->updatePrevious($previousVisit, $level);
        }
        $deviceAggregate->views++;
        $deviceAggregate->exitCount++;
        $this->visitorFlowDeviceRepository->save($deviceAggregate);
    }

    private function createAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit, ?Visit $nextVisit): DeviceAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $prevPage = new PageValue();
        $isLastPage = true;
        $exitCount = 1;
        $views = 1;

        if ($nextVisit) {
            $nextAggregate = $this->getNextAggregate(
                $this->visitorFlowDeviceRepository,
                $nextVisit,
                'null',
                $level + 1
            );
            if ($nextAggregate) {
                $prevPage = new PageValue($currentVisit->id, $page->url);
                $nextAggregate->setPrevPage($prevPage);
                $this->visitorFlowDeviceRepository->save($nextAggregate);
                $exitCount = 0;
                $isLastPage = false;
            }
        }

        if ($level !== self::FIRST_LEVEL) {
            $previousAggregate = $this->updatePrevious($previousVisit, $level);
            if ($previousAggregate === null) {
                return new DeviceAggregate(
                    $currentVisit->id,
                    $website->id,
                    $page->url,
                    $page->name,
                    $views,
                    $level,
                    $isLastPage,
                    $exitCount,
                    $currentVisit->session->system->device,
                    $prevPage
                );
            }
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->targetUrl);
        }
        return new DeviceAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLastPage,
            $exitCount,
            $currentVisit->session->system->device,
            $prevPage
        );
    }

    private function updatePrevious(Visit $previousVisit, int $level):Aggregate
    {
        $previousAggregate = $this->getPreviousAggregate(
            $this->visitorFlowDeviceRepository,
            $previousVisit,
            $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
            $level
        );
        $previousAggregate->isLastPage = false;
        $previousAggregate->exitCount--;
        $this->visitorFlowDeviceRepository->save($previousAggregate);
        return  $previousAggregate;
    }

    private function getAggregate(
        Visit $visit,
        int $level,
        bool $isFirstInSession,
        ?Visit $previousVisit
    ): ?DeviceAggregate {
        return $this->visitorFlowDeviceRepository->getByCriteria(
            DeviceCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $isFirstInSession ? 'null' : $previousVisit->page->url,
                $visit->session->system->device
            )
        );
    }

    private function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowDeviceRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ) {
        return $visitorFlowDeviceRepository->getByCriteria(
            DeviceCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $previousVisitUrl,
                $visit->session->system->device
            )
        );
    }

    private function getNextAggregate(
        VisitorFlowRepository $visitorFlowDeviceRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    )
    {
        return $visitorFlowDeviceRepository->getByCriteria(
            DeviceCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level,
                $previousVisitUrl,
                $visit->geo_position->country
            )
        );
    }
}
