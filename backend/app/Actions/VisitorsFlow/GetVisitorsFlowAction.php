<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;

use App\DataTransformer\VisitorsFlow\ParameterFlowItem;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowCountryRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowDeviceRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowScreenRepository;
use Illuminate\Support\Collection;

class GetVisitorsFlowAction
{
    private $visitorsFlowCountryRepository;
    private $visitorsFlowBrowserRepository;
    private $visitorsFlowDeviceRepository;
    private $visitorsFlowScreenRepository;

    public function __construct(
        VisitorFlowCountryRepository $visitorFlowCountryRepository,
        VisitorFlowBrowserRepository $visitorFlowBrowserRepository,
        VisitorFlowDeviceRepository $visitorFlowDeviceRepository,
        VisitorFlowScreenRepository $visitorFlowScreenRepository
    ) {
        $this->visitorsFlowCountryRepository = $visitorFlowCountryRepository;
        $this->visitorsFlowBrowserRepository = $visitorFlowBrowserRepository;
        $this->visitorsFlowDeviceRepository = $visitorFlowDeviceRepository;
        $this->visitorsFlowScreenRepository = $visitorFlowScreenRepository;
    }

    public function execute(GetVisitorsFlowRequest $request): GetVisitorFlowResponse
    {
        $websiteId = auth()->user()->website->id;
        switch ($request->getParameter()) {
            case 'browser':
                if ($request->getLevel() > 2) {
                    $browsersFlow = $this->visitorsFlowBrowserRepository->getFlow($websiteId, $request->getLevel());
                    $filtered = $this->filter($browsersFlow->getCollection());
                    return new GetVisitorFlowResponse($filtered);
                }
                $browsersViews = $this->visitorsFlowBrowserRepository->getViewsByEachBrowser($request->getParameter(), $websiteId);
                $browsersFlow = $this->visitorsFlowBrowserRepository->getFlow($websiteId, $request->getLevel());
                $filtered = $this->filter($browsersFlow->getCollection());
                return new GetVisitorFlowResponse($filtered, $browsersViews->getCollection());
            case 'country':
                if ($request->getLevel() > 2) {
                    $countriesFlow = $this->visitorsFlowCountryRepository->getFlow($websiteId, $request->getLevel());
                    $filtered = $this->filter($countriesFlow->getCollection());
                    return new GetVisitorFlowResponse($filtered);
                }
                $countriesViews = $this->visitorsFlowCountryRepository->getViewsByEachCountry($request->getParameter(), $websiteId);
                $countriesFlow = $this->visitorsFlowCountryRepository->getFlow($websiteId, $request->getLevel());
                $filtered = $this->filter($countriesFlow->getCollection());
                return new GetVisitorFlowResponse($filtered, $countriesViews->getCollection());
            case 'device':
                if ($request->getLevel() > 2) {
                    $devicesFlow = $this->visitorsFlowDeviceRepository->getFlow($websiteId, $request->getLevel());
                    $filtered = $this->filter($devicesFlow->getCollection());
                    return new GetVisitorFlowResponse($filtered);
                }
                $devicesViews = $this->visitorsFlowDeviceRepository->getViewsByEachDevice($request->getParameter(), $websiteId);
                $devicesFlow = $this->visitorsFlowDeviceRepository->getFlow($websiteId, $request->getLevel());
                $filtered = $this->filter($devicesFlow->getCollection());
                return new GetVisitorFlowResponse($filtered, $devicesViews->getCollection());
            case 'screen':
                if ($request->getLevel() > 2) {
                    $screensFlow = $this->visitorsFlowScreenRepository->getFlow($websiteId, $request->getLevel());
                    $filtered = $this->filter($screensFlow->getCollection());
                    return new GetVisitorFlowResponse($filtered);
                }
                $screensViews = $this->visitorsFlowScreenRepository->getViewsByEachScreen($websiteId);
                $screensFlow = $this->visitorsFlowScreenRepository->getFlow($websiteId, $request->getLevel());
                $filtered = $this->filter($screensFlow->getCollection());
                return new GetVisitorFlowResponse($filtered, $screensViews->getCollection());
        }
    }

    private function filter(Collection $collection): Collection
    {
        $result = collect();
        $collection->each(function (ParameterFlowItem $item) use (&$result) {
            $found = false;
            foreach ($result as $resItem) {
                if ($resItem->getTargetUrl() === $item->getTargetUrl() && $resItem->getLevel() === $item->getLevel()
                    && $resItem->getSourceUrl() === $item->getSourceUrl()) {
                    $resItem->setViews($item->getViews());
                    $resItem->setExitCount($item->getExitCount());
                    $found = true;
                    break;
                }
            }
            if ($found === false) {
                $result->add($item);
            }
        });
        return $result;
    }
}
