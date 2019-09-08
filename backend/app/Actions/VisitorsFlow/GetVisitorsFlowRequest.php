<?php
declare(strict_types=1);

namespace App\Actions\VisitorsFlow;

use App\Http\Requests\VisitorsFlow\GetVisitorsFlowHttpRequest;

class GetVisitorsFlowRequest
{
    private $parameter;
    private $level;

    public function __construct(string $parameter, int $level)
    {
        $this->parameter = $parameter;
        $this->level = $level;
    }

    public static function fromRequest(GetVisitorsFlowHttpRequest $request): self
    {
        return new static(
            $request->getParameter(),
            $request->getLevel()
        );
    }

    public function getParameter(): string
    {
        return $this->parameter;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
}
