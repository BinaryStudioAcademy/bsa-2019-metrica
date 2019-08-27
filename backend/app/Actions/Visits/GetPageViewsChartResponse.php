<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use Illuminate\Support\Collection;

final class GetPageViewsChartResponse
{
    private $chartData;

    public function __construct(Collection $chartData)
    {
        $this->chartData = $chartData;
    }

    public function chartData(): Collection
    {
        return $this->chartData;
    }
}
