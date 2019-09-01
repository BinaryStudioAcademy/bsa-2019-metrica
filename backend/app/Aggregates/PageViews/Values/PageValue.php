<?php

declare(strict_types=1);

namespace App\Aggregates\PageViews\Values;

use Carbon\Carbon;

final class PageValue
{
    public $id;
    public $url;
    public $title;
    public $createdAt;

    public function __construct(
        int $id,
        string $url,
        string $title,
        Carbon $createdAt
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->createdAt = $createdAt;
    }
}
