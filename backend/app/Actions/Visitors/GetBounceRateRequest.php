<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Http\Requests\Visitor\GetBounceRateHttpRequest;
use App\Utils\DatePeriod;

final class GetBounceRateRequest
{
    private $period;

    private function __construct(string $startDate, string $endDate)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
    }

    public static function fromRequest(GetBounceRateHttpRequest $request): self
    {
        return new static($request->startDate(), $request->endDate());
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }
}