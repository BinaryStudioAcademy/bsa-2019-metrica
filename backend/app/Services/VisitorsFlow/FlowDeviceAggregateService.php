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
        $previousVisit = $this->getLastVisit($visit);
        $isFirstInSession = $previousVisit === null;
        $level = $this->getLevel($visit, $isFirstInSession);

        $deviceAggregate = $this->getDeviceAggregate($visit, $level, $isFirstInSession, $previousVisit);

        $this->updateDeviceAggregate($visit, $level, $previousVisit, $deviceAggregate);
    }

    private function updateDeviceAggregate(
        Visit $visit,
        int $level,
        ?Visit $previousVisit,
        ?DeviceAggregate $deviceAggregate
    ): void {
        if (!$deviceAggregate) {
            $deviceAggregate = $this->createDeviceAggregate($visit, $level, $previousVisit);
            $this->visitorFlowDeviceRepository->save($deviceAggregate);
            return;
        }
        if ($level > self::FIRST_LEVEL) {
            $previousAggregate = $this->getPreviousDeviceAggregate(
                $this->visitorFlowDeviceRepository,
                $previousVisit,
                $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
                $level
            );
            $previousAggregate->isLastPage = false;
            $previousAggregate->exitCount--;
            $this->visitorFlowDeviceRepository->save($previousAggregate);
        }
        $deviceAggregate->views++;
        $deviceAggregate->exitCount++;
        $this->visitorFlowDeviceRepository->save($deviceAggregate);
    }

    private function createDeviceAggregate(Visit $currentVisit, int $level, ?Visit $previousVisit): DeviceAggregate
    {
        $page = $this->pageRepository->getById($currentVisit->page_id);
        $website = $this->websiteRepository->getById($page->website_id);
        $prevPage = new PageValue();
        if ($level !== self::FIRST_LEVEL) {
            $previousAggregate =$this->getPreviousDeviceAggregate(
                $this->visitorFlowDeviceRepository,
                $previousVisit,
                $level > 2 ? ($this->getPreviousVisit($previousVisit))->page->url : 'null',
                $level
            );
            $previousAggregate->isLastPage = false;
            $previousAggregate->exitCount--;
            $this->visitorFlowDeviceRepository->save($previousAggregate);
            $prevPage = new PageValue($previousVisit->id, $previousAggregate->targetUrl);
        }
        $exitCount = 1;
        $isLatPage = true;
        $views = 1;
        return new DeviceAggregate(
            $currentVisit->id,
            $website->id,
            $page->url,
            $page->name,
            $views,
            $level,
            $isLatPage,
            $exitCount,
            $currentVisit->session->system->device,
            $prevPage
        );
    }

    private function getDeviceAggregate(Visit $visit, int $level, bool $isFirstInSession, ?Visit $previousVisit): ?DeviceAggregate
    {
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

    private function getPreviousDeviceAggregate(
        VisitorFlowRepository $visitorFlowDeviceRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ): Aggregate {
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
}
