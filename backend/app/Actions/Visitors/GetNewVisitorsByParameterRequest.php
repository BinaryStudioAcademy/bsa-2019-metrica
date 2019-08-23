<?php
declare(strict_types=1);
namespace App\Actions\Visitors;

use App\Http\Requests\Api\GetTableNewVisitorsByParameterHttpRequest;
use Carbon\Carbon;

final class GetNewVisitorsByParameterRequest
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

    public static function fromRequest(GetTableNewVisitorsByParameterHttpRequest $request): self
    {
        return new static($request->startDate(), $request->endDate(), $request->parameter());
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