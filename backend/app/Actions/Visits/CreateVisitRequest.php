<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

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

    private function __construct(
        string $page,
        string $pageTitle,
        string $language,
        string $device,
        int $resolutionWidth,
        int $resolutionHeight,
        string $userAgent,
        string $ip,
        string $token
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
            $request->token()
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
}
