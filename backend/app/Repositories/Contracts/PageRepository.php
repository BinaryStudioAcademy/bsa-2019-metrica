<?php

namespace App\Repositories\Contracts;

use App\Entities\Page;

interface PageRepository
{
    public function getByParameters(int $websiteId, string $pageTitle, string $pageUrl): ?Page;

    public function save(Page $page): Page;
}
