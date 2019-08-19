<?php
declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Model\Visitors\ChartBounceRateItem;
use Illuminate\Support\Collection;

final class BounceRateResponse
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return ChartBounceRateItem[]
     */
    public function getVisitorsBounceRateCollection(): Collection
    {
        return $this->collection;
    }
}
