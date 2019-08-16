<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Http\Requests\Api\GetBounceRateHttpRequest;
use Carbon\Carbon;

final class GetBounceRateRequest
{
    private $startDate;
    private $endDate;

    private function __construct(string $startDate, string $endDate)
    {
        $this->startDate = Carbon::createFromTimestamp($startDate)->toDateString();
        $this->endDate = Carbon::createFromTimestamp($endDate)->toDateString();
    }

    public static function fromRequest(GetBounceRateHttpRequest $request): self
    {
        return new static($request->startDate(), $request->endDate());
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }
}