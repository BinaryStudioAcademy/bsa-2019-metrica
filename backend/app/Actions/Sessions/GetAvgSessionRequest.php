<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Http\Requests\GetAvgSessionHttpRequest;

final class GetAvgSessionRequest
{
    private $startDate;
    private $endDate;

    private function __construct(GetAvgSessionHttpRequest $request) {
        $this->startDate = $request->startDate();
        $this->endDate = $request->endDate();
    }

    public static function fromRequest(GetAvgSessionHttpRequest $request): self
    {
        return new static(
            $request->startDate(),
            $request->endDate(),
        );
    }

    public function startDate(): int
    {
        return $this->startDate;
    }

    public function startDate(): int
    {
        return $this->endDate;
    }
}