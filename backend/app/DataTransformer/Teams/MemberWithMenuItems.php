<?php

declare(strict_types=1);

namespace App\DataTransformer\Teams;

final class MemberWithMenuItems
{
    private $userId;
    private $websiteId;
    private $menuItems;

    public function __construct(int $userId, int $websiteId, array $menuItems)
    {
        $this->userId = $userId;
        $this->websiteId = $websiteId;
        $this->menuItems = $menuItems;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }

    public function menuItems(): array
    {
        return $this->menuItems;
    }
}