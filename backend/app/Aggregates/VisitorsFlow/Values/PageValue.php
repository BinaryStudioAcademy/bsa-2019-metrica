<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow\Values;

class PageValue
{
    public $id;
    public $url;

    public function __construct(int $id = null, string $url = 'null')
    {
        $this->id = $id;
        $this->url = $url;
    }
}
