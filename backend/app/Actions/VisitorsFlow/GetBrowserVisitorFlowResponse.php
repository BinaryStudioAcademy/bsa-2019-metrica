<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;


use Illuminate\Support\Collection;

class GetBrowserVisitorFlowResponse
{
    private $browsersViews;
    private $browsersFlow;

    public function __construct(Collection $browsersViews, Collection $browsersFlow)
    {
        $this->browsersViews = $browsersViews;
        $this->browsersFlow = $browsersFlow;
    }

    public function getCollection(): Collection
    {
        return collect(
            ['browsers_views' => $this->browsersViews,
                'browsers_flow' => $this->browsersFlow
            ]
        );
    }
}
