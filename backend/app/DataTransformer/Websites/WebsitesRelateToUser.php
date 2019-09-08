<?php

declare(strict_types=1);

namespace App\DataTransformer\Websites;

final class WebsitesRelateToUser
{
    private $id;
    private $name;
    private $domain;
    private $single_page;
    private $tracking_number;
    private $user_role;
    private $menu_items;

    public function __construct(
        int $id,
        string $name,
        string $domain,
        bool $single_page,
        string $tracking_number,
        string $user_role,
        string $menu_items
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->domain = $domain;
        $this->single_page = $single_page;
        $this->tracking_number = $tracking_number;
        $this->user_role = $user_role;
        $this->menu_items = $menu_items;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function singlePage(): bool
    {
        return $this->single_page;
    }

    public function trackingNumber(): string
    {
        return $this->tracking_number;
    }

    public function userRole(): string
    {
        return $this->user_role;
    }

    public function menuItems(): string
    {
        return $this->menu_items;
    }
}