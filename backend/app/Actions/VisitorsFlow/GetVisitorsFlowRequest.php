<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;

use App\Http\Requests\VisitorsFlow\GetVisitorsFlowHttpRequest;

class GetVisitorsFlowRequest
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function fromRequest(GetVisitorsFlowHttpRequest $request): self
    {
        return new static(
            $request->getType()
        );
    }

    public function getType(): string
    {
        return $this->type;
    }
}
