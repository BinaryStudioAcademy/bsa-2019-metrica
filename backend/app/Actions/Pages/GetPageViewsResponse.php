<?php

declare(strict_types=1);

namespace App\Actions\Pages;

final class GetPageViewsResponse
{
    private $previews;

    public function __construct($previews)
    {
        $this->previews = $previews;
    }

    public function previews(): int
    {
        return $this->previews;
    }

}