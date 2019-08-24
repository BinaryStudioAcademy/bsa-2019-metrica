<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Http\Requests\Website\AddWebsiteHttpRequest;

final class AddWebsiteRequest
{
    private $name;
    private $domain;
    private $singlePage;

    private function __construct(
        string $name,
        string $domain,
        ?bool $singlePage
    ) {
        $this->name = $name;
        $this->domain = $domain;
        $this->singlePage = $singlePage;
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
        return $this->singlePage ?? false;
    }

    public static function fromRequest(AddWebsiteHttpRequest $request): self
    {
        return new static(
            $request->name(),
            $request->domain(),
            $request->singlePage()
        );
    }
}
