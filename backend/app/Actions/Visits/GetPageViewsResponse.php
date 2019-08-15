<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use Illuminate\Database\Eloquent\Collection;

final class GetPageViewsResponse
{
    private $views;

    public function __construct(Collection $views)
    {
        $this->views = $views;
    }

    public function views(): Collection
    {
        return $this->views;
    }
}
