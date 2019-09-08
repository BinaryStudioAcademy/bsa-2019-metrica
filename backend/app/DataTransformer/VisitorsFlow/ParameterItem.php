<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;


class ParameterItem
{
    private $title;
    private $count;

    public function __construct(array $item)
    {
        $this->title = $item['key'];
        $this->count = (int)$item['views']['value'];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
