<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Entities\Website;

final class AddWebsiteResponse
{
    private $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function website(): Website
    {
        return $this->website;
    }
}