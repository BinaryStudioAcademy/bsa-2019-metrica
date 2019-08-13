<?php
declare(strict_types=1);

namespace App\Actions\Website;

use App\Entities\Website;

abstract class AbstractWebsiteResponse
{
    private $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function getWebsite(): Website
    {
        return $this->website;
    }
}
