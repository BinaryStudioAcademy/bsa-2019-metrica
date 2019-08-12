<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Page;

interface PageRepository
{
    public function getPageViews(Page $page): int;

    public function getPageById(int $id): Page;
}