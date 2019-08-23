<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Page;
use App\Repositories\Contracts\PageRepository;

final class EloquentPageRepository implements PageRepository
{
    public function getByParameters(int $websiteId, string $pageTitle, string $pageUrl): ?Page
    {
        return Page::where([
            ['website_id', $websiteId],
            ['name', $pageTitle],
            ['url', $pageUrl]
        ])->first();
    }

    public function save(Page $page): Page
    {
        $page->save();
        return $page;
    }
}
