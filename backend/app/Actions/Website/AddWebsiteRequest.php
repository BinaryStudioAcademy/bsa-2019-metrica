<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Http\Requests\AddWebsiteHttpRequest;

final class AddWebsiteRequest
{
    private $name;
    private $domain;
    private $single_page;
    private $tracking_number;

    public function __construct(
        string $name,
        string $domain,
        bool $single_page,
        int $tracking_number
    ) {
        $this->name = $name;
        $this->domain = $domain;
        $this->single_page = $single_page;
        $this->tracking_number = $tracking_number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getSinglePage(): bool
    {
        return $this->single_page;
    }

    public function getTrackingNumber(): int
    {
        return $this->tracking_number;
    }

    public static function fromHttpRequest(AddWebsiteHttpRequest $request): WebsiteRequest
    {
        return new static(
            $request->get('name'),
            $request->get('domain'),
            $request->get('single_page'),
            $request->get('tracking_number')
        );
    }
}
