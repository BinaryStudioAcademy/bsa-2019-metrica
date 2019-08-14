<?php
declare(strict_types=1);

namespace App\Actions\Visitors;


use App\Model\Visitors\VisitorsBounceRateResponseItem;
use Illuminate\Support\Collection;

final class BounceRateResponse
{

    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return VisitorsBounceRateResponseItem[]
     */
    public function getVisitorsBounceRateCollection(): Collection
    {
        return $this->collection;
    }

}
