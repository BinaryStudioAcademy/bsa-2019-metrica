<?php

declare(strict_types=1);

namespace App\DataTransformer\Teams;

final class TeamMember
{
    private $name;
    private $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}