<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Http\Requests\GetAvgSessionsTimeByParameterHttpRequest;
use Carbon\Carbon;

final class GetAvgSessionsTimeByParameterRequest
{
    private $startDate;
    private $endDate;
    private $parameter;

    private function __construct(string $startDate, string $endDate, string $parameter)
    {
        $this->startDate = Carbon::createFromTimestamp($startDate)->toDateString();
        $this->endDate = Carbon::createFromTimestamp($endDate)->toDateString();
        $this->parameter = $parameter;
    }

    public static function fromRequest(GetAvgSessionsTimeByParameterHttpRequest $request): self
    {
        return new static(
            $request->startDate(),
            $request->endDate(),
            $request->parameter()
        );
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }

    public function parameter(): string
    {
        return $this->parameter;
    }
}