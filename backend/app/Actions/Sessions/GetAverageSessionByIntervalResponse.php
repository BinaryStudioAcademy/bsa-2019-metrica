<?php
declare(strict_types=1);

namespace App\Actions\Sessions;

use Illuminate\Support\Collection;

final class GetAverageSessionByIntervalResponse
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function getSessionByIntervalCollection(): Collection
    {
        return $this->collection;
    }
}
