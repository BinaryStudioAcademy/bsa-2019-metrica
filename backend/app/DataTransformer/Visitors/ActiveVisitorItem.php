<?php

declare(strict_types=1);

namespace App\DataTransformer\Visitors;

final class ActiveVisitorItem
{
    private $url;
    private $visitor;
    private $date;

    public function __construct(
        string $url,
        int $visitor,
        string $date
    ) {
        $this->url = $url;
        $this->visitor = $visitor;
        $this->date = $date;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function visitor(): int
    {
        return $this->visitor;
    }

    public function date(): string
    {
        return $this->date;
    }
}
