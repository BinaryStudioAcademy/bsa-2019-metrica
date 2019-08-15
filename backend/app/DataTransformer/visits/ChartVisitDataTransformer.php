<?php

namespace App\DataTransformer\visits;

use App\DataTransformer\DataTransformerInterface;
use Illuminate\Database\Eloquent\Collection;

class ChartVisitDataTransformer implements DataTransformerInterface
{
    private $rawResult;
    public function __construct($rawResult = [])
    {
        $this->rawResult = $rawResult;
    }

    public function modelsFromRawResults(): Collection
    {
        $array = [];

        foreach($this->rawResult as $result)
        {
            $data = [
                'date' => $result->date,
                'visits' => $result->visits,
            ];

            $array[] = $data;
        }

        return new Collection($array);
    }
}
