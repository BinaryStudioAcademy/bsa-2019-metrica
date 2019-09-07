<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\VisitorsFlow\GetVisitorsFlowAction;
use App\Http\Controllers\Controller;

final class VisitorsFlow extends Controller
{
    private $getVisitorsFlowAction;

    public function __construct(GetVisitorsFlowAction $getVisitorsFlowAction)
    {
        $this->getVisitorsFlowAction = $getVisitorsFlowAction;
    }

    public function getVisitorsFlow()
    {

    }
}
