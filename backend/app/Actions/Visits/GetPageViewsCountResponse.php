<?php
declare(strict_types=1);

namespace App\Actions\Visitors;

final class GetPageViewsCountResponse
{
    private $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
