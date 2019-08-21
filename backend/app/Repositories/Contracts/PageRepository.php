<?php

namespace App\Repositories\Contracts;

use App\Entities\Page;

interface PageRepository
{
    public function getByParameters(string $websiteId, string $pageTitle, string $pageUrl): ?Page;
}
