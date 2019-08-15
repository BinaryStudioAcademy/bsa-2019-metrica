<?php

namespace App\Contracts;

interface ApiResponse
{
    public function toArray($request): array;
}