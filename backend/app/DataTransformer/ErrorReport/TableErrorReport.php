<?php

declare(strict_types=1);

namespace App\DataTransformer\ErrorReport;

use App\DataTransformer\Traits\TableValueTrait;

final class TableErrorReport
{
    use TableValueTrait;

    private $parameter;
    private $parameterValue;
    private $total;
    private $message;
    private $stackTrace;

    public function __construct(
        string $parameter,
        string $parameterValue,
        string $total,
        string $message,
        string $stackTrace
    ) {
        $this->parameter = $parameter;
        $this->parameterValue = $parameterValue;
        $this->total = $total;
        $this->message = $message;
        $this->stackTrace = $stackTrace;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function stackTrace(): string
    {
        return $this->stackTrace;
    }
}