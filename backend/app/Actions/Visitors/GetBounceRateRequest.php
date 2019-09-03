<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Http\Requests\Visitor\GetBounceRateHttpRequest;
use App\Utils\DatePeriod;

final class GetBounceRateRequest
{
    private $period;
    private $websiteId;

    private function __construct(string $startDate, string $endDate, int $websiteId)
    {
        $this->period = DatePeriod::createFromTimestamp($startDate, $endDate);
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(GetBounceRateHttpRequest $request): self
    {
        return new static(
            $request->startDate(),
            $request->endDate(),
            $request->websiteId()
        );
    }

    public function period(): DatePeriod
    {
        return $this->period;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}