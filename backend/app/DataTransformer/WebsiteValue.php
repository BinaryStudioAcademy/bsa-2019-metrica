<?php

declare(strict_types=1);

namespace App\DataTransformer;

final class WebsiteValue
{
    private $id;
    private $domain;
    private $role;

    public function __construct(int $id, string $domain, string $role)
    {
        $this->id = $id;
        $this->domain = $domain;
        $this->role = $role;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function role(): string
    {
        return $this->role;
    }
}