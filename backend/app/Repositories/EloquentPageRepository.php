<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Page;
use App\Repositories\Contracts\PageRepository;

final class EloquentPageRepository implements PageRepository
{
    public function getPageViews(Page $page): int
    {
        return $page->previews;
    }

    public function getPageById(int $id): Page
    {
        return Page::findOrFail($id);
    }
}