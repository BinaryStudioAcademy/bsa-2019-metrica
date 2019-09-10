<?php

declare(strict_types=1);

namespace App\DataTransformer\Teams;

final class TeamMember
{
    private $id;
    private $name;
    private $email;
    private $menu;

    public function __construct(int $id, string $name, string $email, $menu)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->menu = $menu;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function menu(): string
    {
        return $this->menu;
    }

}