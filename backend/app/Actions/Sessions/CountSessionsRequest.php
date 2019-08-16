<?php

declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Http\Requests\Api\CountSessionsHttpRequest;

final class CountSessionsRequest
{
    private $startDate;
    private $endDate;

    private function __construct(int $startDate, int $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public static function fromHttpRequest(CountSessionsHttpRequest $request): self
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

    public function endDate(): int
    {
        return $this->endDate;
    }
}
