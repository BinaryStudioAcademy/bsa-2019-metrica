<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;

use Illuminate\Support\Collection;

class GetVisitorFlowResponse
{
    private $parameterViews;
    private $visitorsFlow;

    public function __construct(Collection $parameterViews, Collection $visitorsFlow)
    {
        $this->parameterViews = $parameterViews;
        $this->visitorsFlow = $visitorsFlow;
    }

    public function getCollection(): Collection
    {
        return collect(
            ['parameter_views' => $this->parameterViews,
                'visitors_flow' => $this->visitorsFlow
            ]
        );
    }
}
