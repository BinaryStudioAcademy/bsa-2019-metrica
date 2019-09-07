<?php

declare(strict_types=1);

namespace App\Actions\ErrorReports;

use App\Http\Requests\ErrorReports\AddErrorReportsHttpRequest;

final class AddErrorReportsActionRequest
{
    private $page;
    private $token;
    private $message;
    private $trackingNumber;
    private $stackTrace;
    private $pageTitle;

    private function __construct(
        string $page,
        string $message,
        string $trackingNumber,
        string $stackTrace,
        string $pageTitle,
        ?string $token
    ) {
        $this->page = $page;
        $this->message = $message;
        $this->trackingNumber = $trackingNumber;
        $this->stackTrace = $stackTrace;
        $this->pageTitle = $pageTitle;
        $this->token = $token;
    }

    public static function fromRequest(AddErrorReportsHttpRequest $request): self
    {
        return new static(
            $request->page(),
            $request->message(),
            $request->trackingNumber(),
            $request->stackTrace(),
            $request->pageTitle(),
            $request->token()
        );
    }

    public function page(): string
    {
        return $this->page;
    }

    public function message(): string
    {
        return $this->message;
    }
    public function trackingNumber(): string
    {
        return $this->trackingNumber;
    }

    public function stackTrace(): string
    {
        return $this->stackTrace;
    }
    public function pageTitle(): string
    {
        return $this->pageTitle;
    }

    public function token(): ?string
    {
        return $this->token;
    }
}
