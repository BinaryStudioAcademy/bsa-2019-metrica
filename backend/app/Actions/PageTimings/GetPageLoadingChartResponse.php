<?php


namespace App\Actions\PageTimings;


use Illuminate\Support\Collection;

class GetPageLoadingChartResponse
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }
}

