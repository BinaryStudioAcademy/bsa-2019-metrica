<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\Visits\PageViewsItem;
use App\Entities\Page;
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
        $pagesId = Page::where('website_id', Auth::user()->website->id)->pluck('id')->toArray();

        $items = [];

        foreach ($pagesId as $id) {
            $all = $this->visitRepository->getCountPageViewsByPage($from, $to, $id);
            $bounced = $this->visitRepository->getCountBounceRateByPage($from, $to, $id);
            $bounceRate = ($all === 0) ? 0 : ($bounced/$all*100);
            $items[$id] = [
                'count_page_views' => $all,
                'bounce_rate' => $bounceRate
            ];
        }

        $collection = new Collection();
        foreach ($items as $item) {
            $collection->add(new PageViewsItem(
                '',
                '',
                $item['count_page_views'],
                (int)$item['bounce_rate'],
                0
            ));
        }

        return new GetPageViewsItemsResponse($collection);
    }
}