<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;

use Illuminate\Support\Collection;

class GetVisitorFlowResponse
{
    private $parameterViews;
    private $visitorsFlow;

    public function __construct(Collection $visitorsFlow, Collection $parameterViews = null)
    {
        $this->parameterViews = $parameterViews;
        $this->visitorsFlow = $visitorsFlow;
    }

    public function getCollection(): Collection
    {
        if ($this->parameterViews) {
            return collect(
                ['parameter_views' => $this->parameterViews,
                    'visitors_flow' => $this->visitorsFlow
                ]
            );
        }
        return collect(
            [
                'visitors_flow' => $this->visitorsFlow
            ]
        );
    }
}
