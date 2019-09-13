<?php

declare(strict_types=1);

namespace App\DataTransformer\ErrorReport;

use App\DataTransformer\Traits\TableValueTrait;
use Carbon\Carbon;

final class TableErrorReport
{
    use TableValueTrait;

    private $parameter;
    private $parameterValue;
    private $total;
    private $message;
    private $stackTrace;
    private $maxCreated;

    public function __construct(
        string $parameter,
        string $parameterValue,
        string $total,
        string $message,
        string $stackTrace,
        string $maxCreated
    ) {
        $this->parameter = $parameter;
        $this->parameterValue = $parameterValue;
        $this->total = $total;
        $this->message = $message;
        $this->stackTrace = $stackTrace;
        $this->maxCreated = (new Carbon($maxCreated))->timestamp;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function stackTrace(): string
    {
        return $this->stackTrace;
    }

    public function maxCreated(): int
    {
        return $this->maxCreated;
    }
}