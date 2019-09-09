<?php

declare(strict_types=1);

namespace App\Actions\Website;

use Illuminate\Support\Collection;

final class GetRelateUserWebsitesResponse
{
    private $relateWebsites;

    public function __construct(Collection $relateWebsites)
    {
        $this->relateWebsites = $relateWebsites;
    }

    public function relateWebsites(): Collection
    {
        return $this->relateWebsites;
    }
}