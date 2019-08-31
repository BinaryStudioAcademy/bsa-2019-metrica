<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Http\Requests\Visit\CreateVisitHttpRequest;

final class CreateVisitRequest
{
    private $page;
    private $pageTitle;
    private $language;
    private $device;
    private $resolutionWidth;
    private $resolutionHeight;
    private $userAgent;
    private $ip;
    private $token;
    private $pageLoadTime;
    private $serverResponseTime;
    private $domainLookupTime;

    private function __construct(
        string $page,
        string $pageTitle,
        string $language,
        string $device,
        int $resolutionWidth,
        int $resolutionHeight,
        string $userAgent,
        string $ip,
        string $token,
        ?int $pageLoadTime,
        ?int $serverResponseTime,
        ?int $domainLookupTime
    ) {
        $this->page = $page;
        $this->pageTitle = $pageTitle;
        $this->language = $language;
        $this->device = $device;
        $this->resolutionWidth = $resolutionWidth;
        $this->resolutionHeight = $resolutionHeight;
        $this->userAgent = $userAgent;
        $this->ip = $ip;
        $this->token = $token;
        $this->pageLoadTime = $pageLoadTime;
        $this->serverResponseTime = $serverResponseTime;
        $this->domainLookupTime = $domainLookupTime;
    }

    public static function fromRequest(CreateVisitHttpRequest $request): self
    {
        return new static(
            $request->page(),
            $request->pageTitle(),
            $request->language(),
            $request->device(),
            $request->resolutionWidth(),
            $request->resolutionHeight(),
            $request->userAgent(),
            $request->ip(),
            $request->token(),
            $request->pageLoadTime(),
            $request->serverResponseTime(),
            $request->domainLookupTime()
        );
    }

    public function page(): string
    {
        return $this->page;
    }

    public function pageTitle(): string
    {
        return $this->pageTitle;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function device(): string
    {
        return $this->device;
    }

    public function resolutionWidth(): int
    {
        return $this->resolutionWidth;
    }

    public function resolutionHeight(): int
    {
        return $this->resolutionHeight;
    }

    public function userAgent(): string
    {
        return $this->userAgent;
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function getPageLoadTime(): ?int
    {
        return $this->pageLoadTime;
    }

    public function getServerResponseTime(): ?int
    {
        return $this->serverResponseTime;
    }

    public function getDomainLookupTime(): ?int
    {
        return $this->domainLookupTime;
    }
}
