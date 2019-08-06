<?php

namespace App\Contracts;

interface ApiException
{
    public function getStatus(): int;
    public function toArray(): array;
}