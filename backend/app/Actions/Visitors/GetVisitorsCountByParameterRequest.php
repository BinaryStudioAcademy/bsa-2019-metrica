<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Http\Requests\Visitor\GetTableVisitorsByParameterHttpRequest;
use Carbon\Carbon;

final class GetVisitorsCountByParameterRequest
{
    private $startDate;
    private $endDate;
    private $parameter;
    private $websiteId;


    private function __construct(string $startDate, string $endDate, string $parameter, int $websiteId)
    {
        $this->startDate = Carbon::createFromTimestamp($startDate)->toDateTimeString();
        $this->endDate = Carbon::createFromTimestamp($endDate)->toDateTimeString();
        $this->parameter = $parameter;
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(GetTableVisitorsByParameterHttpRequest $request): self
    {
        return new static(
            $request->startDate(),
            $request->endDate(),
            $request->parameter(),
            $request->websiteId()
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

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}