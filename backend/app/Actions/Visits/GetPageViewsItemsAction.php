<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\Visits\PageViewsItem;
use App\Repositories\Contracts\TablePageViewsRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class GetPageViewsItemsAction
{
    private $visitRepository;

    public function __construct(TablePageViewsRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function execute(GetPageViewsItemsRequest $request): GetPageViewsItemsResponse
    {
        $from = $request->startDate();
        $to = $request->endDate();
        $websiteId = Auth::user()->website->id;

        $all = $this->visitRepository->getCountPageViewsByPage($from, $to, $websiteId);
        $bounced = $this->visitRepository->getCountBounceRateByPage($from, $to, $websiteId);
        $exitRates = $this->visitRepository->getCountExitRateByPage($from, $to, $websiteId);
        $pageNamesAndTitles = $this->visitRepository->getPageNamesAndTitles($from, $to, $websiteId);

        $collection = new Collection();
        foreach ($all as $key => $item) {
            $collection->add(new PageViewsItem(
                $pageNamesAndTitles[$key]['url'],
                $pageNamesAndTitles[$key]['title'],
                $item,
                (int)(($item === 0 || !array_key_exists($key, $bounced)) ? 0 : ($bounced[$key]/$item*100)),
                array_key_exists($key, $exitRates) ? (int)$exitRates[$key] : 0
            ));
        }

        return new GetPageViewsItemsResponse($collection);
    }
}