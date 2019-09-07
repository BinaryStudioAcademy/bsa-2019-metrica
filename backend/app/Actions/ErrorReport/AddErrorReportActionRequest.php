<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Http\Requests\ErrorReport\AddErrorReportsHttpRequest;

final class AddErrorReportActionRequest
{
    private $page;
    private $token;
    private $message;
    private $trackNumber;
    private $stackTrace;
    private $pageTitle;

    private function __construct(
        string $page,
        string $message,
        int $trackNumber,
        string $stackTrace,
        string $pageTitle,
        ?string $token
    ) {
        $this->page = $page;
        $this->message = $message;
        $this->trackNumber = $trackNumber;
        $this->stackTrace = $stackTrace;
        $this->pageTitle = $pageTitle;
        $this->token = $token;
    }

    public static function fromRequest(AddErrorReportsHttpRequest $request): self
    {
        return new static(
            $request->page(),
            $request->message(),
            (int) $request->trackNumber(),
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
    public function trackNumber(): int
    {
        return $this->trackNumber;
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
