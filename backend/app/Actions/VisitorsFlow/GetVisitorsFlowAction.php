<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;


use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowCountryRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowDeviceRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowScreenRepository;

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
    )
    {
        $this->visitorsFlowCountryRepository = $visitorFlowCountryRepository;
        $this->visitorsFlowBrowserRepository = $visitorFlowBrowserRepository;
        $this->visitorsFlowDeviceRepository = $visitorFlowDeviceRepository;
        $this->visitorsFlowScreenRepository = $visitorFlowScreenRepository;
    }

    public function execute(GetVisitorsFlowRequest $request): GetVisitorFlowResponse
    {
        $websiteId = auth()->user()->website->id;
        switch ($request->getType()) {
            case 'browser':
                $browsersViews = $this->visitorsFlowBrowserRepository->getViewsByEachBrowser($request->getType(), $websiteId);
                $browsersFlow = $this->visitorsFlowBrowserRepository->getFlow($websiteId);
                return new GetVisitorFlowResponse($browsersViews->getCollection(), $browsersFlow->getCollection());
                break;
            case 'country':
                break;
            case 'device':
                break;
            case 'screen':
                break;
        }
    }
}
